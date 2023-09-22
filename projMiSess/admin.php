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
        $pageEvent = "none";




        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "bla";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

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
                $_SESSION["admin"] = $courriel;
                $formVisible = "none";
                $barreMenuAdmin = "block";
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

            $conn->close();
        }
        // Si la page est appelée en GET
        else if($_SERVER["REQUEST_METHOD"] == "GET"){

            if(isset($_SESSION["admin"])){
                $formVisible = "none";
                $barreMenuAdmin = "block";

                if(isset($_GET["page"])){
                    $page = $_GET["page"];
                    if($page == "events") {
                        $pageEvent = "block";
                    }
                    else if($page == "users") {
                        include("users.php");
                    }
                    else if($page == "accueil") {
                        include("accueil.php");
                    }
                    else if($page == "deco") {
                        session_destroy();
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
    <div class="container-fluid" style="display: <?php echo $formVisible; ?>">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row mt-4">
                <div class="offset col-xl-4"></div>
                    <div class="col-xl-4">
                        <div class="card border border-1 border-dark">
                            <div class="card-header bg bg-gradient bg-secondary bg-opacity-75 text-white text-opacity-75">
                                <h2 class="text-center ">Connexion admin</h2>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <label for="courriel" class="fw-bold">Courriel</label>
                                    <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="rounded text-center">
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <label for="mdp" class="fw-bold">Mot de passe</label>
                                    <input type="password" name="mdp" class="rounded">
                                </div>
                                
                            </div>

                            <div class="card-footer d-flex justify-content-center bg bg-gradient bg-secondary bg-opacity-75">
                                <button type="submit" class="btn btn-secondary border border-1 border-light w-50 ">Connexion</button>
                            </div>
                        </div>
                    </div>
                <div class="offset col-xl-4"></div>
            </div>
        </form>
    </div>

    <!-- Barre de menu Admin -->
    <div class="container-fluid h-auto" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu" id="contNav">
        <div class="row bg bgBleuCegep p-3 h-100 d-flex align-items-center" id="rowMenu">
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
        <div class="row bgLilasCegep h-100  d-flex justify-content-center align-items-center" id="rowEvent">
            <div class="offset col-xl-1"></div>
            <div class="col-xl-2">
                <div class="card">
                    <div class="card-body">
                        <table>
                            <th>Événements</th>
                        </table>
                    </div>
                </div>
            </div>
            <div class="offset col-xl-1"></div>
            <div class="col-xl-4">
                <div class="card h-auto w-auto">
                    <div class="card-header p-2 text-center fontCegep fw-2">
                        <h3 class="p-0 m-0">Création d'un événement</h3>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col-4 text-center">
                                <label for="nomEvent" class="fontCegep fw-bold fs-6">Date</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="nomEvent" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset col-xl-4"></div>
        </div>
    </div>

    <!-- Bas de page admin : Utilisateurs -->
    <div class="container-fluid" id="containerUsers">

    </div>

    <!-- Bas de page admin : Accueil -->
    <div class="container-fluid" id="containerAccueil">

    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>