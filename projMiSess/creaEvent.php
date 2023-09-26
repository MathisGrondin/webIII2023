<?php
    session_start();

    $servername = "cours.cegep3r.info";
    $username = "2230572";
    $password = "2230572";
    $dbname = "2230572-mathis-grondin";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    // Check connection
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1 || $_SERVER["REQUEST_METHOD"] != "POST") {
        header('Location: index.php');
    }

    

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["admin"] == 1){
        
        if(isset($_POST["dateEvent"], $_POST["lieuEvent"], $_POST["nomEvent"], $_POST["programme"]) && $_POST["dateEvent"] != "" && $_POST["lieuEvent"] != "" && $_POST["nomEvent"] != "" && $_POST["programme"] != "") {
            $dateEvent = $_POST["dateEvent"];
            $lieuEvent = $_POST["lieuEvent"];
            $nomEvent = $_POST["nomEvent"];
            $programme = $_POST["programme"];

            $placeQuoteLieu = stripos($lieuEvent, '\'');
            $placeQuoteNom = stripos($nomEvent, '\'');
            $placeQuoteProg = stripos($programme, '\'');

            if($placeQuoteLieu != null){
                $substringLieu = substr($lieuEvent, 0, $placeQuoteLieu);
            }
            else{
                echo $lieuEvent . "<br>";
                $substringLieu = $lieuEvent;
            }

            if($placeQuoteNom != null){
                $substringNom = substr($nomEvent, 0, $placeQuoteNom);
                echo $substringNom . "<br>";
            }
            else{
                echo $nomEvent . "<br>";
                $substringNom = $nomEvent;
            }
            if($placeQuoteProg != null){
                $substringProg = substr($programme, 0, $placeQuoteProg);
                $substringProg = $substringProg . "\\";
                $substringProg = $substringProg . substr($programme, $placeQuoteProg);
                echo $substringProg . "<br>";
            }
            else{
                echo $programme . "<br>";
                $substringProg = $programme;
            }  

            echo $programme . "<br>";

            $sql = "INSERT INTO evenements
                    VALUES (null, '$substringNom', '$substringLieu', '$dateEvent', '$substringProg', 0, 0, 0, 0, 0, 0)";
            $result = $conn->query($sql);

            echo $sql . "<br>";
            echo $result;

            if($result) {
                header("Location: admin.php?page=events&state=0");
            }
            else {
                // echo $result;
                header("Location: admin.php?page=events&state=1");
            }
        }
        else if($_POST["dateEvent"] == "" || $_POST["lieuEvent"] == "" || $_POST["nomEvent"] == "" || $_POST["programme"] == ""){
            header("Location: admin.php?page=events&state=2");
        }
        else{
            // header("Location: admin.php?page=events&errCreation=1");
            header("Location: admin.php?page=events&state=1");
        }


    }




?>
