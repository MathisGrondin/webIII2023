<?php

// s'il n'est pas connecté
    if($_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

// s'il est connecté
else{
    if($_SESSION["admin"] == false){
        $pageUsers = "block";
    }
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