<?php

    if($_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

    if($page == "users")
    {
        $pageUsers = "block";
        $barreMenuAdmin = "block";

        if($_SESSION["admin"] == false){
            $listeUsers = "block";
            $boutonRetourUser = "none";
            $formUserCr = "none";
        }
        else{
            $listeUsers = "none";
            $boutonRetourUser = "block";
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