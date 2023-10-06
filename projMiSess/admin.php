<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr-ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="favicons/favicon-admin.png" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <link rel="stylesheet" href="css/styleco.css">
    <title>Page admin</title>
</head>

<body>
    <?php

    //! Variables 
    //? Variables globales
    $formVisible                = "flex";
    $formMDPVisible             = "none";
    $barreMenuAdmin             = "none";
    $basAdmin                   = "none";
    $messageErreurConnexion     = "";
    $erreur                     = "";
    $formReinit                 = "none";
    $etapeReinit                = "Envoyer";
    $idReinit                   = "";

    //? Variables partie Événements
    $pageEvent                  = "none";
    $pageAccueil                = "none";
    $afficherliste              = "none";
    $formCreation               = "block";
    $formModif                  = "none";
    $contextBodyCreaEvent       = "none";
    $messageContexte            = "";
    $boutonRetourEvent          = "none";
    $idBarreBas                 = "existePas";
    $titreCarteEvent            = "Création d'événement";
    $valueDateEvent             = "";
    $valueLieuEvent             = "";
    $valueNomEvent              = "";
    $valueProgrammeModif1       = "";
    $valueProgrammeModif2       = "";
    $valueProgrammeModif3       = "";
    $rowPModif1                 = false;
    $rowPModif2                 = false;
    $rowPModif3                 = false;

    //? Variable partie Users
    $pageUsers                  = "none";
    $listeUsers                 = "none";
    $formModifUser              = "none";
    $formUserCr                 = "block";
    $boutonRetourUser           = "none";
    $adminUser                  = 0;
    $contextBodyCreaUser        = "none";
    $messageCreaUser            = "";
    $boutonRetourUser           = "none";
    $mdpValide                  = false;
    $titreCarteUser             = "Création d'un utilisateur";
    $valueNomUser               = "";
    $valuePrenomUser            = "";
    $valueCourrielUser          = "";
    $idUser                     = "";

    //? Variable pour le thème
    if (!isset($_SESSION['style'])) {
        $_SESSION['style'] = 0;
    } else if (isset($_SESSION['style']) && $_SESSION['style'] == 0) {
        $_SESSION['style'] = 0;
    } else if (isset($_SESSION['style']) && $_SESSION['style'] == 1) {
        $_SESSION['style'] = 1;
    } else {
        $_SESSION['style'] = 0;
    }

    if (isset($_SESSION['style']) || $_SESSION['style'] == 0) {
        $_SESSION['style'] == 0;
        $CardHeader = "bg-bleuCegep border-rouge-cegep";
        $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
        $CardFooter = "bg-bleuCegep border-rouge-cegep";
        $Table = "fontCegep bleuCegep";
        $TableBorder = "text-center border-bottom border-dark";
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
        $borderImg = "rounded border-bleuCegep";
    } else if ($_SESSION['style'] == 1) {
        $_SESSION['style'] == 1;
        $CardHeader = "bg-rougeCegep border-bleuCegep";
        $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
        $CardFooter = "bg-rougeCegep border-bleuCegep";
        $Table = "fontCegep bleuCegep";
        $TableBorder = "text-center border-bottom border-danger";
        $Bouton = "bgLilasCegep border-bleuCegep rounded";
        $TextBouton = "fontCegep bleuCegep fw-bold fs-4";
        $BtnA = "btn bgLilasCegep border-bleuCegep";
        $TextBtnA = "fontCegep fw-bold bleuCegep";
        $TextCardHeader = "lilasCegep fw-bold text-center fontCegep";
        $TextCardBody = "rougeCegep fw-bold fontCegep";
        $TextErreur = "rougeOrangeCegep fw-bold fontCegep";
        $Label = "fontCegep rougeCegep fw-bold fs-6";
        $borderInput = "rounded text-center border-bleuCegep";
        $borderImg = "rounded border-rouge-cegep";
        $BarreAdmin = "bg-rougeCegep";
        $Background = "background2";
    }

    //! Base de données
    //? Connexion BD
    include("connBD.php");

    //? Page appelée en POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["courriel"]) && isset($_POST["mdp"])) {

            $courriel = $_POST["courriel"];
            //!$courriel = test_input($_POST["courriel"]);
            $mdp = sha1($_POST["mdp"]);

            $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                $_SESSION["user"]   = $courriel;    /* Définir le courriel de l'utilisateur en variable de session              */
                $formVisible        = "none";       /* Retire le formulaire de connexion (mets le display à none)               */
                $barreMenuAdmin     = "block";      /* Affiche la barre de boutons dans le haut de l'écran une fois connecté    */
                $basAdmin           = "block";      /* Mets le bas de l'écran "par défaut" qui contient un message de bienvenu  */

                //* Regarde si l'utilisateur est admin ou non
                $sql = "SELECT * FROM users WHERE email = '$courriel' AND MDP = '$mdp'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    $messageErreurConnexion     = ""; /* Message qui serait affiché si un problème serait survenu */

                    while ($row = $result->fetch_assoc()) {
                        $_SESSION["admin"]  = $row["admin"] ? true : false;
                    }
                }
            } else {
                $messageErreurConnexion     = "Les identifiants fournis sont invalides";
            }
        }
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user"])) {
    }

    //? Page appelée en GET
    else if ($_SERVER["REQUEST_METHOD"] == "GET") {

        //? STYLE

        if (isset($_GET['style'])) {
            $style = $_GET['style'];

            if ($style == 0) {
                $_SESSION['style'] = 0;
                $CardHeader = "bg-bleuCegep border-rouge-cegep";
                $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
                $CardFooter = "bg-bleuCegep border-rouge-cegep";
                $Table = "fontCegep bleuCegep";
                $TableBorder = "text-center border-bottom border-dark";
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
                $borderImg = "rounded border-bleuCegep";
            } else if ($style == 1) {
                $_SESSION['style'] = 1;
                $CardHeader = "bg-rougeCegep border-bleuCegep";
                $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
                $CardFooter = "bg-rougeCegep border-bleuCegep";
                $Table = "fontCegep bleuCegep";
                $TableBorder = "text-center border-bottom border-danger";
                $Bouton = "bgLilasCegep border-bleuCegep rounded";
                $TextBouton = "fontCegep bleuCegep fw-bold fs-4";
                $BtnA = "btn bgLilasCegep border-bleuCegep";
                $TextBtnA = "fontCegep fw-bold bleuCegep";
                $TextCardHeader = "lilasCegep fw-bold text-center fontCegep";
                $TextCardBody = "rougeCegep fw-bold fontCegep";
                $TextErreur = "rougeOrangeCegep fw-bold fontCegep";
                $Label = "fontCegep rougeCegep fw-bold fs-6";
                $borderInput = "rounded text-center border-bleuCegep";
                $borderImg = "rounded border-rouge-cegep";
                $BarreAdmin = "bg-rougeCegep";
                $Background = "background2";
            }
        }

        if (!isset($_GET['style'])) {

            if (isset($_SESSION["style"])) {
                $style = $_SESSION["style"];

                if ($style == 1) {
                    $CardHeader = "bg-rougeCegep border-bleuCegep";
                    $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
                    $CardFooter = "bg-rougeCegep border-bleuCegep";
                    $Table = "fontCegep bleuCegep";
                    $TableBorder = "text-center border-bottom border-danger";
                    $Bouton = "bgLilasCegep border-bleuCegep rounded";
                    $TextBouton = "fontCegep bleuCegep fw-bold fs-4";
                    $BtnA = "btn bgLilasCegep border-bleuCegep";
                    $TextBtnA = "fontCegep fw-bold bleuCegep";
                    $TextCardHeader = "lilasCegep fw-bold text-center fontCegep";
                    $TextCardBody = "rougeCegep fw-bold fontCegep";
                    $TextErreur = "rougeOrangeCegep fw-bold fontCegep";
                    $Label = "fontCegep rougeCegep fw-bold fs-6";
                    $borderInput = "rounded text-center border-bleuCegep";
                    $borderImg = "rounded border-rouge-cegep";
                    $BarreAdmin = "bg-rougeCegep";
                    $Background = "background2";
                } else {
                    $CardHeader = "bg-bleuCegep border-rouge-cegep";
                    $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
                    $CardFooter = "bg-bleuCegep border-rouge-cegep";
                    $Table = "fontCegep bleuCegep";
                    $TableBorder = "text-center border-bottom border-dark";
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
                    $borderImg = "rounded border-bleuCegep";
                }
            } else {
                $_SESSION['style'] = 0;
                $CardHeader = "bg-bleuCegep border-rouge-cegep";
                $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
                $CardFooter = "bg-bleuCegep border-rouge-cegep";
                $Table = "fontCegep bleuCegep";
                $TableBorder = "text-center border-bottom border-dark";
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
                $borderImg = "rounded border-bleuCegep";
            }
        }

        //? Est-ce qu'un utilisateur est connecté

        if (isset($_SESSION["user"])) {

            $formVisible    = "none";      /* Retire le formulaire de connexion (mets le display à none)    */
            $barreMenuAdmin = "block";     /* Affiche la barre de menu en haut de l'écran avec les options  */

            // SI admin.php?page=____
            if (isset($_GET["page"])) {

                $page = $_GET["page"];      /* Enregistrement de la page désirée dans une variable          */

                if ($page == "events") {
                    include("pageEvent.php"); /* Code PHP pour la page (menu) événement */
                } else if ($page == "users") {
                    include("pageUsers.php"); /* Code PHP pour la page (menu) utilisateurs */
                } else if ($page == "accueil") {
                    $pageAccueil    = "block";  /* Affiche le menu pour sélectionner l'événement et le groupe qui réponds */
                    $barreMenuAdmin = "block";  /* Affiche la barre de menu dans le haut de l'écran */
                    $formCreation   = "none";   /* Retire le formulaire de création  */
                } else if ($page == "deco") {
                    try {
                        session_unset();
                        session_destroy();
                        header("Location: admin.php");
                    } catch (Exception $e) {
                        echo "Erreur lors de la déconnexion";
                    }
                } else if ($page == "stats") {
                    $formVisible    = "none";   /* Retire le formulaire de connexion */
                    $barreMenuAdmin = "none";   /* Retire la barre de menu en haut de l'écran */
                }
            }

            // Si aucune page n'est mentionnée en GET
            if (!isset($_GET["page"])) {
                $basAdmin = "block";
            } else {
                $basAdmin = "none";
            }
        } else {
            if (isset($_GET["action"])) {
                $action = $_GET["action"];

                if ($action == "mdpOublie") {

                    if (isset($_GET["erreurMDP"])) {
                        $erreur = $_GET["erreurMDP"];

                        if ($erreur == 0) {
                            $formMDPVisible = "none";
                            $formVisible = "flex";
                            $messageErreurConnexion = "Le mot de passe a été changé";
                        }

                        if ($erreur == 1) {
                            $messageErreurConnexion = "Le courriel n'existe pas";
                        } else if ($erreur == 2) {
                            $messageErreurConnexion = "Merci d'entrer un courriel";
                        } else if ($erreur == 4) {
                            $messageErreurConnexion = "Impossible de rejoindre le serveur";
                        } else if ($erreur == 5) {
                            $messageErreurConnexion = "Les mots de passe ne correspondent pas";
                        } else if ($erreur == 6) {
                            $messageErreurConnexion = "Merci de remplir tous les champs";
                        }
                    } else if (isset($_GET["mdp"]) && $_GET["mdp"] != "") {
                        $mdp = $_GET["mdp"];
                        $sql = "SELECT * FROM users WHERE MDP = '$mdp'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $idReinit = $row["id"];
                            $formVisible = "none";
                            $formMDPVisible = "none";
                            $formReinit = "flex";
                        }
                    } else {
                        $formVisible = "none";
                        $barreMenuAdmin = "none";
                        $formMDPVisible = "flex";
                        $formReinit = "none";
                    }

                    // $formVisible = "none";
                    // $barreMenuAdmin = "none";
                    // $formMDPVisible = "flex";
                    // $formReinit = "none";

                }
            } else {
                $formVisible = "flex";
                $barreMenuAdmin = "none";
            }
        }
    } else {
        $formVisible = "none";
        $barreMenuAdmin = "none";
    ?>

        //! Si une personne essaie de se rendre sur la page admin sans être connecté
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

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Connexion Page Admin   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 justify-content-center align-items-center p-0 m-0 <?php echo $Background; ?>" style="display: <?php echo $formVisible; ?>">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="w-50 d-flex align-items-center justify-content-center">
            <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="col-xl-12 w-100">
                    <div class="card w-100">

                        <!-- Entete -->
                        <div class="card-header <?php echo $CardHeader; ?>">
                            <h2 class="<?php echo $TextCardHeader; ?> ">Connexion admin</h2>
                        </div>

                        <!-- Connexion avec Courriel et MDP  -->
                        <div class="card-body <?php echo $CardBody; ?>">
                            <div class="row">
                                <div class="col-xl-4 d-flex align-items-center">
                                    <label for="courriel" class="<?php echo $Label; ?> w-100">Courriel</label>
                                </div>
                                <div class="col-xl-8 d-flex align-items-center">
                                    <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="<?php echo $borderInput; ?> w-100">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-4 d-flex align-items-center">
                                    <label for="mdp" class="<?php echo $Label; ?> w-100">Mot de passe</label>
                                </div>
                                <div class="col-xl-8 d-flex align-items-center">
                                    <input type="password" name="mdp" class="<?php echo $borderInput; ?> w-100">
                                </div>
                            </div>

                            <!-- Message d'erreur (Mauvais MDP ou courriel) -->
                            <div class="d-flex justify-content-center mt-3 text-center w-100">
                                <span class="<?php echo $TextErreur; ?>"><?php echo $messageErreurConnexion; ?></span>
                            </div>

                            <!-- Mot de passe oublié -->
                            <!-- 
                                <div class="d-flex justify-content-center mt-3 text-center w-100">
                                    <a href="admin.php?action=mdpOublie">Mot de passe oublié ? </a>
                                </div>        
                            -->
                        </div>

                        <!-- Bouton de connexion -->
                        <div class="card-footer d-flex justify-content-center bg bg-bleuCegep border-rouge-cegep">
                            <button type="submit" class="btn bgLilasCegep border-rouge-cegep w-50 fontCegep bleuCegep fw-bold">Connexion</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Mot de passe oublié   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 justify-content-center align-items-center p-0 m-0 <?php echo $Background; ?>" style="display: <?php echo $formMDPVisible; ?>">
        <form method="post" action="mdpOublie.php" class="w-25 d-flex align-items-center justify-content-center">
            <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="col-xl-12 w-100">
                    <div class="card w-100">

                        <!-- Entete -->
                        <div class="card-header <?php echo $CardHeader; ?>">
                            <h2 class="<?php echo $TextCardHeader; ?> ">Oubli du mot de passe</h2>
                        </div>

                        <!-- Courriel associé -->
                        <div class="card-body justify-content-evenly flex-column <?php echo $CardBody; ?>">
                            <div class="d-flex justify-content-between">
                                <label for="courrielReset" class="<?php echo $Label; ?>">Courriel associé au compte</label>
                                <input type="text" name="courrielReset" placeholder="admin@cegeptr.qc.ca" class="<?php echo $borderInput; ?>">
                            </div>

                            <!-- Message d'erreur (Mauvais MDP ou courriel) -->
                            <div class="d-flex justify-content-center mt-3 text-center w-100">
                                <span class="<?php echo $TextErreur; ?>"><?php echo $messageErreurConnexion; ?></span>
                            </div>
                        </div>

                        <!-- Bouton d'envoi du courriel -->
                        <div class="card-footer d-flex justify-content-center bg bg-bleuCegep border-rouge-cegep">
                            <button type="submit" class="btn bgLilasCegep border-rouge-cegep w-50 fontCegep bleuCegep fw-bold">Envoyer le courriel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    Réinitialisation Mot de passe   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    RETIRÉ - Pas accès au serveur WEB CTR   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 justify-content-center align-items-center p-0 m-0 <?php echo $Background; ?>" style="display: <?php echo $formReinit; ?>">
        <form method="post" action="mdpOublie.php" class="w-25 d-flex align-items-center justify-content-center">
            <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="col-xl-12 w-100">
                    <div class="card w-100">

                        <!-- Entete -->
                        <div class="card-header <?php echo $CardHeader; ?>">
                            <h2 class="<?php echo $TextCardHeader; ?> ">Changement de mot de passe</h2>
                        </div>

                        <!-- ID et Changement du MDP  -->
                        <div class="card-body justify-content-evenly flex-column <?php echo $CardBody; ?>">
                            <div class="d-flex justify-content-between">
                                <label for="idCompte" class="<?php echo $Label; ?>">ID du compte</label>
                                <input type="number" name="idCompte" class="<?php echo $borderInput; ?>" value="<?php echo $idReinit; ?>" readonly>
                            </div>

                            <div class="d-flex justify-content-center text-center w-100">
                                <span class="<?php echo $TextErreur; ?>"><?php echo $messageErreurConnexion; ?></span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <label for="nouvMDP" class="<?php echo $Label; ?>">Nouveau mot de passe</label>
                                <input type="password" name="nouvMDP" class="<?php echo $borderInput; ?>" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <label for="courriel" class="<?php echo $Label; ?>">Confirmation mot de passe</label>
                                <input type="password" name="confirmMDP" class="<?php echo $borderInput; ?>" required>
                            </div>
                        </div>

                        <!-- Bouton de changement de MDP -->
                        <div class="card-footer d-flex justify-content-center <?php echo $CardFooter; ?>">
                            <button type="submit" class="btn w-50 fontCegep bleuCegep fw-bold <?php echo $Bouton; ?>">Changer le mot de passe</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    Menu Admin   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <nav class="navbar fixed-top p-0 m-0">
        <div class="container-fluid h-auto" style="display: <?php echo $barreMenuAdmin; ?>" id="contMenu" id="contNav">
            <div class="row h-100 d-flex p-2 align-items-center justify-content-evenly <?php echo $BarreAdmin; ?>  " id="rowMenu">

                <!-- Événement -->
                <div class="col-2">
                    <a href="admin.php?page=events" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center ">
                        <img src="icones/event.png" alt="Événements" class=" p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Événements</h5>
                    </a>
                </div>

                <!-- Utilisateurs -->
                <div class="col-2">
                    <a href="admin.php?page=users" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center">
                        <img src="icones/user.png" alt="Utilisateurs" class="p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Utilisateurs</h5>
                    </a>
                </div>

                <!-- Statistiques -->
                <div class="col-2">
                    <a href="statistiques.php" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center ">
                        <img src="icones/stats.png" alt="Statistiques" class="p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Statistiques</h5>
                    </a>
                </div>

                <!-- Page de votes -->
                <div class="col-2">
                    <a href="admin.php?page=accueil" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center">
                        <img src="icones/votes.png" alt="Votes" class="p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Page de votes</h5>
                    </a>
                </div>

                <!-- Déconnexion -->
                <div class="col-2">
                    <a href="admin.php?page=deco" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center">
                        <img src="icones/deconnexion.png" alt="Deconnexion" class="p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Déconnexion</h5>
                    </a>
                </div>

                <!-- Thèmes -->
                <div class="col-2">
                    <a href="admin.php?page=themes" class="<?php echo $BtnA; ?> p-0 m-0 d-flex justify-content-evenly align-items-center">
                        <img src="icones/theme.png" alt="Theme" class="p-0 m-0 icone-menu">
                        <h5 class="p-0 m-0 <?php echo $TextBtnA; ?>">Thèmes</h5>
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Bas de page : Arrivée   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $basAdmin; ?>">
        <div class="row h-100 d-flex justify-content-center align-items-center" id="rowWelcome">
            <div class="offset col-xl-2 col-2"></div>

            <!-- Message de bienvenue -->
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
                <h1 class="text-center fontCegep bleuCegep fw-bold">Bienvenue sur la page <br><?php echo $userPrenom . " " . $userNom ?></h1>
            </div>

            <div class="offset col-xl-2 col-2"></div>
        </div>
    </div>

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Bas de page : Événements    ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $pageEvent; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowEvent">
            <div class="col-xl-6 h-75 d-flex align-items-center">

                <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Création d'un événement   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
                <!-- Entete -->
                <div class="card h-75 w-100">
                    <div class="card-header p-2 d-flex align-items-center justify-content-center <?php echo $CardHeader; ?>">
                        <img src="icones/event.png" alt="crEvent" style="width: 60px; height: 60px;">
                        <h3 class="p-0 m-0 <?php echo $TextCardHeader; ?>" id="titreCarteModifier"><?php echo $titreCarteEvent; ?></h3>
                    </div>

                    <!-- Données -->
                    <form method="post" action="creaEvent.php" style="display: <?php echo $formCreation ?>" class="h-100">
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="dateEvent" class="<?php echo $Label; ?>">Date</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" name="dateEvent" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="lieuEvent" class="<?php echo $Label; ?>">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEvent" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomEvent" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEvent" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>

                            <!-- Premier choix de programme (name=programme1) -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme" class="<?php echo $Label; ?>">Programme #1</label>
                                </div>
                                <div class="col-8">
                                    <select name="programme" id="selectProg1" class="form-control <?php echo $borderInput; ?>" required>
                                        <?php

                                        $sql = "SELECT * FROM programmes";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["id"] . "'>" . $row["nom"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Aucun programme</option>";
                                        }
                                        ?>
                                        <option value="ajout">Ajouter un programme</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Autre programme 1-->
                            <div class="row align-items-center dispNone" id="inputNouvProg">
                                <div class="col-4">
                                    <label for="programmeAjout" class="<?php echo $Label; ?>">Programme #1 à ajouter</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="programmeAjout" id="progAjout" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>

                            <!-- Deuxième choix de programme (name = programme2) -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme2" class="<?php echo $Label; ?>">Programme #2 (facultatif)</label>
                                </div>
                                <div class="col-8">
                                    <select name="programme2" id="selectProg2" class="form-control <?php echo $borderInput; ?>">
                                        <option value="aucun">Choisir un programme</option>
                                        <?php

                                        $sql = "SELECT * FROM programmes";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["id"] . "'>" . $row["nom"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Aucun programme</option>";
                                        }
                                        ?>
                                        <option value="ajout">Ajouter un programme</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Autre programme 2-->
                            <div class="row align-items-center dispNone" id="inputNouvProg2">
                                <div class="col-4">
                                    <label for="programmeAjout2" class="<?php echo $Label; ?>">Programme #2 à ajouter</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="programmeAjout2" id="progAjout2" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>

                            <!-- Troisième choix de programme (name = programme3) -->
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="programme3" class="<?php echo $Label; ?>">Programme #3 (facultatif)</label>
                                </div>
                                <div class="col-8">
                                    <select name="programme3" id="selectProg3" class="form-control <?php echo $borderInput; ?>">
                                        <option value="aucun">Choisir un programme</option>
                                        <?php

                                        $sql = "SELECT * FROM programmes";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["id"] . "'>" . $row["nom"] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Aucun programme</option>";
                                        }
                                        ?>
                                        <option value="ajout">Ajouter un programme</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Autre programme 3-->
                            <div class="row align-items-center dispNone" id="inputNouvProg3">
                                <div class="col-4">
                                    <label for="programmeAjout3" class="<?php echo $Label; ?>">Programme #3 à ajouter</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="programmeAjout3" id="progAjout3" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="card-footer p-2 m-0 d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">

                            <!-- Bouton Créer -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-75 <?php echo $Bouton; ?>">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="icones/ajouter.png" alt="créer" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">Créer</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Bouton Consulter -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=events&action=consulter" class="m-0 p-0 w-75 <?php echo $BtnA; ?>">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Consulter</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Bouton Retour -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php" class="w-75 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Modification d'un événement   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
                    <form method="post" action="pageEvent.php" style="display: <?php echo $formModif; ?>" class="h-100">
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">

                            <!-- Données -->
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
                                    <input type="date" name="dateEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueDateEvent; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="lieuEvent" class="<?php echo $Label; ?>">Lieu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="lieuEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueLieuEvent; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="nomEvent" class="<?php echo $Label; ?>">Nom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="nomEventModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueNomEvent; ?>" required>
                                </div>
                            </div>

                            <!-- Premier choix de programme (name=programmeModif) -->

                            <?php

                                // changement d'affichage dépendamment du nombre de programmes

                                // $valueProgrammeModif = explode(" | ", $valueProgramme);

                                // $nbProgs = count($valueProgrammeModif);

                                // switch ($nbProgs) {
                                //     case 1:
                                //         $rowPModif1 = true;
                                //         $valueProgrammeModif1 = $valueProgrammeModif[0];
                                //         $valueProgrammeModif2 = "Choisir un programme (Facultatif)";
                                //         $valueProgrammeModif3 = "Choisir un programme (Facultatif)";
                                //         break;

                                //     case 2:
                                //         $rowPModif1 = true;
                                //         $rowPModif2 = true;
                                //         $valueProgrammeModif1 = $valueProgrammeModif[0];
                                //         $valueProgrammeModif2 = $valueProgrammeModif[1];
                                //         $valueProgrammeModif3 = "Choisir un programme (Facultatif)";
                                //         break;

                                //     case 3:
                                //         $rowPModif1 = true;
                                //         $rowPModif2 = true;
                                //         $rowPModif3 = true;
                                //         $valueProgrammeModif1 = $valueProgrammeModif[0];
                                //         $valueProgrammeModif2 = $valueProgrammeModif[1];
                                //         $valueProgrammeModif3 = $valueProgrammeModif[2];
                                //         break;

                                //     default:
                                //         $rowPModif1 = true;
                                //         $valueProgrammeModif1 = $valueProgrammeModif[0];
                                //         break;
                                // }




                            ?>
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <label for="programmeModif" class="<?php echo $Label; ?>">Programme</label>
                                    </div>

                                    <div class="col-8">
                                        <select name="programmeModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueProgrammeModif1; ?>" required>
                                            <?php
                                            $sql = "SELECT * FROM programmes";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>

                                                    <option value="<?php echo $row["nom"]; ?>" <?php echo $row["nom"] == $valueProgrammeModif1 ? "selected" : ""; ?>><?php echo $row["nom"]; ?></option>

                                                    <?php
                                                }
                                            } else {
                                                echo "<option value=''>Aucun programme</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>

                                </div>


                            <!-- Autre programme 1-->
                                <div class="row align-items-center dispNone" id="inputNouvProgModif">
                                    <div class="col-4">
                                        <label for="programmeAjoutModif" class="<?php echo $Label; ?>">Programme #1 à ajouter</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="programmeAjoutModif" id="progAjoutModif" class="form-control <?php echo $borderInput; ?>">
                                    </div>
                                </div>

                            <!-- Deuxième choix de programme (name = programme2) -->
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label for="programmeModif2" class="<?php echo $Label; ?>">Programme #2</label>
                                </div>
                                <div class="col-8">
                                    <select name="programmeModif2" id="selectProgModif2" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueProgrammeModif2; ?>">
                                        <?php

                                        $sql = "SELECT * FROM programmes";
                                        $result = $conn->query($sql);

                                        if($valueProgrammeModif2 == "Choisir un programme (Facultatif)" || $valueProgrammeModif2 == "")
                                        {
                                            $valueProgrammeModif2 = "Choisir un programme (Facultatif)";
                                            echo "<option value='aucun' selected disabled>". $valueProgrammeModif2 . "</option>";
                                        }

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value="<?php echo $row["nom"]; ?>" <?php echo $row["nom"] == $valueProgrammeModif2 ? "selected" : ""; ?>><?php echo $row["nom"]; ?></option>

                                                <?php

                                            }
                                        } else {
                                            echo "<option value=''>Aucun programme</option>";
                                        }
                                        ?>
                                        <option value="ajout">Ajouter un programme</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Autre programme 2-->
                            <div class="row align-items-center dispNone" id="inputNouvProgModif2">
                                <div class="col-4">
                                    <label for="programmeAjoutModif2" class="<?php echo $Label; ?>">Programme #2 à ajouter</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="programmeAjoutModif2" id="progAjoutModif2" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>

                            <!-- Troisième choix de programme (name = programme3) -->
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label for="programmeModif3" class="<?php echo $Label; ?>">Programme #3</label>
                                </div>
                                <div class="col-8">
                                    <select name="programmeModif3" id="selectProgModif3" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueProgrammeModif3; ?>">
                                        <?php

                                        $sql = "SELECT * FROM programmes";
                                        $result = $conn->query($sql);

                                        if($valueProgrammeModif3 == "Choisir un programme (Facultatif)" || $valueProgrammeModif3 == "")
                                        {
                                            $valueProgrammeModif3 = "Choisir un programme (Facultatif)";
                                            echo "<option value='aucun' selected disabled>". $valueProgrammeModif3 . "</option>";
                                        }

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) 
                                            {
                                                ?>

                                                <option value="<?php echo $row["nom"]; ?>" <?php echo $row["nom"] == $valueProgrammeModif3 && $valueProgrammeModif3 != "" ? "selected" : ""; ?>><?php echo $row["nom"]; ?></option>

                                                <?php
                                            }
                                        } else {
                                            echo "<option value=''>Aucun programme</option>";
                                        }
                                        ?>
                                        <option value="ajout">Ajouter un programme</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Autre programme 3-->
                            <div class="row align-items-center dispNone" id="inputNouvProgModif3">
                                <div class="col-4">
                                    <label for="programmeAjoutModif3" class="<?php echo $Label; ?>">Programme #3 à ajouter</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="programmeAjoutModif3" id="progAjoutModif3" class="form-control <?php echo $borderInput; ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer p-2 m-0 d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">

                            <!-- Bouton Modifier -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-100 <?php echo $Bouton; ?>">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="icones/modifier.png" alt="créer" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">Modifier</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Bouton Retour -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=events&action=consulter" class="w-100 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px;">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Body Contexte Ajout Événements ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->

                    <!-- Body -->
                    <div class="card-body <?php echo $CardBody; ?>" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row w-100">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h4 class="<?php echo $TextCardBody; ?>"><?php echo $messageContexte; ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer <?php echo $CardFooter; ?>p" style="display: <?php echo $contextBodyCreaEvent ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>

                    <!-- Liste -->
                    <div class="card-body h-25 listeOverflow <?php echo $CardBody; ?>" style="display: <?php echo $afficherliste; ?>">
                        <table class="w-100">
                            <thead>
                                <?php
                                if ($_SESSION["admin"] == true) {
                                ?>

                                    <tr class="text-center">
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">#</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Nom</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Date</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Lieu</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Programme</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Modifier</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Supprimer</th>
                                    </tr>

                                <?php
                                } else {
                                ?>

                                    <tr class="text-center">
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">#</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Nom</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Date</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Lieu</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Programme</th>
                                    </tr>

                                <?php
                                }
                                ?>

                            </thead>
                            <tbody class="table-group-divider <?php echo $TableBorder; ?>">
                                <?php
                                $sql = "SELECT * FROM evenements";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($_SESSION["admin"] == true) {

                                            $programmes = str_replace(" | ", ",<br>", $row["programme"]);
                                ?>
                                            <tr class="<?php echo $TableBorder; ?>">
                                                <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"]; ?></th>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nom"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["date"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["lieu"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $programmes ?></td>


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
                                        } else {
                                        ?>
                                            <tr class="<?php echo $TableBorder; ?>">
                                                <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"]; ?></th>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nom"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["date"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["lieu"]; ?></td>
                                                <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["programme"]; ?></td>
                                            </tr>
                                <?php
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Aucun événement</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- footer liste -->
                    <div class="card-footer w-100 align-items-center justify-content-center <?php echo $CardFooter; ?>" style="display : <?php echo $boutonRetourEvent; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100">
                            <div class="col-4">
                                <a href="admin.php?page=events" class="w-100 align-items-center justify-content-center <?php echo $BtnA; ?>" style="display : <?php if ($_SESSION["admin"] == true) {
                                                                                                                                                                    echo "flex";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "none";
                                                                                                                                                                }  ?> ">
                                    <img src="icones/retour.png" alt="annuler" style="width: 60px;">
                                    <span class="<?php echo $TextBtnA; ?>">Retour au formulaire</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    Bas de page : Utilisateurs     ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $pageUsers; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center" id="rowUsers">
            <div class="col-xl-6 h-75 d-flex align-items-center">

                <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Création d'un utilisateur  ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
                <div class="card h-75 w-100">

                    <!-- Entete -->
                    <div class="card-header py-2 d-flex align-items-center justify-content-center <?php echo $CardHeader; ?>">
                        <img src="icones/admin.png" alt="crUser" style="width: 60px; height: 60px;">
                        <h3 class="p-0 m-0 <?php echo $TextCardHeader; ?>" id="titreUserCr"><?php echo $titreCarteUser; ?></h3>
                    </div>

                    <!-- Données -->
                    <form method="post" action="creaUser.php" style="display: <?php echo $formUserCr ?>" class="h-100">
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
                                    <input type="text" name="nomUser" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="prenomUser" class="<?php echo $Label; ?>">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUser" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="courriel" class="<?php echo $Label; ?>">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courriel" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp1" class="<?php echo $Label; ?>">Mot de passe</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp1" class="form-control <?php echo $borderInput; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="mdp2" class="<?php echo $Label; ?>">Confirmation Mdp</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" name="mdp2" class="form-control <?php echo $borderInput; ?>" required>
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

                        <!-- Footer -->
                        <div class="card-footer d-flex align-items-center justify-content-evenly p-2 m-0 <?php echo $CardFooter; ?>">

                            <!-- bouton Créer -->
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-75 p-0 m-0 <?php echo $Bouton; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/ajouterAdminUser.png" alt="créerUser" style="width: 60px; height: 60px">
                                        <span class="<?php echo $TextBouton; ?>">Créer</span>
                                    </div>
                                </button>
                            </div>

                            <!-- bouton Consulter -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=users&action=consulter" class="w-75 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/modifierAdminUser.png" alt="modifierUser" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Consulter</span>
                                    </div>
                                </a>
                            </div>

                            <!-- bouton Retour -->
                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php" class="w-75 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </form>

                    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Modification d'un utilisateur  ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
                    <form action="pageUsers.php" method="post" style="display : <?php echo $formModifUser ?>" class="h-100">
                        <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">

                            <!-- Données -->
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
                                    <input type="text" name="nomUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueNomUser; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="prenomUser" class="<?php echo $Label; ?>">Prénom</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="prenomUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valuePrenomUser; ?>" required>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <label for="courrielUser" class="<?php echo $Label; ?>">Courriel du CTR</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="courrielUserModif" class="form-control <?php echo $borderInput; ?>" value="<?php echo $valueCourrielUser; ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer p-2 m-0 d-flex align-items-center justify-content-evenly <?php echo $CardFooter; ?>">
                            <div class="col-4 d-flex justify-content-center">
                                <button type="submit" class="w-100 <?php echo $Bouton; ?>">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="icones/modifier.png" alt="modifier" style="width: 60px; height: 60px;">
                                        <span class="<?php echo $TextBouton; ?>">Modifier</span>
                                    </div>
                                </button>
                            </div>

                            <div class="col-4 d-flex justify-content-center">
                                <a href="admin.php?page=users&action=consulter" class="w-100 m-0 p-0 <?php echo $BtnA; ?>">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px;">
                                        <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤   Body Contexte Ajout Utilisateurs ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->

                    <!-- Body -->
                    <div class="card-body <?php echo $CardBody; ?>" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row w-100">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h4 class="<?php echo $TextCardBody; ?>"><?php echo $messageCreaUser; ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer <?php echo $CardFooter; ?>" style="display: <?php echo $contextBodyCreaUser ?>">
                        <div class="row d-flex align-items-center">
                            <br>
                        </div>
                    </div>

                    <!-- Liste -->
                    <div class="card-body h-25 listeOverflow <?php echo $CardBody; ?>" style="display: <?php echo $listeUsers; ?>">
                        <table class="w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">#</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Nom</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Prénom</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Admin</th>
                                    <th scope="col" class="fw-bold <?php echo $Table; ?>">Courriel</th>

                                    <?php
                                    if ($_SESSION["admin"] == true) {

                                    ?>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Modifier</th>
                                        <th scope="col" class="fw-bold <?php echo $Table; ?>">Supprimer</th>
                                    <?php

                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider <?php echo $TableBorder; ?>">
                                <?php
                                $sql = "SELECT * FROM users";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        if ($_SESSION["admin"] == true) {
                                ?>

                                            <tr class="<?php echo $TableBorder; ?>">
                                                <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"] ?></th>
                                                <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["nom"] ?></td>
                                                <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["prenom"] ?></td>
                                                <td class="<?php echo $Table; ?> my-3 py-3 fw-bold <?php echo $row["admin"] == 1 ? "rougeCegep" : "bleuCegep" ?>"><?php echo $row["admin"] == 1 ? "Administrateur" : "Utilisateur standard" ?></td>
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
                                        } else {
                                        ?>

                                            <tr class="<?php echo $TableBorder; ?>">
                                                <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"] ?></th>
                                                <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["nom"] ?></td>
                                                <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["prenom"] ?></td>
                                                <td class="<?php echo $Table; ?> my-3 py-3 fw-bold <?php echo $row["admin"] == 1 ? "rougeCegep" : "bleuCegep" ?>"><?php echo $row["admin"] == 1 ? "Administrateur" : "Utilisateur standard" ?></td>
                                                <td class="<?php echo $Table; ?> my-3 py-3"><?php echo $row["email"] ?></td>
                                            </tr>

                                <?php
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Aucun événement</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer liste -->
                    <div class="card-footer w-100 justify-content-center align-items-center <?php echo $CardFooter; ?>" style="display: <?php echo $boutonRetourUser; ?>">
                        <div class="row d-flex align-items-center justify-content-center w-100">
                            <div class="col-4">
                                <a href="admin.php?page=users" class="w-100 align-items-center justify-content-center <?php echo $BtnA; ?>" style="display: <?php if ($_SESSION["admin"] == true) {
                                                                                                                                                                echo "flex";
                                                                                                                                                            } else {
                                                                                                                                                                echo "none";
                                                                                                                                                            } ?>">
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

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    Bas de page : Page de votes   ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>" style="display: <?php echo $pageAccueil; ?>;">
        <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
            <div class="offset col-xl-3"></div>
            <div class="col-xl-6">

                <form action="add.php" method="post">
                    <div class="card">

                        <!-- Entete -->
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

                        <!-- Données -->
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
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
                                                }
                                            } else {
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

                        <!-- Footer Page de votes -->
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

    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤    Bas de page : Thèmes  ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤  -->
    <!-- ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ ¤ -->
    <div class="container-fluid h-100 w-100 <?php echo $Background; ?>">
        <div class="row h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="col-xl-6 h-75 d-flex align-items-center">
                <div class="card h-75 w-100">

                    <!-- Entete -->
                    <div class="card-header d-flex align-items-center justify-content-center <?php echo $CardHeader; ?>">
                        <h3 class="m-0 p-0 <?php echo $TextCardHeader; ?>">Choix des thèmes</h3>
                    </div>

                    <!-- Images des thèmes -->
                    <div class="card-body h-100 w-100 d-flex flex-column justify-content-evenly <?php echo $CardBody; ?>">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center justify-content-center">
                                <img src="img/themeCegep.png" alt="Theme 1" class="<?php echo $borderImg; ?> w-100">
                            </div>
                            <div class="col-6 d-flex align-items-center justify-content-center">
                                <img src="img/themeDiablos.png" alt="Theme 2" class="<?php echo $borderImg; ?> w-100">
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer d-flex align-items-center justify-content-evenly p-2 m-0 <?php echo $CardFooter; ?>">

                        <!-- Theme 1 - theme bleu -->
                        <div class="col-6 d-flex justify-content-center align-items-center">
                            <a href="admin.php?style=0" class="w-75 m-0 p-0 d-flex justify-content-center align-items-center <?php echo $BtnA; ?>">
                                <img src="icones/CegepLogo.png" alt="Theme bleu">
                                <span class="fs-4 <?php echo $TextBtnA; ?>">Thème Cégep</span>
                            </a>
                        </div>

                        <!-- Theme 2 - theme lilas -->
                        <div class="col-6 d-flex justify-content-center align-items-center">
                            <a href="admin.php?style=1" class="w-75 m-0 p-0 d-flex justify-content-center align-items-center <?php echo $BtnA; ?>">
                                <img src="icones/DiablosLogo.png" alt="Theme lilas">
                                <span class="fs-4 <?php echo $TextBtnA; ?>">Thème Diablos</span>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>



    <?php

    // FONCTION

    //function test_input($data){
    // $data = trim($data);
    // $data = addslashes($data);
    // $data = htmlspecialchars($data);
    // return $data;
    //  }


    ?>
    <script src="js/bootstrap.js"></script>
    <script src="js/scriptPerso.js"></script>
</body>

</html>