<?php

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET))
    {
        header("Location: admin.php");
    }

    if($page == "users")
    {
        $pageUsers = "block";
        $barreMenuAdmin = "block";

        if($_SESSION["admin"] == false){
            $listeUsers = "block";
            $formUserCr = "none";
        }
        else{
            $listeUsers = "none";
            $formUserCr = "block";
        }

        if(isset($_GET["action"])){
            $action = $_GET["action"];

            if($action == "Modifier"){
                $listeUsers = "block";
                $formUserCr = "none";
            }
        }

    }

?>