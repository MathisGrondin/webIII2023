<?php
    session_start();

    $_SESSION["user"] = null;
    $_SESSION["admin"] = null;

    $resultAjout = "";
    $voirBoutons = "flex";
    $messageConfirm = "none";

    if(isset($_GET["ajout"]) && $_GET["ajout"] == "ok"){
        $resultAjout = "Merci ! <br><br>Votre réponse a été ajoutée 🙂";
        $voirBoutons = "none";
        $messageConfirm = "flex";
        echo '
        <script>
            setTimeout(function()
            {
                window.location.href = "index.php"
            }, 2 * 1000);
        </script>';
    }
    else if( isset($_GET["ajout"]) && $_GET["ajout"] == "erreur"){
        $resultAjout = "Désolé une erreur s'est produite.";
    }
    else{
        $resultAjout = "";
        $voirBoutons = "flex";
        $messageConfirm = "none";
    }

    if(isset($_SESSION['type']) && isset($_SESSION['event'])){
        $backgroundURL = ($_SESSION["type"]=="etudiant") ? ("background") : ("backgroundEmp");
    }
    else{
        header("Location: admin.php");
    }
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="favicons/favicon-votes.png" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styleIndex.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <title>Formulaire satisfaction</title>
</head>
<body>
    <!-- Carte principale -->
    <div class="container-fluid" id="conteneurCarte" style='background-image: url("img/<?php echo $backgroundURL; ?>.png"); height: 100vh; width: 100vw;'>
        <div class="row d-flex justify-content-center align-items-center" id="rowCarte" style='background-image: url("img/<?php echo $backgroundURL; ?>.png"); height: 100vh; width: 100vw;'>
            <div class="offset col-xl-2 col-m-2"></div>
            <div class="col-xl-8 col- col-m-8 col-12">
                <div class="card border-bleuCegep">

                <!-- Entete -->
                    <div class="card-header bg bg-bleuCegep">
                        <h1 class="fontCegep lilasCegep text-center fw-bold">Appréciation de l'événement</h1>
                    </div>

                <!-- Partie de votes -->
                    <div class="card-body bg bgLilasCegep">
                        <div class="row text-center my-5" style="display: <?php echo $voirBoutons; ?>">
                            <div class="offset col-1"></div>

                            <div class="col-2">
                                <a href="add.php?addN=1" class="btn btn-success w-100 h-100 border border-3 border-light rounded">
                                    <div class="d-flex justify-content-between flex-column w-100 h-100">
                                        <img src="icones/aime.png" alt="aime" class="imgAvis">
                                        <p class="p-0 m-0 fw-bold">Adore</p>
                                    </div>
                                </a>                                
                            </div>

                            <div class="offset col-2"></div>
                            <div class="col-2">
                                <a href="add.php?addN=2" class="btn btn-warning w-100 h-100 border border-3 border-light">
                                    <div class="d-flex justify-content-between flex-column w-100 h-100">
                                        <img src="icones/neutre.png" alt="neutre" class="imgAvis">
                                        <p class="p-0 m-0 fw-bold">Neutre</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset col-2"></div>

                            <div class="col-2">
                                <a href="add.php?addN=3" class="btn btn-danger w-100 h-100 border border-3 border-light rounded">
                                    <div class="d-flex justify-content-between flex-column w-100 h-100">
                                        <img src="icones/deteste.png" alt="deteste" class="imgAvis">
                                        <p class="p-0 m-0 fw-bold">Déteste</p>
                                    </div>
                                </a>
                            </div>

                            <div class="offset col-1"></div>
                        </div>

                    <!-- Message de confirmation du vote  -->
                        <div class="row text-center my-5" style="display: <?php echo $messageConfirm; ?>">
                            <div class="col-xl-12 col-12">
                                <h4><?php echo $resultAjout; ?></h4>
                            </div>
                        </div>

                    </div>

                <!-- Pied de page -->
                    <div class="card-footer bg bg-bleuCegep py-4 text-center d-flex justify-content-center align-content-center">
                        <h4 class="fontCegep lilasCegep p-0 m-0 fw-bold fs-2"><?php echo $_SESSION["event"]; ?> | <?php if($_SESSION["type"] == "etudiant"){echo "Étudiants";}else if($_SESSION["type"] == "employeur"){echo "Employeurs";} ?></h4>
                    </div>

                </div>
            </div>
            <div class="offset col-xl-2 col-m-2"></div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>