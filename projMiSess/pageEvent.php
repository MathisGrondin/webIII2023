<?php

// SI DÉSIRE ALLER SUR PAGE Événements

    $pageEvent = "block";

    if(!isset($_GET["action"]) && $afficherliste == "block")
    {
        $pageEvent = "block";
        $afficherliste = "none";
        $formCreation = "block";
    }


    if(isset($_GET["action"]))
    {
        $action = $_GET["action"];
    
        if($action == "Modifier") 
        {
            $pageEvent = "block";
            $afficherliste = "block";
            $formCreation = "none";
        }
    }  
    
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






?>