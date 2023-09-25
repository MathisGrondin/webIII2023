<?php

    $tempsAttente = 1000;

// s'il n'est pas connecté
    if($_SERVER["REQUEST_METHOD"] == "GET" &&  !isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

// s'il est connecté
else{
    if($_SESSION["admin"] == false){
        //? Si l'utilisateur est connecté mais n'est pas admin, 
        //? il a accès à la liste des utilisateurs seulement

        $pageUsers          = "block";
        $listeUsers         = "block";
        $boutonRetourUser   = "none" ;
        $formUserCr         = "none" ;
    }
    else{
        //? Si l'utilisateur est connecté et est admin,
        //? il a accès à la liste des utilsateurs et au formulaire de création

        $pageUsers          = "block";
        $listeUsers         = "none";
        $boutonRetourUser   = "block";
        $formUserCr         = "block";

        //? Si l'utilisateur est connecté et est admin,
        //? Si l'utilisateur clique sur le bouton "Liste utilisateurs" à partir du formulaire,

        if(isset($_GET["action"])){

            $action = $_GET["action"];

            if($action == "Modifier"){
                $pageUsers      = "block";
                $listeUsers     = "block";
                $formUserCr     = "none";
            }
        }

        if(!isset($_GET["action"]) && $listeUsers == "block"){
            $pageUsers = "block";
            $listeUsers = "none";
            $formUserCr = "block";
        }

        if(isset($_GET["state"])){
            $state = $_GET["state"];

            if($state == 0){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Utilisateur créé avec succès";
                retourPage('users', $tempsAttente);
            }
            else if($state == 1){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Erreur lors de la création de l'utilisateur";
                retourPage('users', $tempsAttente);
            }
            else if($state == 2){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Merci de remplir tous les champs";
                retourPage('users', $tempsAttente);
            }
            else if($state == 3){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Mot de passe différents dans les 2 champs";
                retourPage('users', $tempsAttente);
            }
        }
    }
}


function retourPage($page, $sTemps){

    $jsBack = 
        '
            <script>
                setTimeout
                (
                    function(){
                        window.location.href = "admin.php?page=' . $page . '"
                    }, ' . $sTemps . '
                );
            </script>
        ';


    echo $jsBack;

}


?>