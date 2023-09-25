<?php

    $tempsAttente = 1000;

// Si va sur la page events sans être connecté
    if($_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

// Sinon, si l'utilisateur est connecté 
else 
{
    if($_SESSION["admin"] == false){
        //? Si l'utilisateur est connecté mais n'est pas admin,
        //? il a accès à la liste des events seulement

        $pageEvent          = "block";
        $afficherliste      = "block";
        $titreCreation      = "Liste des événements";
        $boutonRetourEvent  = "flex";
        $formCreation       = "none";
    }
    else{
        //? Si l'utilisateur est connecté et est admin,
        //? il a accès à la liste des events et au formulaire de création

        $pageEvent          = "block";
        $afficherliste      = "none";
        $titreCreation      = "Création d'un événement";
        $formCreation       = "block";
        $boutonRetourEvent  = "none";

        //? Si l'utilisateur est connecté et est admin,
        //? Si l'utilisateur clique sur le bouton "Consulter" à partir du formulaire,

        if(isset($_GET["action"]))
        {
            $action = $_GET["action"];
        
            if($action == "consulter") 
            {
                $pageEvent = "block";
                $afficherliste = "block";
                $titreCreation = "Liste des événements";
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
            $titreCreation = "Création d'un événement";
        }

        //? Si l'utilisateur est connecté et est admin,
        //? si l'utilisateur clique sur le bouton "Retour" à partir de la liste des events,

        if(!isset($_GET["action"]) && $afficherliste == "block")
        {
            $pageEvent          = "block";
            $afficherliste      = "none";
            $titreCreation      = "Création d'un événement";
            $formCreation       = "block";
            $boutonRetourEvent  = "none";
        }

        //? Si l'utilisateur est connecté et est admin,
        //? si l'utilisateur clique sur le bouton "Créer" à partir du formulaire,
        if(isset($_GET["state"])){
            $state = $_GET["state"];

            if($state == 0){
                $formCreation           = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Événement créé avec succès";
                retourPage("events", $tempsAttente);
            }
            else if($state == 1){
                $formCreation           = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Erreur lors de la création de l'événement";
                retourPage("events", $tempsAttente);
            }
            else if($state == 2){
                $formCreation           = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Merci de remplir tous les champs";
                retourPage("events", $tempsAttente);
            }
        }
    }
}



function retourPage($page, $sTemps){

    echo'
            <script>
                setTimeout
                (
                    function(){
                        window.location.href = "admin.php?page="' . $page . '"
                    }, ' . $sTemps . '
                );
            </script>
        ';

}



?>