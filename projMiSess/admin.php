<?php
session_start();

// Check if user is already logged in

// Display login form
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styleco.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <title>Connexion admin</title>
</head>
<body>
    <?php 
        $formVisible = "flex";
        $barreMenuAdmin = "none";
        $basAdmin = "none";
        $messageErreurConnexion = "";

        // Événements
        $pageEvent = "none";
        $pageAccueil = "none";
        $afficherliste = "none";
        $formCreation = "block";
        $formModif = "none";
        $contextBodyCreaEvent = "none";
        $messageContexte = "";
        $boutonRetourEvent = "none";
        $idBarreBas = "existePas";
        $titreCarteEvent = "Création d'événement";
        $valueDateEvent = $valueLieuEvent = $valueNomEvent = $valueProgramme = "";

        // Users
        $pageUsers = "none";
        $listeUsers = "none";
        $formModifUser = "none";
        $formUserCr = "block";
        $boutonRetourUser = "none";
        $adminUser = 0;
        $contextBodyCreaUser = "none";
        $messageCreaUser = "";
        $boutonRetourUser = "none";
        $mdpValide = false;
        $formModifUser = "none";

        // Alertes
        $stadeAlerte = "";
        $Message = "";

        // Theme
        $CardHeader = "bg-bleuCegep border-rouge-cegep";
        $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
        $CardFooter = "bg-bleuCegep border-rouge-cegep";
        $Table = "fontCegep bleuCegep";
        $Bouton = "bgLilasCegep border-rouge-cegep rounded";
        $TextBouton = "fontCegep bleuCegep fw-bold fs-4";
        $BtnA = "btn bgLilasCegep border-rouge-cegep";
        $TextBtnA = "fontCegep fw-bold bleuCegep";
        $TextCardHeader = "lilasCegep fw-bold text-center fontCegep";
        $TextCardBody = "bleuCegep fw-bold fontCegep";
        $TextErreur = "rougeCegep fw-bold fontCegep";
        $Label = "fontCegep bleuCegep fw-bold fs-6";
        $borderInput = "rounded text-center border-bleuCegep";
        $BarreAdmin = "bg-bleuCegep";
        $Background = "background1";

        // Connexion à la base de données
        $servername = "cours.cegep3r.info";
        $username = "2230572";
        $password = "2230572";
        $dbname = "2230572-mathis-grondin";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");

        // Check connection
        if($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Si la page est appelée en POST
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["courriel"]) && isset($_POST["mdp"])) {

            $courriel = $_POST["courriel"];
            $mdp = sha1($_POST["mdp"]);

            $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
            $result = $conn->query($sql);
            

            if($result->num_rows > 0) {
                $_SESSION["user"] = $courriel;
                $formVisible = "none";
                $barreMenuAdmin = "block";
                $basAdmin = "block";

                // check if user is admin
                $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
                    $messageErreurConnexion = "";
                    while($row = $result->fetch_assoc()) {
                        if($row["admin"] == 1) {
                            $_SESSION["admin"] = true;
                        }
                        else {
                            $_SESSION["admin"] = false;
                        }
                    }
                }
            }
            else {
                $messageErreurConnexion = "Les identifiants fournis sont invalides";
            }
        }
        else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user"])){

            //SET permissions selon rôle

            // Si un utilisateur (Admin ici) essaie de créer un événement 
            if(isset($_SESSION["user"]) && $_SESSION["admin"] == true){

                
            }
            else{
                $formVisible = "flex";
                $barreMenuAdmin = "none";
            }

            // Si un utilisateur (Admin ici) essaie de créer un utilisateur 
            if(isset($_SESSION["user"]) && $_SESSION["admin"] == true){
                if(isset($_POST["nomUser"], $_POST["prenomUser"], $_POST["courriel"], $_POST["mdp1"], $_POST["mdp2"]) && $_POST["nomUser"] != "" && $_POST["prenomUser"] != "" && $_POST["courriel"] != "" && $_POST["mdp1"] != "" && $_POST["mdp2"] != "") {
                    $nomUser = $_POST["nomUser"];
                    $prenomUser = $_POST["prenomUser"];
                    $courriel = $_POST["courriel"];
                    $mdp1 = sha1($_POST["mdp1"]);
                    $mdp2 = sha1($_POST["mdp2"]);
                                    
                    $placeQuoteNomUser = stripos($nomUser, '\'');
                    $placeQuotePrenom = stripos($prenomUser, '\'');
                    $placeQuoteCourriel = stripos($courriel, '\'');
                    
                    if($placeQuoteNomUser != null){
                        $substringNomUser = substr($nomUser, 0, $placeQuoteNomUser);
                        echo $substringNomUser . "<br>";
                    }
                    else{
                        echo $nomUser . "<br>";
                        $substringNomUser = $nomUser;
                    }
                    
                    if($placeQuotePrenom != null){
                        $substringPrenom = substr($prenomUser, 0, $placeQuotePrenom);
                        echo $substringPrenom . "<br>";
                    }
                    else{
                        echo $prenomUser . "<br>";
                        $substringPrenom = $prenomUser;
                    }
                
                    if($placeQuoteCourriel != null){
                        $substringCourriel = substr($courriel, 0, $placeQuoteCourriel);
                        echo $substringCourriel . "<br>";
                    }
                    else{
                        echo $courriel . "<br>";
                        $substringCourriel = $courriel;
                    }  
                
                    if($_POST["mdp1"] == $_POST["mdp2"]){
                        $mdpValide = true;
                    }    
                    else{
                        $mdpValide = false;
                    }               
                    
                    if(isset($_POST["checkAdmin"]) == true){
                        $adminUser = 1;                       
                    }
                    else{
                        $adminUser = 0;                        
                    }

                    $sql = "INSERT INTO users
                        VALUES (null, '$substringNomUser', '$substringPrenom', '$adminUser', '$substringCourriel', '$mdp1')";
                    $result = $conn->query($sql);
                    
                    echo $sql . "<br>";
                    echo $result;
                    
                    if($result && $mdpValide == true) {
                        header("Location: admin.php?page=users&state=0");
                    }
                    else {
                        header("Location: admin.php?page=users&state=3");
                    }
                }
                else if($_POST["nomUser"] == "" || $_POST["prenomUser"] == "" || $_POST["courriel"] == "" || $_POST["mdp1"] == "" || $_POST["mdp2"] == ""){
                    header("Location: admin.php?page=users&state=2");
                }
                else if($mdpValide == false){
                    header("Location: admin.php?page=users&state=3");
                }
                else{
                    header("Location: admin.php?page=users&state=1");
                }
            }
            else{
                $formVisible = "flex";
                $barreMenuAdmin = "none";
            }
        }
        // Si la page est appelée en GET
        else if($_SERVER["REQUEST_METHOD"] == "GET"){

            if(isset($_SESSION["user"])){
                $formVisible = "none";
                $barreMenuAdmin = "block";

                // page de création d'événement
                if(isset($_GET["page"])){
                    $page = $_GET["page"];

                    if($page == "events"){ include("pageEvent.php"); }
                    else if($page == "users"){ include("pageUsers.php"); }
                    else if($page == "accueil") {
                        $pageAccueil = "block";
                        $barreMenuAdmin = "block";
                        $formCreation = "none";
                    }
                    else if($page == "deco") {
                        try{
                            session_unset();
                            session_destroy();
                        }
                        catch(Exception $e){
                            echo "Erreur lors de la déconnexion";
                        }
                        header("Location: admin.php");
                    }
                    else if($page == "themes") {
                        include("themes.php");
                    }
                    else if($page == "stats"){
                        $formVisible = "none";
                        $barreMenuAdmin = "none";                        
                    }
                }

                if(!isset($_GET["page"])){
                    $basAdmin = "block";
                }
                else{
                    $basAdmin = "none";}                
            }
            else{
                $formVisible = "flex";
                $barreMenuAdmin = "none";
            }
        }
        // sinon
        else{
            $formVisible = "none";
            $barreMenuAdmin = "none";
            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="offset col-xl-4"></div>
                    <div class="col-xl-4">
                        <div class="alert alert-danger">
                            <h6>La page demandée n'est pas accessible sans être administrateur, merci de vous connecter</h6>
                            <br>
                            <a href="index.php">Retour à la page de vote</a>
                        </div>
                    </div>
                    <div class="offset col-xl-4"></div>
                </div>
            </div>
            <?php
        }
    ?>

    <!-- Formulaire -->
    <div class="container-fluid h-100 w-100 justify-content-center align-items-center p-0 m-0 <?php echo $Background; ?>" style="display: <?php echo $formVisible; ?>">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w-25 d-flex align-items-center justify-content-center">
            <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="col-xl-12 w-100">
                    <div class="card w-100">
                        <!-- Entete -->
                        <div class="card-header <?php echo $CardHeader; ?>">
                            <h2 class="<?php echo $TextCardHeader; ?> ">Connexion admin</h2>
                        </div>
                        <!-- Courriel et MDP  -->
                        <div class="card-body d-flex justify-content-evenly flex-column <?php echo $CardBody; ?>">
                            <div class="d-flex justify-content-between">
                                <label for="courriel" class="<?php echo $Label; ?>">Courriel</label>
                                <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="<?php echo $borderInput; ?>">
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <label for="mdp" class="<?php echo $Label; ?>">Mot de passe</label>
                                <input type="password" name="mdp" class="<?php echo $borderInput; ?>">
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3 text-center w-100">
                                <span class="<?php echo $TextErreur; ?>"><?php echo $messageErreurConnexion; ?></span>
                            </div>                                
                        </div>

                        <!-- Bouton de connexion -->
                        <div class="card-footer d-flex justify-content-center bg bg-bleuCegep border-rouge-cegep">
                            <button type="submit" class="btn bgLilasCegep border-rouge-cegep w-50 fontCegep bleuCegep fw-bold" >Connexion</button>
                        </div>                        
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Barre de menu Admin  -->
    <nav class="navbar fixed-top p-0 m-0">
        <div class="container-fluid h-auto" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu" id="contNav">
            <div class="row p-3 h-100 d-flex align-items-center <?php echo $BarreAdmin; ?>" id="rowMenu">
             
            <!-- icone Événement -->
            <div class="col">
                <a href="admin.php?page=events" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/event.png" alt="Événements" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Événements</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- icone users -->
            <div class="col">
                <a href="admin.php?page=users" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/user.png" alt="Utilisateurs" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Utilisateurs</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- icone stats -->
            <div class="col">
                <a href="statistiques.php" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/stats.png" alt="Statistiques" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Statistiques</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- icone accueil -->
            <div class="col">
                <a href="admin.php?page=accueil" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/accueil.png" alt="Accueil" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Accueil</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- icone déconnexion -->
            <div class="col">
                <a href="admin.php?page=deco" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/deconnexion.png" alt="Deconnexion" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Déconnexion</h5>
                        </div>
                    </div>
                </a>
            </div>

            <!-- icone themes -->
            <div class="col">
                <a href="admin.php?page=themes" class="<?php echo $BtnA; ?>">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/theme.png" alt="Theme" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Thèmes</h5>
                        </div>
                    </div>
                </a>
            </div>

            </div>        
        </div>
    </nav>

    <!-- Bas de page admin : Arrivée -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $basAdmin; ?>">
        <div class="row h-100 d-flex justify-content-center align-items-center" id="rowWelcome">
            <div class="offset col-xl-2 col-2"></div>
            
            <!-- message de bienvenue -->
            <div class="col-xl-8 col-8">
                <?php 
                    $user = $_SESSION["user"];

                    $sql = "SELECT nom FROM users WHERE email = '$user'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $userNom = $row["nom"];

                    $sql = "SELECT prenom FROM users WHERE email = '$user'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $userPrenom = $row["prenom"];
                ?>
                <h1 class="text-center fontCegep bleuCegep fw-bold">Bienvenue sur la page <br><?php echo $userPrenom . " " . $userNom?></h1>
            </div>

            <div class="offset col-xl-2 col-2"></div>
        </div>
    </div>

    <!-- Bas de page admin : Événements -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>"  style="display: <?php echo $pageEvent; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowEvent">
            <div class="col-xl-6 h-75 d-flex align-items-center">
                
            <!-- Entete Création Événement -->
                <div class="card h-75 w-100">
                    <div class="card-header p-2 d-flex align-items-center justify-content-center <?php echo $CardHeader; ?>">
                        <img src="icones/event.png" alt="crEvent" id="iconUser">
                        <h3 class="p-0 m-0 <?php echo $TextCardHeader; ?>" id="titreCarteModifier"><?php echo $titreCarteEvent; ?></h3>
                    </div>
                    
                    <!-- Formulaire de création d'événement -->
                    <form method="post" action="creaEvent.php"  style="display: <?php echo $formCreation ?>" class="h-100" >
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                            <!-- Données du formulaire  -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="dateEvent" class="<?php echo $Label; ?>">Date</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" name="dateEvent" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="lieuEvent" class="<?php echo $Label; ?>">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEvent" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomEvent" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEvent" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme" class="<?php echo $Label; ?>">Programme</label>
                                </div>
                                <div class="col-8">
                                    <select name="programme" class="form-control <?php echo $borderInput; ?>">
                                        <?php

                                            $sql = "SELECT * FROM programmes";
                                            $result = $conn->query($sql);

                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
                                                }
                                            }  
                                            else {
                                                echo "<option value=''>Aucun programme</option>";
                                            }                                 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bas Création Événement -->
                        <div class="card-footer p-2 m-0 d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">
                            
                            <!-- Bouton Créer Événement -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-75 <?php echo $Bouton; ?>">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="icones/ajouter.png" alt="créer" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>" >Créer</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Bouton Consulter Liste -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=events&action=consulter" class="m-0 p-0 w-75 <?php echo $BtnA; ?>">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Consulter</span>
                                    </div>
                                </a>                                                                       
                            </div>

                            <!-- Bouton Retour vers l'accueil -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="reset" class="rounded p-0 m-0 w-75 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Annuler</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Formulaire de modification --> 
                    <form method="post" action="pageEvent.php"  style="display: <?php echo $formModif; ?>" class="h-100" >
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                            <!-- données du formulaire -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="idEvent" class="<?php echo $Label; ?>">ID</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="idEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $idEvent; ?>" readonly>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="dateEvent" class="<?php echo $Label; ?>">Date</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" name="dateEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueDateEvent; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="lieuEvent" class="<?php echo $Label; ?>">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueLieuEvent; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomEvent" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEventModif" class="form-control <?php echo $borderInput; ?>"  value="<?php echo $valueNomEvent; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme" class="<?php echo $Label; ?>">Programme</label>
                                </div>
                                <div class="col-8">
                                    <select name="programmeModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueProgramme; ?>">
                                        <?php
                                            $sql = "SELECT * FROM programmes";
                                            $result = $conn->query($sql);

                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
                                                }
                                            }  
                                            else {
                                                echo "<option value=''>Aucun programme</option>";
                                            }                                  
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bas Modification Événement -->
                        <div class="card-footer p-2 m-0 d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-100 <?php echo $Bouton; ?>">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="icones/modifier.png" alt="créer" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>" >Modifier</span>
                                    </div>
                                </button>
                            </div>

                            <div class="col-4 d-flex justify-content-center">
                                <button type="reset" class="p-0 m-0 w-100 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">Retour</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Body contexte sur ajout -->
                    <div class="card-body <?php echo $CardBody; ?>" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row w-100">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h4 class="<?php echo $TextCardBody; ?>"><?php echo $messageContexte; ?></h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer <?php echo $CardFooter; ?>p" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>
                        
                    <div class="card-body h-25 listeOverflow <?php echo $CardBody; ?>" style="display: <?php echo $afficherliste; ?>">
                        <table class="w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">#</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Nom</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Date</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Lieu</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Programme</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Modifier</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                    $sql = "SELECT * FROM evenements";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr class="text-center border-bottom border-dark">
                                                    <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"]; ?></th>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nom"]; ?></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["date"]; ?></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["lieu"]; ?></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["programme"]; ?></td>
                                                    <td>
                                                        <a href='admin.php?page=events&action=Modifier&id=<?php echo $row["id"] ?>'>
                                                            <img src="icones/modifier.png">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href='admin.php?page=events&action=Supprimer&id=<?php echo $row["id"] ?>'>
                                                            <img src="icones/supprimer.png" class="icons">
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        echo "<tr><td colspan='5'>Aucun événement</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- bas du formulaire d'ajout -->
                    <div class="card-footer w-100 align-items-center justify-content-center <?php echo $CardFooter; ?>" style="display: <?php echo $boutonRetourEvent; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100"  style="display : <?php echo $boutonRetourEvent; ?>">
                            <div class="col-4">
                                <a href="admin.php?page=events" class="w-100 d-flex align-items-center justify-content-center <?php echo $BtnA; ?>">
                                    <img src="icones/retour.png" alt="annuler" style="width: 60px;">
                                    <span class="<?php echo $TextBtnA; ?>" >Retour au formulaire</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bas de page admin : Utilisateurs -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $pageUsers; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowUsers">
            <div class="col-xl-6 h-75 d-flex align-items-center">

                <!-- Card pour création d'un user -->
                <div class="card h-75 w-100">                                   
                    <div class="card-header py-2 d-flex align-items-center justify-content-center <?php echo $CardHeader; ?>">
                        <img src="icones/admin.png" alt="crUser" id="iconUser">
                        <h3 class="p-0 m-0 <?php echo $TextCardHeader; ?>" id="titreUserCr">Création d'un utilisateur</h3>
                    </div> 
                    
                    <!-- formulaire de création d'un utilisateur -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="display: <?php echo $formUserCr ?>" class="h-100">
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">                                    
                                            <label for="checkAdmin" class="form-check-label <?php echo $Label; ?>">Admin</label>                                   
                                            <input type="checkbox" id="checkAdmin" name="checkAdmin" class="form-check-input ms-1 <?php echo $borderInput; ?>">  
                                </div>     
                                <div class="col-8 d-flex align-items-center">
                                            <img src="icones/alerte.png" alt="annuler" class="icons">
                                            <h5 class="fs-6 m-0 p-0 <?php echo $TextErreur; ?>">Un admin a tous les droits</h5>
                                            <img src="icones/alerte.png" alt="annuler" class="icons">
                                </div>
                            </div>      
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomUser" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomUser" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="prenomUser" class="<?php echo $Label; ?>">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUser" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="courriel" class="<?php echo $Label; ?>">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courriel" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp1" class="<?php echo $Label; ?>">Mot de passe</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp1" class="form-control <?php echo $borderInput; ?>">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp2" class="<?php echo $Label; ?>">Confirmation Mdp</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp2" class="form-control <?php echo $borderInput; ?>">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="offset col-4"></div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input <?php echo $borderInput; ?>" name="checkInfos" id="invalidCheck" required>
                                        <label for="invalidCheck" class="form-check-label <?php echo $Label; ?>">Je confirme que les informations sont exactes</label>
                                        <div class="invalid-feedback <?php echo $TextErreur; ?>">Vous devez confirmer les informations</div>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                        
                        <!-- bas formulaire utilisateur -->
                        <div class="card-footer d-flex align-items-center justify-content-evenly p-2 m-0 <?php echo $CardFooter; ?>">
                            <div class="col-4 d-flex justify-content-center">
                                <!-- bouton création -->
                                <button type="submit" class="w-75 p-0 m-0 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/ajouterAdminUser.png" alt="créerUser" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">Créer</span>
                                    </div>
                                </button>
                            </div>
                            <!-- bouton de la liste -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=users&action=consulter" class="w-75 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/modifierAdminUser.png" alt="modifierUser" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Consulter</span>
                                    </div>    
                                </a>                                                                       
                            </div>
                            <!-- bouton retour a l'accueil -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="reset" class="w-75 p-0 m-0 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">
                                            Annuler
                                        </span>
                                    </div>
                                </button>
                            </div>                           
                        </div>
                    </form>

                    <!-- Formulaire de modifification users -->
                    <form action="post" action="pageUsers.php" style="display : <?php echo $formModifUser?>" class="h-100">
                         <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                            <!-- données a modifier -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="idUser" class="<?php echo $Label; ?>">ID</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="idUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $idUser; ?>" readonly>
                                </div>          
                            </div>  
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomUser" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueNomUser; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="prenomUser" class="<?php echo $Label; ?>">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valuePrenomUser; ?>">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="courrielUser" class="<?php echo $Label; ?>">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courrielUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueCourrielUser; ?>">
                                </div>
                            </div>
                         </div>           
                    </form>

                    <!-- Bas du formulaire de modification -->
                    <div class="card-footer p-2 m-0 bg-d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">
                        <div class="col-6 d-flex justify-content center">
                            <button type="submit" class="w-100 <?php echo $Bouton; ?>">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px;">
                                    <span class="<?php echo $TextBouton; ?>">Modifier</span>
                                </div>
                            </button>
                        </div>       
                        
                        <div class="col-6 d-flex justify-content-center">
                            <a href="admin.php?page=users" class="w-75 m-0 p-0 <?php echo $BtnA; ?>">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px;">
                                    <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                </div>        
                            </a>
                        </div>
                    </div>
                    
                    <!-- Body sur ajout Users -->
                    <div class="card-body <?php echo $CardBody; ?>" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row w-100">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h4 class="<?php echo $TextCardBody; ?>"><?php echo $messageCreaUser; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer <?php echo $CardFooter; ?>" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>

                    <!-- Body liste Users -->
                    <div class="card-body h-25 listeOverflow <?php echo $CardBody; ?>" style="display: <?php echo $listeUsers; ?>">
                        <table class="w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">#</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Nom</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Prénom</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Admin</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Courriel</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Modifier</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                    $sql = "SELECT * FROM users";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            ?>
                                                <tr class="text-center border-bottom border-dark">
                                                    <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"] ?></th>
                                                    <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["nom"] ?></td>
                                                    <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["prenom"] ?></td>
                                                    <td class="<?php echo $Table; ?> my-3 py-3 fw-bold <?php echo $row["admin"] == 1?"rougeCegep":"bleuCegep" ?>"><?php echo $row["admin"] == 1?"Administrateur":"Utilisateur standard" ?></td>
                                                    <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["email"] ?></td>
                                                    <td>
                                                        <a href='admin.php?page=users&action=Modifier&id=<?php echo $row["id"] ?>'>
                                                            <img src="icones/modifier.png" class="icons">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href='admin.php?page=users&action=Supprimer&id=<?php echo $row["id"] ?>'>
                                                            <img src="icones/supprimer.png" class="icons">
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                    else {
                                        echo "<tr><td colspan='5'>Aucun événement</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- bas du formulaire de la liste -->
                    <div class="card-footer w-100 justify-content-center align-items-center <?php echo $CardFooter; ?>" style="display: <?php echo $boutonRetourUser; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100"  style="display : <?php echo $boutonRetourUser; ?>">
                            <div class="col-4">
                                <a href="admin.php?page=users" class="w-100 d-flex align-items-center justify-content-center <?php echo $BtnA; ?>">
                                    <img src="icones/retour.png" alt="retour" style="width: 60px;">
                                    <span class="<?php echo $TextBtnA; ?>">Retour au formulaire</span>
                                </a>
                            </div>                       
                        </div>                        
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bas de page admin : Accueil -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $pageAccueil; ?>;">
        <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="offset col-xl-3"></div>
            <div class="col-xl-6">

                <form action="add.php" method="post">
                    <div class="card">
                        <!-- entete de l'accueil -->
                        <div class="card-header py-2 <?php echo $CardHeader; ?>">
                            <div class="row w-100 h-50 py-2">
                                <div class="col-2 d-flex justify-content-center align-items-center w-25">
                                    <img src="icones/alerte.png" alt="infoImp" style="width: 40px; height: 40px">
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center w-50">
                                    <h3 class="p-0 my-0 <?php echo $TextCardHeader; ?>">
                                        Renseignements importants
                                    </h3>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center w-25">
                                    <img src="icones/alerte.png" alt="infoImp" style="width: 40px; height: 40px">
                                </div>
                            </div>
                        </div>
                        <!-- données du formulaire -->
                        <div class="card-body p-4 <?php echo $CardBody; ?>">
                            <div class="vstack gap-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eventvotes" class="<?php echo $Label; ?>">Événement auquel envoyer les votes</label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <select name="quelEvent" id="eventvotes" class="w-75 bleuCegep <?php echo $borderInput; ?>">
                                            <?php
                                                $sql = "SELECT * FROM evenements";
                                                $result = $conn->query($sql);
                                                if($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
                                                    }
                                                }
                                                else {
                                                    echo "<option value=''>Aucun événement</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="quiRepond" class="<?php echo $Label; ?>">Qui répondera au sondage sur cet appareil ? </label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <select name="quiRepond" id="quiRepond" class="w-75 bleuCegep <?php echo $borderInput; ?>">
                                            <option value="etudiant">Étudiants</option>
                                            <option value="employeur">Employeurs</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <span class="p-0 m-0 <?php echo $TextErreur; ?>">Vous serez déconnecté pour vous rendre à la page de vote</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- bas du formulaire de l'accueil -->
                        <div class="card-footer d-flex justify-content-center align-items-center <?php echo $CardFooter; ?>">
                            <div class="offset col-4"></div>
                            <div class="col-4 px-1 d-flex justify-content-center align-items-center">
                                <button type="submit" class="w-100 w-100 bleuCegep fontCegep fw-bold p-0 m-0 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/deconnexion.png" alt="deco" class="me-1">
                                        <span class="<?php echo $TextBouton; ?>">
                                            Page de votes
                                        </span>
                                    </div>
                                </button>
                            </div>
                            <div class="offset col-4"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="offset col-xl-3"></div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>
