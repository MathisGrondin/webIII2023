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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

    <div class="container-fluid">
        <div class="row bg-bleuCegep py-3">
            <div class="col-xl-2 col-10 d-flex align-items-center justify-content-between">
                <a href="admin.php" class="btn bg bgLilasCegep fontCegep fw-bold bleuCegep">Retour</a> 
                <h2 class="ms-3 mt-2 lilasCegep fontCegep fw-bold">Statistiques</h2>               
            </div>
        </div>

        <div class="row p-3">
        <div class="offset col-2"></div>
            <div class="col-8 d-flex justify-content-center align-items-center">
                <table>
                    <thead>
                        <tr class="bg-bleuCegep text-center lilasCegep border-rouge-cegep">
                            <th scope="col" class="fontCegep fw-bold px-3 py-3">Id</th>
                            <th scope="col" class="fontCegep fw-bold px-3 py-3">Événement</th>
                            <th scope="col"><img src="icones/aime.png" alt="aime" height="150" class="px-3 py-3"></th>
                            <th scope="col"><img src="icones/neutre.png" alt="neutre" height="150" class="px-3 py-3"></th>
                            <th scope="col"><img src="icones/deteste.png" alt="deteste" height="150" class="px-3 py-3"></th>
                        </tr>
                    </thead>
                    
                    <tbody class="table-group-divider">
                        <?php
                            $sql = "SELECT * FROM `evenements`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr class="text-center border-bleuCegep bgLilasCegep">';
                                        echo '<th scope="row" class="bleuCegep">'.$row["id"].'</th>';
                                        echo '<td class="px-3 py-3 bleuCegep">'.$row["nom"].'</td>';
                                        echo '<td class="px-3 py-3 bleuCegep">'.$row["nbAimeEtu"]. ' | <span class="rougeOrangeCegep">' . $row["nbAimeEmp"] . '</span></td>';
                                        echo '<td class="px-3 py-3 bleuCegep">'.$row["nbNeutreEtu"]. ' | <span class="rougeOrangeCegep">' . $row["nbNeutreEmp"] . '</td>';
                                        echo '<td class="px-3 py-3 bleuCegep">'.$row["nbDetesteEtu"]. ' | <span class="rougeOrangeCegep">' . $row["nbDetesteEmp"] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                        ?>
                        
                    </tbody>
                </table> 
            </div>
        <div class="offset col-2"></div>
        </div>
        </div>
 
 


            
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>