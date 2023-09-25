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
        $listeUsers = "block";
        $boutonRetourUser = "none";
        $formUserCr = "none";
    }
    else{
        $pageUsers = "block";
        $listeUsers = "none";
        $boutonRetourUser = "block";
        $formUserCr = "block";

        if(isset($_GET["action"])){
            $action = $_GET["action"];

            if($action == "Modifier"){
                $pageUsers = "block";
                $listeUsers = "block";
                $formUserCr = "none";
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
                echo '
                    <script>
                        setTimeout(function()
                        {
                            window.location.href = "admin.php?page=users"
                        },1000);
                    </script>';
            }
            else if($state == 1){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Erreur lors de la création de l'utilisateur";

                echo '
                    <script>
                        setTimeout(function()
                        {
                            window.location.href = "admin.php?page=users"
                        },1000);
                    </script>';
            }
            else if($state == 2){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Merci de remplir tous les champs";

                echo '
                    <script>
                        setTimeout(function()
                        {
                            window.location.href = "admin.php?page=users"
                        },1000);
                    </script>';
            }
            else if($state == 3){
                $formUserCr = "none";
                $contextBodyCreaUser = "flex";
                $messageCreaUser = "Mot de passe différents dans les 2 champs";

                echo '
                    <script>
                        setTimeout(function()
                        {
                            window.location.href = "admin.php?page=users"
                        },1000);
                    </script>';
            }
        }
    }
}






    // if($page == "users")
    // {
    //     $pageUsers = "block";
    //     $barreMenuAdmin = "block";

    //     if($_SESSION["admin"] == false){
    //         $listeUsers = "block";
    //         $boutonRetourUser = "none";
    //         $formUserCr = "none";
    //     }
    //     else{
    //         $listeUsers = "none";
    //         $boutonRetourUser = "block";
    //         $formUserCr = "block";
    //     }

    //     if(isset($_GET["action"])){
    //         $action = $_GET["action"];

    //         if($action == "Modifier"){
    //             $listeUsers = "block";
    //             $formUserCr = "none";
    //         }
    //     }

    // }

?>