<?php
    session_start();


    // Si la méthode est POST et que les variables sont définies
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["quelEvent"]) && isset($_POST["quiRepond"])){
            if(!isset($_SESSION["event"]) || !isset($_SESSION["type"])){
                $_SESSION["event"] = $_POST["quelEvent"];
                $_SESSION["type"] = $_POST["quiRepond"];
            }
        else{
            $_SESSION["event"] = $_POST["quelEvent"];
            $_SESSION["type"] = $_POST["quiRepond"];
        }
        header("Location: index.php");
        }
    }
    else{

        if(isset($_GET["addN"]) && $_GET["addN"] != "" && isset($_SESSION["event"]) && $_SESSION["event"] != "" && isset($_SESSION["type"]) && $_SESSION["type"] != "")
        {
            $addN = $_GET["addN"];
            $event = $_SESSION["event"];
            $type = $_SESSION["type"];
            $event = test_input($event);

            // Connexion à la BD
            include("connBD.php");
                

            if($type == "etudiant") {
                try {
                    switch($addN){
                            case 1 : 
                                {
                                    // Récupération du nombre d'aimé de l'événement
                                        /* Requête SQL                          */ $sql         = "SELECT nbAimeEtu FROM evenements WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);
                                        /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                        /* Variable du résultat (nombreLike)    */ $nbAimeEtu   = $row["nbAimeEtu"];
                                        

                                    // Ajout d'un like
                                        /* Nouveau nombre de likes              */ $nbAimeEtu++;
                                        /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbAimeEtu = $nbAimeEtu WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);     
                                        
                                    // Retour à la page d'accueil
                                        header("Location: index.php?ajout=ok");
                                        break;
                                }
                            
                            case 2 : 
                                {
                                    // Récupération du nombre d'aimé de l'événement
                                        /* Requête SQL                          */ $sql         = "SELECT nbNeutreEtu FROM evenements WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);
                                        /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                        /* Variable du résultat (nombreLike)    */ $nbAimeEtu   = $row["nbNeutreEtu"];
                                    

                                    // Ajout d'un like
                                        /* Nouveau nombre de likes              */ $nbNeutreEtu++;
                                        /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbNeutreEtu = $nbNeutreEtu WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);        
                                    
                                    // Retour à la page d'accueil
                                        header("Location: index.php?ajout=ok");
                                        break;
                                }
                            case 3 : 
                                {
                                    // Récupération du nombre d'aimé de l'événement
                                        /* Requête SQL                          */ $sql         = "SELECT nbDetesteEtu FROM evenements WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);
                                        /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                        /* Variable du résultat (nombreLike)    */ $nbDetesteEtu   = $row["nbDetesteEtu"];
                                    

                                    // Ajout d'un like
                                        /* Nouveau nombre de likes              */ $nbDetesteEtu++;
                                        /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbDetesteEtu = $nbDetesteEtu WHERE nom = '$event'";
                                        /* Envoi requête                        */ $result      = $conn->query($sql);        
                                    
                                    // Retour à la page d'accueil
                                        header("Location: index.php?ajout=ok");
                                        break;
                                }
                    }
                }
                catch(Exception $e) {
                    header("Location: index.php?ajout=erreur");
                }
            }
            else if($type == "employeur") {
                try {
                    switch($addN)
                    {
                        case 1 : 
                            //? Récupération du nombre d'aimé de l'événement
                                /* Requête SQL                          */ $sql         = "SELECT nbAimeEmp FROM evenements WHERE nom = '$event'";
                                /* Envoi requête                        */ $result      = $conn->query($sql);
                                /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                /* Variable du résultat (nombreLike)    */ $nbAimeEmp   = $row["nbAimeEmp"];
                                
                            //? Ajout d'un like
                                /* Nouveau nombre de likes              */ $nbAimeEmp++;
                                /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbAimeEmp = $nbAimeEmp WHERE nom = '$event'";
                                /* Envoi requête                        */ $result      = $conn->query($sql);     
                                
                            //? Retour à la page d'accueil
                                header("Location: index.php?ajout=ok");
                                break;
                        
                        case 2 : 
                            //? Récupération du nombre d'aimé de l'événement
                                /* Requête SQL                          */ $sql         = "SELECT nbNeutreEmp FROM evenements WHERE nom = '$event'";
                                /* Envoi requête                        */ $result      = $conn->query($sql);
                                /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                /* Variable du résultat (nombreLike)    */ $nbNeutreEmp   = $row["nbNeutreEmp"];
                            
                            //? Ajout d'un like
                                /* Nouveau nombre de likes              */ $nbNeutreEmp++;
                                /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbNeutreEmp = $nbNeutreEmp WHERE nom = '$event'";
                                /* Envoi requête                        */ $result      = $conn->query($sql);        
                            
                            //? Retour à la page d'accueil
                                header("Location: index.php?ajout=ok");
                                break;
                            
                        case 3 : 
                            //? Récupération du nombre d'aimé de l'événement
                               /* Requête SQL                          */ $sql         = "SELECT nbDetesteEmp FROM evenements WHERE nom = '$event'";
                               /* Envoi requête                        */ $result      = $conn->query($sql);
                               /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                               /* Variable du résultat (nombreLike)    */ $nbDetesteEmp   = $row["nbDetesteEmp"];

                            //? Ajout d'un like
                               /* Nouveau nombre de likes              */ $nbDetesteEmp++;
                               /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbDetesteEmp = $nbDetesteEmp WHERE nom = '$event'";
                               /* Envoi requête                        */ $result      = $conn->query($sql);
                           
                            //? Retour à la page d'accueil
                               header("Location: index.php?ajout=ok");
                               break;
                    }
                }
                catch(Exception $e) { 
                    header("Location: index.php?ajout=erreur");
                }
            }
        }
        else{
            header("Location: index.php");
        }
    }

    function test_input($data){
        $data = trim($data);
        $data = addslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
?>
