<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr-ca" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body class="h-100">

    <?php
        


        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(isset($_POST["quelEvent"]) && isset($_POST["quiRepond"])){
                if(!isset($_SESSION["event"]) || !isset($_SESSION["type"])){
                    $_SESSION["event"] = $_POST["quelEvent"];
                    $_SESSION["type"] = $_POST["quiRepond"];
                }
                else{
                    $_SESSION["event"] = $_POST["quelEvent"];
                    $_SESSION["type"] = $_POST["quiRepond"];
                }
                header("Location: index.php");
            }
        }
        else{


            


            // ajout d'un commentaire si on connait l'event, le type et le commentaire
            if(isset($_GET["addN"]) && $_GET["addN"] != "" && isset($_SESSION["event"]) && $_SESSION["event"] != "" && isset($_SESSION["type"]) && $_SESSION["type"] != ""){
                $addN = $_GET["addN"];
                $event = $_SESSION["event"];
                $type = $_SESSION["type"];

                // Connexion à la base de données
                $servername = "cours.cegep3r.info";
                $username = "2230572";
                $password = "2230572";
                $dbname = "2230572-mathis-grondin";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                

                if($type == "etudiant"){
                    switch($addN){
                        case 1:
                            $sql = "SELECT nbAimeEtu FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbAimeEtu"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbAimeEtu = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>

                            <?php
                            break;
                        case 2:
                            $sql = "SELECT nbNeutreEtu FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbNeutreEtu"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbNeutreEtu = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>

                            <?php
                            break;
                        case 3:
                            $sql = "SELECT nbDetesteEtu FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbDetesteEtu"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbDetesteEtu = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                    }
                }
                else if($type == "employeur"){
                    switch($addN){
                        case 1:
                            $sql = "SELECT nbAimeEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbAimeEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbAimeEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                        case 2:
                            $sql = "SELECT nbNeutreEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbNeutreEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbNeutreEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                        case 3:
                            $sql = "SELECT nbDetesteEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbDetesteEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbDetesteEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                    }
                    header("Location: index.php");
                }
            }
            else{
                ?>
                    <div class="container-fluid h-100">
                        <div class="row h-100">
                            <div class="offset col-xl-4 col-2"></div>
                            <div class="col-xl-4 col-8 d-flex align-items-center justify-content-center">
                                <div class="alert alert-danger text-center">
                                    <h2>Cette page n'est pas accessible de cette manière, merci de retourner sur la page principale.</h2>
                                </div>
                            </div>
                            <div class="offset col-xl-4 col-2"></div>
                        </div>
                    </div>
                <?php
            }
        }
    ?>

    <script src="js/bootstrap.js"></script>
    <script src="js/script.js"></script>
</body>
</html>