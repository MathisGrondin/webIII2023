<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

    <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "dlamrade";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";


        if($_SERVER["REQUEST_METHOD"] == "POST"){
            header("Location: index.php");
        }
        else{
            if(isset($_GET['addN']) && $_GET['addN'] == "1"){

                $sql = "SELECT positive_feedback_count FROM evenement WHERE id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $count = $row["positive_feedback_count"];
                $count++;

                $sql = "UPDATE feedback_counts SET positive_feedback_count = $count WHERE id = 1";
                $result = $conn->query($sql);

                header("Location: index.php");
                echo "<div class=\"alert alert-success\" role=\"alert\">Merci d'avoir rempli le formulaire 1</div>";
            }
            else if (isset($_GET['addN']) && $_GET['addN'] == "2"){
                echo "<div class=\"alert alert-warning\" role=\"alert\">Merci d'avoir rempli le formulaire 2</div>";
            }
            else if (isset($_GET['addN']) && $_GET['addN'] == "3"){
                echo "<div class=\"alert alert-danger\" role=\"alert\">Merci d'avoir rempli le formulaire 3</div>";
            }
            else{
                echo "<div class=\"alert alert-danger\" role=\"alert\">Erreur</div>";
            }
        }
    ?>

    <script src="js/bootstrap.js"></script>
    <script src="js/script.js"></script>
</body>
</html>