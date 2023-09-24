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

        $servername = "cours.cegep3r.info";
        $username = "2230572";
        $password = "2230572";
        $dbname = "2230572-mathis-grondin";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

    ?>

    <div class="container-fluid contStats h-100 w-100">
        <div class="row rowStats">
            <div class="col-12 p-0 m-0">
                <div class="card m-0 p-0 d-flex justify-content-center">

                    <div class="card-header py-2 bg bg-bleuCegep">
                            <h2 class="text-center py-2 lilasCegep fontCegep fw-bold p-0 my-0"><img src="icones/stats.png" alt="stats" class="icons mx-3">Statistiques</h2>        
                    </div>

                    <div class="card-body bg bgLilasCegep">                
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

                    <div class="card-footer bg bg-bleuCegep d-flex justify-content-center align-items-center">
                        <div class="offset col-4"></div>
                        <div class="col-4 px-1 d-flex justify-content-center align-items-center">
                            <a href="admin.php" class="btn w-100 bg bgLilasCegep border-rouge-cegep w-100 bleuCegep fontCegep fw-bold rounded p-0 m-0"><img src="icones/retour.png" alt="retour" class="me-1 icons">Retour</a> 
                        </div>
                        <div class="offset col-4"></div>
                    </div>

                </div>
            </div>
 
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>