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
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styleStats.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <title>Statistiques</title>
</head>
<body>

    <?php
        $sumEtu = 0;
        $sumEmp = 0;

        // Connexion à la BD
        include 'connBD.php';

    ?>

    <div class="container-fluid contStats h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="row h-100 w-100 d-flex align-items-center justify-content-center">
                <div class="card w-75 h-75 d-flex justify-content-center p-0 m-0">

                    <div class="card-header py-2 bg bg-bleuCegep border-rouge-cegep">
                            <h2 class="text-center py-2 lilasCegep fontCegep fw-bold p-0 my-0">
                                <img src="icones/stats.png" alt="stats" class="icons mx-3">
                                <span>
                                    Statistiques
                                </span> 
                            </h2>        
                    </div>

                    <div class="card-body bg bgLilasCegep border-bleuCegep border-top-0 border-bottom-0" id="bodyStats">                
                        <div class="row m-0 p-0">      
                            <table class="m-0 p-0 caption-top">
                                <caption><span class="bleuCegep fw-bold fontCegep">Étudiants | </span><span class="rougeOrangeCegep fw-bold fontCegep">Employés</span></caption>

                                <thead>
                                    <tr class="bg-bleuCegep text-center lilasCegep p-0 m-0">
                                        <th scope="col" class="fontCegep fw-bold py-3">Id</th>
                                        <th scope="col" class="fontCegep fw-bold py-3">Événement</th>
                                        <th scope="col"><img src="icones/aime.png" alt="aime" height="150" class="py-3 iconsAvis"></th>
                                        <th scope="col"><img src="icones/neutre.png" alt="neutre" height="150" class="py-3 iconsAvis"></th>
                                        <th scope="col"><img src="icones/deteste.png" alt="deteste" height="150" class="py-3 iconsAvis"></th>
                                        <th scope="col" class="fontCegep fw-bold py-3">Total votes</th>
                                    </tr>
                                </thead>

                                <tbody class="table-group-divider">
                                    <?php
                                        $sql = "SELECT * FROM `evenements`";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr class="text-center border-bottom border-dark">
                                                    <th scope="row" class="fontCegep bleuCegep"><?php echo $row["id"] ?></th>
                                                    <td class="fontCegep bleuCegep my-3 py-3"><?php echo $row["nom"] ?></td>
                                                    <td class="fontCegep bleuCegep my-3 py-3"><?php echo $row["nbAimeEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbAimeEmp"] ?></span></td>
                                                    <td class="fontCegep bleuCegep my-3 py-3"><?php echo $row["nbNeutreEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbNeutreEmp"] ?></td>
                                                    <td class="fontCegep bleuCegep my-3 py-3"><?php echo $row["nbDetesteEtu"] ?><span class="rougeOrangeCegep"> | <?php echo $row["nbDetesteEmp"] ?></td>
                                                    
                                                    <?php
                                                    $sumEmp = $sumEtu = 0;
                                                    $sumEtu += $row["nbAimeEtu"] + $row["nbNeutreEtu"] + $row["nbDetesteEtu"];
                                                    $sumEmp += $row["nbAimeEmp"] + $row["nbNeutreEmp"] + $row["nbDetesteEmp"];
                                                    ?>

                                                    <td class="fontCegep bleuCegep my-3 py-3"><?php echo $sumEtu ?><span class="rougeOrangeCegep"> | <?php echo $sumEmp ?></span></td>
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

                    <div class="card-footer bg bg-bleuCegep border-rouge-cegep d-flex justify-content-center align-items-center">
                        <div class="offset col-4"></div>
                        <div class="col-4 px-1 d-flex justify-content-center align-items-center">
                            <a href="admin.php" class="btn w-100 bg bgLilasCegep border-rouge-cegep w-100 bleuCegep fontCegep fw-bold rounded p-0 m-0"><img src="icones/retour.png" alt="retour" class="me-1 icons">Retour</a> 
                        </div>
                        <div class="offset col-4"></div>
                    </div>

                </div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>