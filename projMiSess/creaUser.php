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
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    if(!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1 || $_SERVER["REQUEST_METHOD"] != "POST") {
        header('Location: index.php');
    }

?>