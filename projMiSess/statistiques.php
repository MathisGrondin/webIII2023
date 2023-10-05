<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: index.php');
    }    
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="favicons/favicon-stats.png" type="image/x-icon">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styleStats.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <title>Statistiques</title>
</head>
<body>

    <?php
        $sumEtu = 0;
        $sumEmp = 0;

        //? Variable pour le thème
        if(!isset($_SESSION['style'])){
            $_SESSION['style'] = 0;
        }
        else if(isset($_SESSION['style']) && $_SESSION['style'] == 0){
            $_SESSION['style'] = 0;
        }
        else if(isset($_SESSION['style']) && $_SESSION['style'] == 1){
            $_SESSION['style'] = 1;
        }
        else{
            $_SESSION['style'] = 0;
        }

        if(isset($_SESSION['style'] )|| $_SESSION['style'] == 0){
            $_SESSION['style'] == 0;
            $CardHeader = "bg-bleuCegep border-rouge-cegep";
            $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
            $CardFooter = "bg-bleuCegep border-rouge-cegep";
            $Table = "fontCegep bleuCegep";
            $TableStats = "fontCegep py-3 lilasCegep";
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
        else if ($_SESSION['style'] == 1){
            $_SESSION['style'] == 1;
            $CardHeader = "bg-rougeCegep border-bleuCegep";
            $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
            $CardFooter = "bg-rougeCegep border-bleuCegep";
            $Table = "fontCegep bleuCegep";
            $TableStats = "fontCegep py-3 bleuCegep";
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

        //? Connexion à la BD
        include 'connBD.php';

        //? Changement de thème
        if(isset($_GET['style'])){
            $style = $_GET['style'];
            
            if($style == 0){
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
            else if ($style == 1){
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

        if(!isset($_GET['style'])){
            
            if($_SESSION['style'] == 0){
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
            else if ($_SESSION['style'] == 1){
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

    ?>

    <div class="container-fluid h-100 w-100 d-flex align-items-center justify-content-center <?php echo $Background; ?>">
        <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="card w-75 h-75 d-flex justify-content-center p-0 m-0">

                <!-- Entete  -->
                    <div class="card-header py-2 <?php echo $CardHeader; ?>">
                        <h2 class="py-2 p-0 my-0 <?php echo $TextCardHeader; ?>">
                            <img src="icones/stats.png" alt="stats" style="width: 60px; height: 60px">
                            <span> Statistiques </span> 
                        </h2>        
                    </div>

                    <!-- Statistiques -->
                    <div class="card-body <?php echo $CardBody; ?>" id="bodyStats">                
                        <div class="row m-0 p-0">      
                            <table class="m-0 p-0 caption-top">
                                <caption>
                                    <span class="bleuCegep fw-bold fontCegep">Étudiants | </span>
                                    <span class="rougeOrangeCegep fw-bold fontCegep">Employés</span>
                                </caption>

                                <thead>
                                    <tr class="bg-bleuCegep text-center lilasCegep p-0 m-0">
                                        <th scope="col" class="<?php echo $TableStats; ?>">Id</th>
                                        <th scope="col" class="<?php echo $TableStats; ?>">Événement</th>
                                        <th scope="col"><img src="icones/aime.png" alt="aime" style="width: 60px; height: 60px"></th>
                                        <th scope="col"><img src="icones/neutre.png" alt="neutre" style="width: 60px; height: 60px"></th>
                                        <th scope="col"><img src="icones/deteste.png" alt="deteste" style="width: 60px; height: 60px"></th>
                                        <th scope="col" class="<?php echo $TableStats; ?>">Total votes</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM `evenements`";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr class="<?php echo $TableBorder; ?>">
                                                    <th scope="row" class="<?php echo $Table; ?>"><?php echo $row["id"] ?></th>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nom"] ?></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nbAimeEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbAimeEmp"] ?></span></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nbNeutreEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbNeutreEmp"] ?></td>
                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $row["nbDetesteEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbDetesteEmp"] ?></td>
                                                    
                                                    <?php
                                                    $sumEmp = $sumEtu = 0;
                                                    $sumEtu += $row["nbAimeEtu"] + $row["nbNeutreEtu"] + $row["nbDetesteEtu"];
                                                    $sumEmp += $row["nbAimeEmp"] + $row["nbNeutreEmp"] + $row["nbDetesteEmp"];
                                                    ?>

                                                    <td class="my-3 py-3 <?php echo $Table; ?>"><?php echo $sumEtu ?><span class="rougeOrangeCegep"> | <?php echo $sumEmp ?></span></td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Aucun événement</td></tr>";
                                        }
                                        $conn->close();
                                            ?>
                                </tbody>
                            </table> 
                        </div>                               
                    </div>
                
                <!-- Bas de page et bouton retour -->
                    <div class="card-footer d-flex justify-content-center align-items-center <?php echo $CardFooter; ?>">
                        <div class="col-4 d-flex justify-content-center">
                            <a href="admin.php" class="m-0 p-0 w-75 <?php echo $BtnA; ?>">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="icones/retour.png" alt="retour" style="width: 60px; height: 60px">
                                    <span class="fs-4 <?php echo $TextBtnA; ?>">Retour</span>
                                </div>
                            </a>                                                                       
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>