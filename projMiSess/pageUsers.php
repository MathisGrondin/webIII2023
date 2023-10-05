<?php

    $tempsAttente = 1000;
    include("connBD.php");

// s'il n'est pas connecté
    if(!isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nomUser    = test_input($_POST["nomUserModif"]     );
        $prenomUser = test_input($_POST["prenomUserModif"]  );
        $emailUser  = test_input($_POST["courrielUserModif"]);
        $idUser     = test_input($_POST["idUserModif"]      );

        if(empty($nomUser) || empty($prenomUser) || empty($emailUser) || empty($idUser))
        {
            if(!empty($idUser))
            {
                $sql    = "SELECT * FROM users WHERE id = $idUser";
                $result = $conn->query($sql);

                while($result -> fetch_assoc())
                {
                    $nomUser    = $result["nom"];
                    $prenomUser = $result["prenom"];
                    $emailUser  = $result["email"];
                }
            }
        }
        else{

            $sql = "UPDATE users SET nom = '$nomUser', prenom = '$prenomUser', email = '$emailUser' WHERE id = $idUser";

            $result = $conn->query($sql);

            if ($result === true){
                header("Location: admin.php?page=users&state=10");
            }
            else {
                header("Location: admin.php?page=users&state=11");

            }

            $conn->close();
        }
    }
    // s'il est connecté
    else{
        if($_SESSION["admin"] == false){
            //? Si l'utilisateur est connecté mais n'est pas admin, 
            //? il a accès à la liste des utilisateurs seulement

            $pageUsers          = "block";
            $listeUsers         = "block";
            $titreCarteUser     = "Liste des utilisateurs" ;
            $boutonRetourUser   = "flex" ;
            $formUserCr         = "none" ;
        }
        else{
            //? Si l'utilisateur est connecté et est admin,
            //? il a accès à la liste des utilisateurs et au formulaire de création

            $pageUsers          = "block";
            $listeUsers         = "none";
            $titreCarteUser     = "Création d'un utilisateur";
            $formUserCr         = "block";
            $boutonRetourUser   = "none";

            //? Si l'utilisateur est connecté et est admin,
            //? Si l'utilisateur clique sur le bouton "Consulter" à partir du formulaire,

            if(isset($_GET["action"])){

            $action = $_GET["action"];

            if($action == "consulter"){
                $pageUsers          = "block";
                $listeUsers         = "block";
                $titreCarteUser     = "Liste des utilisateurs";               
                $boutonRetourUser   = "flex";
                $formUserCr         = "none"; 
            }
            else if($action == "Modifier"){
                $pageUsers          = "block";
                $listeUsers         = "none";
                $titreCarteUser     = "Modification d'un utilisateur";
                $boutonRetourUser   = "none";
                $formUserCr         = "none";
                $formModifUser      = "block";
                $idUser             = $_GET["id"];

                $sql = "SELECT * FROM users WHERE id = $idUser";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $idUser = $row["id"];
                        $valueNomUser = $row["nom"];
                        $valuePrenomUser = $row["prenom"];
                        $valueCourrielUser = $row["email"];
                    }
                }
            }
            else if($action == "Supprimer"){
                $pageUsers          = "block";
                $listeUsers         = "block";
                $titreCarteUser     = "Liste des utilisateurs";
                $boutonRetourUser   = "flex";
                $formUserCr         = "none";
                $idUser             = $_GET["id"];

                $sql = "DELETE FROM users WHERE id = $idUser";
                $result = $conn->query($sql);

                if($result === true){
                    header("Location: admin.php?page=users&state=20");
                }
                else{
                    header("Location: admin.php?page=users&state=21");
                }
            }
        }
        else{
            $pageUsers          = "block";
            $listeUsers         = "none";
            $formUserCr         = "block";
            $boutonRetourUser   = "none";
            $titreCarteUser     = "Création d'un utilisateur";
        }

        //? Si l'utilisateur est connecté et est admin,
        //? si l'utilisateur clique sur le bouton "Retour" à partir de la liste des utilisateurs,

        if(!isset($_GET["action"]) && $listeUsers == "block"){
            $pageUsers          = "block";
            $listeUsers         = "none";
            $titreCarteUser     = "Création d'un utilisateur";
            $formUserCr         = "block";
            $boutonRetourUser   = "none";
        }

        //? Si l'utilisateur est connecté et est admin,
        //? si l'utilisateur clique sur le bouton "Créer" à partir du formulaire,
        if(isset($_GET["state"])){
            $state = $_GET["state"];

            switch($state){
                case 0 : 
                    {
                        //? Création effectuée avec succès

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Utilisateur créé avec succès";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 1 : 
                    {

                        //? Erreur lors de la création de l'utilisateur

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Erreur lors de la création de l'utilisateur";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 2 : 
                    {

                        //? Champs manquants

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Merci de remplir tous les champs";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 3 : 
                    {

                        //? Mot de passe différents dans les 2 champs

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Mot de passe différents dans les 2 champs";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 10 : 
                    {

                        //? Modification effectuée avec succès

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Utilisateur modifié avec succès";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 11 : 
                    {

                        //? Erreur lors de la modification de l'utilisateur

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Erreur lors de la modification de l'utilisateur";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 12 : 
                    {

                        //? Champs manquants

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Merci de remplir tous les champs";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 20 : 
                    {

                        //? Suppression effectuée avec succès

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Utilisateur supprimé avec succès";
                        retourPage('users', $tempsAttente);
                        break;
                    }

                case 21 :
                    {

                        //? Erreur lors de la suppression de l'utilisateur

                        $pageUsers          = "block";
                        $listeUsers         = "none";
                        $formUserCr         = "none";
                        $contextBodyCreaUser= "flex";
                        $messageCreaUser    = "Erreur lors de la suppression de l'utilisateur";
                        retourPage('users', $tempsAttente);
                        break;
                    }
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
                        window.location.href = "admin.php?page=' . $page . '"
                    }, ' . $sTemps . '
                );
            </script>
        ';
}



function test_input($data){
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>