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
        $formVisible = "block";
        $barreMenuAdmin = "none";

        // Événements
        $pageEvent = "none";
        $pageAccueil = "none";
        $afficherliste = "none";
        $formCreation = "block";
        $contextBodyCreaEvent = "none";
        $messageContexte = "";

        // Users
        $pageUsers = "none";
        $listeUsers = "none";
        $formUserCr = "block";
        $adminUser = 0;

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

                // check if user is admin
                $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {
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
                echo "
                <div class=\"container-fluid mt-4\">
                    <div class=\"row\">
                        <div class=\"offset col-xl-4 col-sm-4\"></div>
                            <div class=\"col-xl-4 col-sm-4 col-12\">
                                <div class='alert alert-danger'>Identifiants de connexion invalides</div>
                            </div>
                        <div class=\"offset col-xl-4 col-sm-4\"></div>
                    </div>
                
                ";
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
                $formVisible = "block";
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
                
            }
            else{
                $formVisible = "block";
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
    <div class="container-fluid contConnex h-100" style="display: <?php echo $formVisible; ?>">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row pt-4">
                <div class="offset col-xl-4"></div>
                    <div class="col-xl-4">
                        <div class="card border border-1 border-dark">
                            <div class="card-header bg bg-bleuCegep">
                                <h2 class="text-center text-white fontCegep fw-bold">Connexion admin</h2>
                            </div>

                            <div class="card-body bg bgLilasCegep">
                                <div class="d-flex justify-content-between">
                                    <label for="courriel" class="fw-bold fontCegep">Courriel</label>
                                    <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="rounded text-center">
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <label for="mdp" class="fw-bold fontCegep">Mot de passe</label>
                                    <input type="password" name="mdp" class="rounded">
                                </div>
                                
                            </div>

                            <div class="card-footer d-flex justify-content-center bg bg-bleuCegep">
                                <button type="submit" class="btn bgLilasCegep border border-2 border-light w-50 fontCegep fw-bold">Connexion</button>
                            </div>
                        </div>
                    </div>
                <div class="offset col-xl-4"></div>
            </div>
        </form>
    </div>

    <!-- Barre de menu Admin -->
    <div class="container-fluid h-auto" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu" id="contNav">
        <div class="row bg-bleuCegep p-3 h-100 d-flex align-items-center" id="rowMenu">
            <div class="col">
                <a href="admin.php?page=events" class="btn btn-light bg bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/event.png" alt="Événements" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Événements</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="admin.php?page=users" class="btn btn-light bg bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/user.png" alt="Utilisateurs" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Utilisateurs</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="statistiques.php" class="btn btn-light bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/stats.png" alt="Statistiques" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Statistiques</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="admin.php?page=accueil" class="btn btn-light bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/accueil.png" alt="Accueil" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Accueil</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="admin.php?page=deco" class="btn btn-light bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/deconnexion.png" alt="Deconnexion" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Déconnexion</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="admin.php?page=themes" class="btn btn-light bgLilasCegep border-rouge-cegep">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/theme.png" alt="Theme" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Thèmes</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>        
    </div>

    <!-- Bas de page admin : Événements -->
    <div class="container-fluid h-100 w-100" id="containerEvent" style="display: <?php echo $pageEvent; ?>">
        <div class="row h-100 d-flex justify-content-center align-items-center" id="rowEvent">
            <div class="offset col-xl-2"></div>
            <div class="col-xl-8">
                <!-- Card pour création d'un événement -->
                <div class="card">
                    <div class="card-header py-2 bg bg-bleuCegep border-rouge-cegep">
                        <h3 class="p-0 m-0 py-2 text-center lilasCegep fontCegep fw-bold" id="titreCarteModifier">
                            <img src="icones/event.png" alt="crEvent" id="iconUser">
                            Création d'un événement
                        </h3>
                    </div>
                    
                    <!-- Formulaire de création d'événement -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="display: <?php echo $formCreation ?>">
                        <div class="card-body bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="dateEvent" class="fontCegep bleuCegep fw-bold fs-6">Date</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" name="dateEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="lieuEvent" class="fontCegep bleuCegep fw-bold fs-6">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="nomEvent" class="fontCegep bleuCegep fw-bold fs-6">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEvent" class="form-control border-bleuCegep">
                                </div>
                            </div>

                            <div class="row d-flex align-items-center pt-3">
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

                        <div class="card-footer w-100 h-100 bg-bleuCegep border-rouge-cegep p-0 m-0 d-flex align-items-center justify-content-center">
                            <div class="row w-100 p-3">

                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <button type="submit" class="rounded bgLilasCegep border-rouge-cegep w-100 p-0 m-0">
                                        <div class="w-100 d-flex align-items-center justify-content-center p-0 m-0">
                                            <img src="icones/ajouter.png" alt="créer" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep p-0 m-0" >Créer</span>
                                        </div>
                                    </button>
                                </div>

                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <a href="admin.php?page=events&action=Modifier" class="btn w-100 rounded bgLilasCegep border-rouge-cegep m-0 p-0">
                                        <div class="d-flex align-items-center justify-content-center p-0 m-0">
                                            <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep p-0 m-0">Liste événements</span>
                                        </div>
                                    </a>                                                                       
                                </div>

                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <button type="reset" class="rounded bgLilasCegep w-100 border-rouge-cegep p-0 m-0">
                                        <div class="d-flex justify-content-center align-items-center p-0 m-0">
                                            <img src="icones/retour.png" alt="annuler" style="width: 60px; height: 60px">
                                            <span class="fs-4 fw-bold fontCegep bleuCegep p-0 m-0">Annuler</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Body contexte sur ajout -->
                    <div class="card-body bgLilasCegep border-top-0 border-bottom-0 boder-bleuCegep text-center" style="display: <?php echo $contextBodyCreaEvent ?>">
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
                        





                    <div style="display: <?php echo $afficherliste; ?>">
                        <div class="card-body bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                            <table class="w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">#</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Nom</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Date</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Lieu</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Programme</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Modifier</th>
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
                        <div class="card-footer bg bg-bleuCegep d-flex justify-content-center align-items-center border-rouge-cegep">
                            <div class="offset col-4"></div>                        
                            <div class="col-4 px-1">
                                <a href="admin.php?page=events" class="btn bg bgLilasCegep border-rouge-cegep w-100 fontCegep fw-bold" ><img src="icones/retour.png" alt="annuler" class="me-1">Retour au formulaire</a>
                            </div>
                            <div class="offset col-4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset col-xl-2"></div>
        </div>
    </div>

    <!-- Bas de page admin : Utilisateurs -->
    <div class="container-fluid h-100 w-100" id="containerUsers" style="display: <?php echo $pageUsers; ?>">
        <div class="row h-100 d-flex justify-content-center align-items-center" id="rowUsers">
            <div class="offset col-xl-3"></div>
            <div class="col-xl-6">
                <!-- Card pour création d'un user -->
                <div class="alert alert-<?php echo $stadeAlerte; ?>" id="alerteTemp"><?php echo $Message; ?></div>                

                <div class="card">                                   
                    <div class="card-header py-2 bg bg-bleuCegep border-rouge-cegep">
                        <h3 class="text-center py-2 lilasCegep fontCegep fw-bold p-0 m-0" id="titreUserCr"><img src="icones/admin.png" alt="crUser" id="iconUser">Création d'un utilisateur</h3>
                    </div> 
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  style="display: <?php echo $formUserCr ?>">
                        <div class="card-body bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                        <div class="row d-flex align-items-center">
                            <div class="offset col-4"></div>
                            <div class="col-8 pb-3">
                                <label for="checkAdmin" class="fontCegep bleuCegep fw-bold fs-6 form-check-label">Admin</label>                                   
                                <input type="checkbox" id="checkAdmin" class="form-check-input border-bleuCegep">
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
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="prenomUser" class="fontCegep bleuCegep fw-bold fs-6">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUser" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="courriel" class="fontCegep bleuCegep fw-bold fs-6">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courriel" class="form-control border-bleuCegep">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="mdp1" class="fontCegep bleuCegep fw-bold fs-6">Mot de passe</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp1" class="form-control border-bleuCegep">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="col-4">
                                    <label for="mdp2" class="fontCegep bleuCegep fw-bold fs-6">Confirmation Mdp</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp2" class="form-control border-bleuCegep">
                                </div>                                    
                            </div>
                            <div class="row d-flex align-items-center pt-3">
                                <div class="offset col-4"></div>
                                <div class="col-8 pt-3">
                                    <input type="checkbox" id="checkInfos" class="form-check-input border-bleuCegep">
                                    <label for="checkInfos" class="fontCegep bleuCegep fw-bold fs-6 form-check-label">Je confirme que les informations sont exactes</label>                                   
                                </div>                                    
                            </div>
                        </div>
                        
                        <div class="card-footer bg bg-bleuCegep border-rouge-cegep">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <button type="submit" class="w-100 rounded fs-4 fw-bold fontCegep bleuCegep bgLilasCegep border-rouge-cegep"><img src="icones/ajouterAdminUser.png" alt="créerUser">Créer</button>
                                </div>

                                <div class="col-4">
                                    <a href="admin.php?page=users&action=Modifier" class="btn w-100 rounded fs-4 fw-bold fontCegep bleuCegep bgLilasCegep border-rouge-cegep m-0 p-0">
                                        <img src="icones/modifierAdminUser.png" alt="modifierUser">
                                        Liste utilisateurs
                                    </a>                                                                       
                                </div>

                                <div class="col-4">
                                    <button type="reset" class="w-100 rounded fs-4 fw-bold fontCegep bleuCegep bgLilasCegep border-rouge-cegep"><img src="icones/retour.png" alt="annuler" class="me-1">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div style="display: <?php echo $listeUsers; ?>">
                        <div class="card-body bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                            <table class="w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">#</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Nom</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Prénom</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Admin</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Courriel</th>
                                        <th scope="col" class="font-cegep fw-bold bleuCegep">Modifier</th>
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
                                                                <img src="icones/modifier.png">
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
                        <div class="card-footer bg bg-bleuCegep d-flex justify-content-center align-items-center border-rouge-cegep">
                            <div class="offset col-4"></div>                        
                            <div class="col-4 px-1">
                                <a href="admin.php?page=users" class="btn bg bgLilasCegep border-rouge-cegep w-100 fontCegep fw-bold" ><img src="icones/retour.png" alt="retour" class="me-1">Retour au formulaire</a>
                            </div>
                            <div class="offset col-4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset col-xl-3"></div>
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

                        <div class="card-body bg bgLilasCegep border-top-0 border-bottom-0 border-bleuCegep">
                            
                            <div class="row py-3">                            
                                <div class="row">
                                    <div class="col-6 ps-5">
                                        <label for="eventvotes" class="fontCegep bleuCegep fw-bold fs-6 py-2">Événement auquel envoyer les votes</label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center py-1">
                                        <select name="quelEvent" id="eventvotes" class="w-75 text-center bleuCegep border-bleuCegep rounded py-1">
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
                                
                                <div class="row pt-3">
                                    <div class="col-6 ps-5">
                                        <label for="quiRepond" class="fontCegep bleuCegep fw-bold fs-6 py-2">Qui répondera au sondage sur cet appareil ? </label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center py-1">
                                        <select name="quiRepond" id="quiRepond" class="w-75 text-center bleuCegep border-bleuCegep rounded py-1">
                                            <option value="etudiant">Étudiants</option>
                                            <option value="employeur">Employeurs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-center rougeCegep fw-bold m-0 p-0">Vous serez déconnecter pour vous rendre à la page de votes</p>
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
