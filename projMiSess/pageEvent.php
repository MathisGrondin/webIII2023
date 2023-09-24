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
    
    
    else if(isset($_GET["errCreation"]) && $_GET["errCreation"] == 0)
    {
        $pageEvent = "block";
        $formCreation = "block";
    }


    else if(isset($_GET["errCreation"]) && $_GET["errCreation"] == 1)
    {
        $pageEvent = "block";
        $formCreation = "block";
        echo "<div class='alert alert-danger'>Merci de remplir tous les champs</div>";
    }

    
    else if(isset($_GET["errCreation"]) && $_GET["errCreation"] == 2){
        $pageEvent = "block";
        $formCreation = "block";
        echo "<div class='alert alert-danger'>Erreur lors de la création de l'événement</div>";
    }
    







?>