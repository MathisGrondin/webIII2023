<?php

    // session_start();

    $tempsAttente = 1000;

// Si va sur la page events sans être connecté
    if(!isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nomEvent = $_POST["nomEventModif"];
        $dateEvent = $_POST["dateEventModif"];
        $lieuEvent = $_POST["lieuEventModif"];
        $programme = $_POST["programmeModif"];
        $idEvent = $_POST["idEventModif"];

        if(empty($nomEvent) || empty($dateEvent) || empty($lieuEvent) || empty($programme) || empty($idEvent))
        {
            if(!empty($idEvent)){
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

                $SQL = "SELECT * FROM evenements WHERE id = $idEvent";
                $result = $conn->query($SQL);

                while($result -> fetch_assoc())
                {
                    $nomEvent = $result["nom"];
                    $dateEvent = $result["date"];
                    $lieuEvent = $result["lieu"];
                    $programme = $result["programme"];
                }

            }
        }
        else
        {            
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

                $sql = "UPDATE evenements SET 
                            nom = '$nomEvent', 
                            lieu = '$lieuEvent', 
                            date = '$dateEvent', 
                            programme = '$programme'
                        WHERE id = $idEvent";

            $result = $conn->query($sql);
            echo $sql;
            // echo $result;

            if ($result === TRUE) {
                sleep(2);
                header("Location: admin.php?page=events&state=10");
            } else {
                header("Location: admin.php?page=events&state=11");
            }

            $conn->close();
        }
    } 

// Sinon, si l'utilisateur est connecté 
else 
{
    if($_SESSION["admin"] == false){
        //? Si l'utilisateur est connecté mais n'est pas admin,
        //? il a accès à la liste des events seulement

        $pageEvent          = "block";
        $afficherliste      = "block";
        $titreCarteEvent    = "Liste des événements";
        $boutonRetourEvent  = "none";
        $formCreation       = "none";
    }
    else{

        //? Si l'utilisateur est connecté et est admin,
        //? il a accès à la liste des events et au formulaire de création

        $pageEvent          = "block";
        $afficherliste      = "none";
        $titreCarteEvent    = "Création d'un événement";
        $formCreation       = "block";
        $boutonRetourEvent  = "none";

        //? Si l'utilisateur est connecté et est admin,
        //? Si l'utilisateur clique sur le bouton "Consulter" à partir du formulaire,

        if(isset($_GET["action"]))
        {
            $action = $_GET["action"];
        
            if($action == "consulter") 
            {
                $pageEvent              = "block";
                $afficherliste          = "block";
                $titreCarteEvent        = "Liste des événements";
                $boutonRetourEvent      = "flex";
                $formCreation           = "none";               
            }
            else if($action = "modifier") {
                $pageEvent              = "block";
                $afficherliste          = "none";
                $titreCarteEvent        = "Modification d'un événement";
                $boutonRetourEvent      = "none";
                $formCreation           = "none";
                $formModif              = "block";
                $idEvent                = $_GET["id"];
                
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

                $sql = "SELECT * FROM evenements WHERE id = $idEvent";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {

                        $valueNomEvent = $row["nom"];
                        $valueDateEvent = $row["date"];
                        $valueLieuEvent = $row["lieu"];
                        $valueProgramme = $row["programme"];
                        $idEvent = $row["id"];
                    }
                }
            }
        }
        else{
            $pageEvent = "block";
            $afficherliste = "none";
            $formCreation = "block";
            $boutonRetourEvent = "none";
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
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Événement créé avec succès";
                sleep(2);
                retourPage("events", $tempsAttente);
            }
            else if($state == 1){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Erreur lors de la création de l'événement";
                sleep(2);
                retourPage("events", $tempsAttente);
            }
            else if($state == 2){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Merci de remplir tous les champs";
                sleep(2);
                retourPage("events", $tempsAttente);
            }
            else if($state == 10){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Événement modifié avec succès";
                sleep(2);
                retourPage("events", $tempsAttente);
            }
            else if($state == 11){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Erreur lors de la modification de l'événement";
                // sleep(2);
                retourPage("events", $tempsAttente);
                echo $sql;
            }
            else if($state == 12){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Merci de remplir tous les champs";
                sleep(2);
                retourPage("events", $tempsAttente);
            }
            else if($state == 45){
                $formCreation           = "none";
                $formModif              = "none";
                $contextBodyCreaEvent   = "flex";
                $messageContexte        = "Problème post";
                sleep(2);
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
                        window.location.href = "admin.php?page=' . $page . '"
                    }, ' . $sTemps . '
                );
            </script>
        ';

}



?>