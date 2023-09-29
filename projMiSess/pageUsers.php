<?php

    $tempsAttente = 1000;

// s'il n'est pas connecté
    if(!isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nomUser = $_POST["nomUserModif"];
        $prenomUser = $_POST["prenomUserModif"];
        $emailUser = $_POST["courrielUserModif"];
        $idUser = $_POST["idUserModif"];

        if(empty($nomUser) || empty($prenomUser) || empty($emailUser) || empty($idUser)){
            if(!empty($idUser)){
                // create connection
                $servername = "cours.cegep3r.info";
                $username = "2230572";
                $password = "2230572";
                $dbname = "2230572-mathis-grondin";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                $conn->set_charset("utf8");

                // Check connection
                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users WHERE id = $idUser";
                $result = $conn->query($sql);

                while($result -> fetch_assoc()){
                    $nomUser = $result["nom"];
                    $prenomUser = $result["prenom"];
                    $emailUser = $result["email"];
                }
            }
        }
        else{
            $servername = "cours.cegep3r.info";
            $username = "2230572";
            $password = "2230572";
            $dbname = "2230572-mathis-grondin";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->set_charset("utf8");

            // Check connection
            if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "UPDATE users 
                    SET nom     = '$nomUser',
                        prenom  = '$prenomUser',
                        email   = '$emailUser'
                    WHERE id    = $idUser";

            $result = $conn->query($sql);
            echo $sql;

            if ($result == true){
                sleep(2);
                header("Location: admin.php?page=users&state=10");
            }
            else {
                sleep(2);
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

                // create connection
                $servername = "cours.cegep3r.info";
                $username = "2230572";
                $password = "2230572";
                $dbname = "2230572-mathis-grondin";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                $conn->set_charset("utf8");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users WHERE id = $idUser";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $valuenomUser = $row["nom"];
                        $valueprenomUser = $row["prenom"];
                        $valueCourrielUser = $row["email"];
                        $idUser = $row["id"];
                    }
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

            if($state == 0){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Utilisateur créé avec succès";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 1){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Erreur lors de la création de l'utilisateur";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 2){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Merci de remplir tous les champs";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 3){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Mot de passe différents dans les 2 champs";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 10){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Utilisateur modifié avec succès";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 11){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Erreur lors de la modification de l'utilisateur";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 12)
            {
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Merci de remplir tous les champs";
                sleep(2);
                retourPage('users', $tempsAttente);
            }
            else if($state == 45){
                $formUserCr             = "none";
                $formModifUser          = "none";
                $contextBodyCreaUser    = "flex";
                $messageCreaUser        = "Problème post";
                sleep(2);
                retourPage('users', $tempsAttente);
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

?>