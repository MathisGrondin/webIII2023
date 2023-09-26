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
        $contextBodyCreaEvent = "none";
        $messageContexte = "";
        $boutonRetourEvent = "none";
        $idBarreBas = "existePas";
        $titreCarteEvent = "Création d'événement";

        // Users
        $pageUsers = "none";
        $listeUsers = "none";
        $formUserCr = "block";
        $boutonRetourUser = "none";
        $adminUser = 0;
        $contextBodyCreaUser = "none";
        $messageCreaUser = "";
        $boutonRetourUser = "none";
        $mdpValide = false;

        // Alertes
        $stadeAlerte = "";
        $Message = "";


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

                if(isset($_POST["dateEvent"], $_POST["lieuEvent"], $_POST["nomEvent"], $_POST["programme"]) && $_POST["dateEvent"] != "" && $_POST["lieuEvent"] != "" && $_POST["nomEvent"] != "" && $_POST["programme"] != "") {
                    $dateEvent = $_POST["dateEvent"];
                    $lieuEvent = $_POST["lieuEvent"];
                    $nomEvent = $_POST["nomEvent"];
                    $programme = $_POST["programme"];
    
                    $placeQuoteLieu = stripos($lieuEvent, '\'');
                    $placeQuoteNom = stripos($nomEvent, '\'');
                    $placeQuoteProg = stripos($programme, '\'');
    
                    if($placeQuoteLieu != null){
                        $substringLieu = substr($lieuEvent, 0, $placeQuoteLieu);
                    }
                    else{
                        echo $lieuEvent . "<br>";
                        $substringLieu = $lieuEvent;
                    }
    
                    if($placeQuoteNom != null){
                        $substringNom = substr($nomEvent, 0, $placeQuoteNom);
                        echo $substringNom . "<br>";
                    }
                    else{
                        echo $nomEvent . "<br>";
                        $substringNom = $nomEvent;
                    }
                    if($placeQuoteProg != null){
                        $substringProg = substr($programme, 0, $placeQuoteProg);
                        $substringProg = $substringProg . "\\";
                        $substringProg = $substringProg . substr($programme, $placeQuoteProg);
                        echo $substringProg . "<br>";
                    }
                    else{
                        echo $programme . "<br>";
                        $substringProg = $programme;
                    }  
    
                    echo $programme . "<br>";
    
                    $sql = "INSERT INTO evenements
                            VALUES (null, '$substringNom', '$substringLieu', '$dateEvent', '$substringProg', 0, 0, 0, 0, 0, 0)";
                    $result = $conn->query($sql);
    
                    echo $sql . "<br>";
                    echo $result;
    
                    if($result) {
                        header("Location: admin.php?page=events&state=0");
                    }
                    else {
                        // echo $result;
                        header("Location: admin.php?page=events&state=1");
                    }
                }
                else if($_POST["dateEvent"] == "" || $_POST["lieuEvent"] == "" || $_POST["nomEvent"] == "" || $_POST["programme"] == ""){
                    header("Location: admin.php?page=events&state=2");
                }
                else{
                    // header("Location: admin.php?page=events&errCreation=1");
                    header("Location: admin.php?page=events&state=1");
                }
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
    <div class="container-fluid contConnex h-100 w-100 justify-content-center align-items-center p-0 m-0" style="display: <?php echo $formVisible; ?>">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w-25 d-flex align-items-center justify-content-center">
            <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                    <div class="col-xl-12 w-100">
                        <div class="card w-100">
                            <div class="card-header bg bg-bleuCegep border-rouge-cegep">
                                <h2 class="text-center lilasCegep fontCegep fw-bold">Connexion admin</h2>
                            </div>

                            <div class="card-body bgLilasCegep border-bleuCegep border-top-0 border-bottom-0 d-flex justify-content-evenly flex-column">
                                <div class="d-flex justify-content-between">
                                    <label for="courriel" class="fw-bold bleuCegep fontCegep">Courriel</label>
                                    <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="rounded text-center border-bleuCegep">
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <label for="mdp" class="fw-bold bleuCegep fontCegep">Mot de passe</label>
                                    <input type="password" name="mdp" class="rounded border-bleuCegep">
                                </div>
                                
                                <div class="d-flex justify-content-center mt-3 text-center w-100">
                                    <span class="fw-bold rougeCegep fontCegep"><?php echo $messageErreurConnexion; ?></span>
                                </div>
                                
                            </div>

                            <div class="card-footer d-flex justify-content-center bg bg-bleuCegep border-rouge-cegep">
                                <button type="submit" class="btn bgLilasCegep border-rouge-cegep w-50 fontCegep bleuCegep fw-bold" >Connexion</button>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>

    <!-- Barre de menu Admin -->
    <nav class="navbar fixed-top p-0 m-0">
        <div class="container-fluid h-auto" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu" id="contNav">
            <div class="row bgLilasCegep p-3 h-100 d-flex align-items-center" id="rowMenu">
                <div class="col">
                    <a href="admin.php?page=events" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/event.png" alt="Événements" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Événements</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="admin.php?page=users" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/user.png" alt="Utilisateurs" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Utilisateurs</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="statistiques.php" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/stats.png" alt="Statistiques" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Statistiques</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="admin.php?page=accueil" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/accueil.png" alt="Accueil" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Accueil</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a href="admin.php?page=deco" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/deconnexion.png" alt="Deconnexion" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Déconnexion</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="admin.php?page=themes" class="btn bg-bleuCegep border-rouge-cegep">
                        <div class="row ">
                            <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                                <img src="icones/theme.png" alt="Theme" class=" p-0 m-0 icone-menu">
                                <h5 class="p-0 m-0 lilasCegep fontCegep fw-bold">Thèmes</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>        
        </div>

    </nav>

    <!-- Bas de page admin : Arrivée -->
    <div class="container-fluid h-100 w-100" id="contWelcome" style="display: <?php echo $basAdmin; ?>">
        <div class="row h-100 d-flex justify-content-center align-items-center" id="rowWelcome">
            <div class="offset col-xl-2 col-2"></div>
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
    <div class="container-fluid h-100 w-100 " id="containerEvent" style="display: <?php echo $pageEvent; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowEvent">
            <div class="col-xl-6 h-75 d-flex align-items-center">
                <!-- Card pour création d'un événement -->
                <div class="card h-75 w-100">
                    <div class="card-header p-2 bg-bleuCegep border-rouge-cegep d-flex align-items-center justify-content-center">
                        <img src="icones/event.png" alt="crEvent" id="iconUser">
                        <h3 class="p-0 m-0 text-center lilasCegep fontCegep fw-bold" id="titreCarteModifier"><?php echo $titreCarteEvent; ?></h3>
                    </div>
                    
                    <!-- Formulaire de création d'événement -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="display: <?php echo $formCreation ?>" class="h-100" >
                        <div class="card-body h-100 w-100 bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep d-flex flex-column justify-content-evenly">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="dateEvent" class="fontCegep bleuCegep fw-bold fs-6">Date</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" name="dateEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="lieuEvent" class="fontCegep bleuCegep fw-bold fs-6">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomEvent" class="fontCegep bleuCegep fw-bold fs-6">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>

                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme" class="fontCegep bleuCegep fw-bold fs-6">Programme</label>
                                </div>
                                <div class="col-8">
                                    <select name="programme" class="form-control border-bleuCegep">

                                        <?php

                                            $sql = "SELECT * FROM programmes";
                                            $result = $conn->query($sql);

                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<option name='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
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

                        <div class="card-footer p-2 m-0 bg-bleuCegep d-flex align-items-center justify-content-evenly">

                                <div class="col-4 d-flex justify-content-center">
                                    <button type="submit" class="rounded bgLilasCegep border-rouge-cegep w-75">
                                        <div class=" d-flex align-items-center justify-content-center">
                                            <img src="icones/ajouter.png" alt="créer" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep" >Créer</span>
                                        </div>
                                    </button>
                                </div>

                                <div class="col-4 d-flex justify-content-center">
                                    <a href="admin.php?page=events&action=consulter" class="btn rounded bgLilasCegep border-rouge-cegep m-0 p-0 w-75">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep">Consulter</span>
                                        </div>
                                    </a>                                                                       
                                </div>

                                <div class="col-4 d-flex justify-content-center">
                                    <button type="reset" class="rounded bgLilasCegep border-rouge-cegep p-0 m-0 w-75">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep">Annuler</span>
                                        </div>
                                    </button>
                                </div>
                        </div>
                    </form>

                    <!-- Body contexte sur ajout -->
                    <div class="card-body bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep text-center" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row text-center w-100">
                            <div class="col-12 text-center d-flex justify-content-center align-items-center">
                                <h4 class="text-center"><?php echo $messageContexte; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg bg-bleuCegep border-rouge-cegep" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>
                        
                    <div class="card-body h-25 bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep listeOverflow" style="display: <?php echo $afficherliste; ?>">
                        <table class="w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">#</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Nom</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Date</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Lieu</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Programme</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Modifier</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Supprimer</th>
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
                                                    <th scope="row" class="font-cegep bleuCegep"><?php echo $row["id"]; ?></th>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["nom"]; ?></td>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["date"]; ?></td>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["lieu"]; ?></td>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["programme"]; ?></td>
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
                    <div class="card-footer bg-bleuCegep w-100 align-items-center justify-content-center" style="display: <?php echo $boutonRetourEvent; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100"  style="display : <?php echo $boutonRetourEvent; ?>">
                            <div class="col-4">
                                <a href="admin.php?page=events" class="btn bgLilasCegep border-rouge-cegep w-100 d-flex align-items-center justify-content-center">
                                    <img src="icones/retour.png" alt="annuler" class="fontCegep fw-bold" style="width: 60px;">
                                    <span>Retour au formulaire</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bas de page admin : Utilisateurs -->
    <div class="container-fluid h-100 w-100" id="containerUsers" style="display: <?php echo $pageUsers; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowUsers">
            <div class="col-xl-6 h-75 d-flex align-items-center">
                <!-- Card pour création d'un user -->
                <div class="card h-75 w-100">                                   
                    <div class="card-header py-2 bg bg-bleuCegep border-rouge-cegep d-flex align-items-center justify-content-center">
                        <img src="icones/admin.png" alt="crUser" id="iconUser">
                        <h3 class="lilasCegep text-center fontCegep fw-bold p-0 m-0" id="titreUserCr">Création d'un utilisateur</h3>
                    </div> 
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="display: <?php echo $formUserCr ?>" class="h-100">
                        <div class="card-body h-100 w-100 bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep d-flex flex-column justify-content-evenly">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">                                    
                                            <label for="checkAdmin" class="fontCegep bleuCegep fw-bold fs-6 form-check-label">Admin</label>                                   
                                            <input type="checkbox" id="checkAdmin" name="checkAdmin" class="form-check-input border-bleuCegep ms-1">  
                                </div>     
                                <div class="col-8 d-flex align-items-center">
                                            <img src="icones/alerte.png" alt="annuler" class="icons">
                                            <h5 class="fontCegep rougeCegep fw-bold fs-6 m-0 p-0">Un admin a tous les droits</h5>
                                            <img src="icones/alerte.png" alt="annuler" class="icons">
                                </div>
                             </div>       

                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomUser" class="fontCegep bleuCegep fw-bold fs-6">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomUser" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="prenomUser" class="fontCegep bleuCegep fw-bold fs-6">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUser" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="courriel" class="fontCegep bleuCegep fw-bold fs-6">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courriel" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp1" class="fontCegep bleuCegep fw-bold fs-6">Mot de passe</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp1" class="form-control border-bleuCegep">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp2" class="fontCegep bleuCegep fw-bold fs-6">Confirmation Mdp</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp2" class="form-control border-bleuCegep">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="offset col-4"></div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input border-bleuCegep" name="checkInfos" id="invalidCheck" required>
                                        <label for="invalidCheck" class="form-check-label fontCegep bleuCegep fw-bold">Je confirme que les informations sont exactes</label>
                                        <div class="invalid-feedback fontCegep rougeCegep fw-bold">Vous devez confirmer les informations</div>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                        
                        <div class="card-footer bg bg-bleuCegep d-flex align-items-center justify-content-evenly border-rouge-cegep p-2 m-0">
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-75 rounded bgLilasCegep border-rouge-cegep p-0 m-0">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/ajouterAdminUser.png" alt="créerUser" style="width: 60px; height: 60px">
                                        <span class="fs-4 fw-bold fontCegep bleuCegep">Créer</span>
                                    </div>
                                </button>
                            </div>
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=users&action=consulter" class="btn w-75 rounded bgLilasCegep border-rouge-cegep m-0 p-0">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/modifierAdminUser.png" alt="modifierUser" style="width: 60px; height: 60px">
                                        <span class="fs-4 fw-bold bleuCegep fontCegep">Consulter</span>
                                    </div>    
                                </a>                                                                       
                            </div>
                            <div class="col-4 d-flex justify-content-center">
                                <button type="reset" class="w-75 rounded bgLilasCegep border-rouge-cegep p-0 m-0">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                        <span class="fs-4 fw-bold fontCegep bleuCegep">
                                            Annuler
                                        </span>
                                    </div>
                                </button>
                            </div>                           
                        </div>
                    </form>


                    <!-- Body contexte sur ajout -->
                    <div class="card-body bgLilasCegep border-top-0 border-bottom-0 boder-bleuCegep text-center" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row text-center w-100">
                            <div class="col-12 text-center d-flex justify-content-center align-items-center">
                                <h4 class="text-center"><?php echo $messageCreaUser; ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg bg-bleuCegep border-rouge-cegep" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>

                    
                    <div class="card-body h-25 bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep listeOverflow" style="display: <?php echo $listeUsers; ?>">
                        <table class="w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">#</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Nom</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Prénom</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Admin</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Courriel</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Modifier</th>
                                    <th scope="col" class="font-cegep fw-bold bleuCegep">Supprimer</th>
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
                                                    <th scope="row" class="font-cegep bleuCegep"><?php echo $row["id"] ?></th>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["nom"] ?></td>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["prenom"] ?></td>
                                                    <td class="font-cegep my-3 py-3 fw-bold <?php echo $row["admin"] == 1?"rougeCegep":"bleuCegep" ?>"><?php echo $row["admin"] == 1?"Administrateur":"Utilisateur standard" ?></td>
                                                    <td class="font-cegep bleuCegep my-3 py-3"><?php echo $row["email"] ?></td>
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
                    <div class="card-footer w-100 bg-bleuCegep justify-content-center align-items-center border-rouge-cegep" style="display: <?php echo $boutonRetourUser; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100"  style="display : <?php echo $boutonRetourUser; ?>">
                            <div class="col-4">
                                <a href="admin.php?page=users" class="btn bgLilasCegep border-rouge-cegep w-100 fontCegep fw-bold d-flex align-items-center justify-content-center">
                                    <img src="icones/retour.png" alt="retour" class="fontCegep fw-bold" style="width: 60px;">
                                    <span>Retour au formulaire</span>
                                </a>
                            </div>                       
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bas de page admin : Accueil -->
    <div class="container-fluid h-100 w-100" id="containerAccueil" style="display: <?php echo $pageAccueil; ?>;">
        <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="offset col-xl-3"></div>
            <div class="col-xl-6">

                <form action="add.php" method="post">
                    <div class="card">
                        
                        <div class="card-header py-2 bg bg-bleuCegep border-rouge-cegep">
                            <div class="row w-100 h-50 py-2">
                                <div class="col-2 d-flex justify-content-center align-items-center w-25">
                                    <img src="icones/alerte.png" alt="infoImp" class="iconInfos mx-3">
                                </div>
                                <div class="col-9 d-flex justify-content-center align-items-center w-50">
                                    <h3 class="text-center lilasCegep fontCegep fw-bold p-0 my-0">
                                        Renseignements importants
                                    </h3>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center w-25">
                                    <img src="icones/alerte.png" alt="infoImp" class="iconInfos mx-3">
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4 bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                            <div class="vstack gap-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eventvotes" class="fontCegep bleuCegep fw-bold fs-6">Événement auquel envoyer les votes</label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <select name="quelEvent" id="eventvotes" class="w-75 text-center bleuCegep border-bleuCegep rounded">
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
                                        <label for="quiRepond" class="fontCegep bleuCegep fw-bold fs-6">Qui répondera au sondage sur cet appareil ? </label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <select name="quiRepond" id="quiRepond" class="w-75 text-center bleuCegep border-bleuCegep rounded">
                                            <option value="etudiant">Étudiants</option>
                                            <option value="employeur">Employeurs</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <span class="text-center p-0 m-0 rougeCegep fw-bold">Vous serez déconnecté pour vous rendre à la page de vote</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg bg-bleuCegep d-flex justify-content-center align-items-center border-rouge-cegep">
                            <div class="offset col-4"></div>
                            <div class="col-4 px-1 d-flex justify-content-center align-items-center">
                                <button type="submit" class="w-100 bg bgLilasCegep border-rouge-cegep w-100 bleuCegep fontCegep fw-bold rounded p-0 m-0"><img src="icones/deconnexion.png" alt="deco" class="me-1">Page de votes</button>
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
