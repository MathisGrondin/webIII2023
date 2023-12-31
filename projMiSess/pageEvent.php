<?php
    include("connBD.php");
    $tempsAttente = 1000;

// Si va sur la page events sans être connecté
    if(!isset($_SESSION["admin"], $_SESSION["user"]))
    {
        header("Location: admin.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nomEvent   = test_input($_POST["nomEventModif"]);
        $dateEvent  = test_input($_POST["dateEventModif"]);
        $lieuEvent  = test_input($_POST["lieuEventModif"]);
        $programme  = test_input($_POST["programmeModif"]);
        $programme2  = test_input($_POST["programmeModif2"]);
        $programme3  = test_input($_POST["programmeModif3"]);
        $idEvent    = test_input($_POST["idEventModif"]);




        if(empty($nomEvent) || empty($dateEvent) || empty($lieuEvent) || empty($idEvent) || empty($programme))
        {
            if(!empty($idEvent))
            {
                $SQL    = "SELECT * FROM evenements WHERE id = $idEvent";
                $result = $conn->query($SQL);

                while($result -> fetch_assoc())
                {
                    $nomEvent   = $result["nom"];
                    $dateEvent  = $result["date"];
                    $lieuEvent  = $result["lieu"];
                    $programme  = $result["programme"];
                }

            }
        }
        else
        {            
            if($programme2 != "aucun" && $programme2 != ""){
                $programme = $programme . " | " . $programme2;
            }
            if($programme3 != "aucun" && $programme3 != ""){
                $programme = $programme .  " | " . $programme3;
            }


            
            $sql = "UPDATE evenements SET nom = '$nomEvent', lieu = '$lieuEvent', date = '$dateEvent', programme = '$programme' WHERE id = $idEvent";

            $result = $conn->query($sql);

            if ($result == TRUE) {
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
        $afficherliste      = "flex";
        $titreCarteEvent      = "Liste des événements";
        $boutonRetourEvent  = "flex";
        $formCreation       = "none";
        $cardCreaEvent      = "none";
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
                $afficherliste          = "flex";
                // $titreCarteEvent        = "Liste des événements";
                $boutonRetourEvent      = "flex";
                $cardListeEvents        = "flex";
                $cardCreaEvent          = "none";
                $cardFooterListe        = "none";
                $cardFooterCrea         = "none";
                $formCreation           = "none";               
            }
            else if($action == "Modifier") {
                $pageEvent          = "block";
                $afficherliste      = "none";
                $titreCarteEvent    = "Modification d'un événement";
                $boutonRetourEvent  = "none";
                $formCreation       = "none";
                $formModif          = "block";
                $idEvent            = $_GET["id"];
                $cardListeEvents    = "none";
                $cardCreaEvent      = "flex";
                $cardFooterListe    = "none";
                
                
                $sql    = "SELECT * FROM evenements WHERE id = $idEvent";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        $valueNomEvent  = $row["nom"];
                        $valueDateEvent = $row["date"];
                        $valueLieuEvent = $row["lieu"];
                        $valueProgrammeModif = explode(" | ", $row["programme"]);
                        $nbProgs = count($valueProgrammeModif);

                        switch ($nbProgs) {
                            case 1:
                                $valueProgrammeModif1   = $valueProgrammeModif[0];
                                break;
                            case 2:
                                $valueProgrammeModif1   = $valueProgrammeModif[0];
                                $valueProgrammeModif2   = $valueProgrammeModif[1];
                                break;
                            case 3:
                                $valueProgrammeModif1   = $valueProgrammeModif[0];
                                $valueProgrammeModif2   = $valueProgrammeModif[1];
                                $valueProgrammeModif3   = $valueProgrammeModif[2];
                                break;
                            default:
                                $valueProgrammeModif1   = $valueProgrammeModif[0];
                                break;
                        }


                        $idEvent        = $row["id"];
                    }
                }
            }
            else if($action == "Supprimer"){
                $pageEvent          = "block";
                $afficherliste      = "block";
                $titreCarteEvent    = "Liste des événements";
                $boutonRetourEvent  = "flex";
                $formCreation       = "none";
                $idEvent            = $_GET["id"];

                try{
                    $sql    = "DELETE FROM evenements WHERE id = $idEvent";
                    $result = $conn->query($sql);
                    header("Location: admin.php?page=events&state=20");
                }
                catch (Exception $e){
                    header("Location: admin.php?page=events&state=21");
                }
                

                $conn->close();
            }
        }
        else{
            $pageEvent          = "block";
            $afficherliste      = "none";
            $formCreation       = "block";
            $boutonRetourEvent  = "none";
            $titreCreation      = "Création d'un événement";
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


            switch($state){
            
                case 0 : 
                    {
                        // 0 : Création effectuée avec succès

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Événement créé avec succès";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 1 : 
                    {
                        // 1 : Erreur lors de la création de l'événement

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Erreur lors de la création de l'événement";
                        retourPage("events", $tempsAttente);
                        break;
                    }
                    
                case 2 : 
                    {
                        // 2 : Champs manquants

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Merci de remplir tous les champs";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 10 : 
                    {
                        // 10 : Modification effectuée avec succès

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Événement modifié avec succès";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 11 : 
                    {
                        // 11 : Erreur lors de la modification de l'événement

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Erreur lors de la modification de l'événement";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 12 : 
                    {
                        // 12 : Champs manquants

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Merci de remplir tous les champs";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 20 : 
                    {
                        // 20 : Suppression effectuée avec succès

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Événement supprimé avec succès";
                        retourPage("events", $tempsAttente);
                        break;
                    }

                case 21 : 
                    {
                        // 21 : Erreur lors de la suppression de l'événement

                        $formCreation           = "none";
                        $formModif              = "none";
                        $contextBodyCreaEvent   = "flex";
                        $messageContexte        = "Erreur lors de la suppression de l'événement";
                        retourPage("events", $tempsAttente);
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