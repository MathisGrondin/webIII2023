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


        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["courriel"]) && isset($_POST["mdp"])) {

            $courriel = $_POST["courriel"];
            $mdp = sha1($_POST["mdp"]);

            $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
            $result = $conn->query($sql);
            

            if($result->num_rows > 0) {
                $_SESSION["admin"] = $courriel;
                $formVisible = "none";
                $barreMenuAdmin = "flex";
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
        else if($_SERVER["REQUEST_METHOD"] == "GET"){

            if(isset($_SESSION["admin"])){
                $formVisible = "none";
                $barreMenuAdmin = "flex";

                if(isset($_GET["page"])){
                    $page = $_GET["page"];
                    if($page == "events") {
                        $pageEvent = "flex";
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

    <div class="container-fluid" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu">
        <div class="row p-2" id="rowMenu">
            <div class="col-xl-12 d-flex justify-content-between bg-primary align-content-center" id="colMenu">
                <a href="admin.php?page=events" class="btn btn-light border border-2 border-dark w-25     ">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/event.png" alt="Événements" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Événements</h5>
                        </div>

                    </div>
                </a>
                <a href="admin.php?page=users" class="btn btn-light border border-2 border-dark w-25 ms-4">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/user.png" alt="Utilisateurs" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Utilisateurs</h5>
                        </div>

                    </div>
                </a>
                <a href="statistiques.php" class="btn btn-light border border-2 border-dark w-25 ms-4">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/stats.png" alt="Statistiques" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Statistiques</h5>
                        </div>

                    </div>
                </a>
                <a href="admin.php?page=accueil" class="btn btn-light border border-2 border-dark w-25 ms-4">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/accueil.png" alt="Accueil" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Accueil</h5>
                        </div>

                    </div>
                </a>
                <a href="admin.php?page=deco" class="btn btn-light border border-2 border-dark w-25 ms-4">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-evenly align-items-center flex-row ">
                            <img src="icones/deconnexion.png" alt="Deconnexion" class=" p-0 m-0 icone-menu">
                            <h5 class="p-0 m-0">Déconnexion</h5>
                        </div>

                    </div>
                </a>
                <a href="admin.php?page=themes" class="btn btn-light border border-2 border-dark w-25 ms-4">
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

    <div class="container-fluid p-0 m-0" id="containerEvent" style="display: <?php echo $pageEvent; ?>">
    <div class="row" id="rowEvent">
        <div class="offset col-xl-4"></div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h4>Test</h4></div>
            </div>
        </div>
        <div class="offset col-xl-4"></div>
    <div class="container-fluid" id="containerUsers"></div>
    <div class="container-fluid" id="containerAccueil"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>