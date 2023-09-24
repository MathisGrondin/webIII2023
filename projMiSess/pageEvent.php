<?php

// $_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"])

// Si va sur la page events sans être connecté
    if($_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

// Sinon, si l'utilisateur est connecté 
else 
{
    if($_SESSION["admin"] == false){
        $pageEvent = "block";
        $afficherliste = "block";
        $boutonRetourEvent = "flex";
        $idBarreBas = "visibile";
        $formCreation = "none";
    }
    else{
        $pageEvent = "block";
        $afficherliste = "none";
        $formCreation = "block";
        $boutonRetourEvent = "none";
        $idBarreBas = "hidden";

        if(isset($_GET["action"]))
        {
            $action = $_GET["action"];
        
            if($action == "Modifier") 
            {
                $pageEvent = "block";
                $afficherliste = "block";
                $boutonRetourEvent = "flex";
                $formCreation = "none";
                $idBarreBas = "visible";
            }
        }
        else{
            $pageEvent = "block";
            $afficherliste = "none";
            $formCreation = "block";
            $boutonRetourEvent = "none";
            $idBarreBas = "hidden";
        }

        if(!isset($_GET["action"]) && $afficherliste == "block")
        {
            $pageEvent = "block";
            $afficherliste = "none";

            $boutonRetourEvent = "none";
            $formCreation = "block";
            $idBarreBas = "hidden";
        }
        // else{
        //     $pageEvent = "block";
        //     $afficherliste = "none";
        //     $formCreation = "block";
        //     $boutonRetourEvent = "none";
        //     $idBarreBas = "hidden";
        // }

        if(isset($_GET["state"])){
            $state = $_GET["state"];

            if($state == 0){
                $formCreation = "none";
                $contextBodyCreaEvent = "flex";
                $messageContexte = "Événement créé avec succès";
                echo '
                    <script>
                        setTimeout(function()
                        {
                            window.location.href = "admin.php?page=events"
                        },1000);
                    </script>';
            }
            else if($state == 1){
                $formCreation = "none";
                $contextBodyCreaEvent = "flex";
                $messageContexte = "Erreur lors de la création de l'événement";

                echo '
                <script>
                    setTimeout(function()
                    {
                        window.location.href = "admin.php?page=events"
                    },1000);
                </script>';

            }
            else if($state == 2){
                $formCreation = "none";
                $contextBodyCreaEvent = "flex";
                $messageContexte = "Merci de remplir tous les champs";

                echo '
                <script>
                    setTimeout(function()
                    {
                        window.location.href = "admin.php?page=events"
                    },1000);
                </script>';

            }
        }
    }
}







?>