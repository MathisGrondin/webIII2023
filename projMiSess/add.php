<?php
    session_start();


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

        if(isset($_GET["addN"]) && $_GET["addN"] != "" && isset($_SESSION["event"]) && $_SESSION["event"] != "" && isset($_SESSION["type"]) && $_SESSION["type"] != ""){
            $addN = $_GET["addN"];
                $event = $_SESSION["event"];
                $type = $_SESSION["type"];

                // Connexion à la base de données
                $servername = "cours.cegep3r.info";
                $username = "2230572";
                $password = "2230572";
                $dbname = "2230572-mathis-grondin";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                

                if($type == "etudiant"){
                    switch($addN){
                        case 1:
                            


                            // Récupération de l'id de l'événement
                                /* Requête SQL                  */ $sql     = "SELECT id FROM evenements WHERE nom = '$event'";
                                /* Envoi requête                */ $result  = $conn->query($sql);
                                /* Récupération des résultats   */ $row     = $result->fetch_assoc();
                                /* Variable du résultat (ID)    */ $id      = $row["id"];
    
                            // Récupération du nombre d'aimé de l'événement
                                /* Requête SQL                          */ $sql         = "SELECT nbAimeEtu FROM evenements WHERE id=$id";
                                /* Envoi requête                        */ $result      = $conn->query($sql);
                                /* Récupération des résultats           */ $row         = $result->fetch_assoc();
                                /* Variable du résultat (nombreLike)    */ $nbAimeEtu   = $row["nbAimeEtu"];
                                    

                            // Ajout d'un like
                                /* Nouveau nombre de likes              */ $nbAimeEtu++;
                                /* Requête SQL                          */ $sql         = "UPDATE evenements SET nbAimeEtu = $nbAimeEtu WHERE id = $id";
                                /* Envoi requête                        */ $result      = $conn->query($sql);                            
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :)\nSi cela vous intéresse, sachez que vous êtes le <?php echo $nbAimeEtu; ?>e étudiant à aimer cet événement!");
                                </script>

                            <?php
                            break;
                        case 2:
                            $sql = "SELECT nbNeutreEtu FROM evenement WHERE nom = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbNeutreEtu"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbNeutreEtu = $count WHERE nom = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>

                            <?php
                            break;
                        case 3:
                            $sql = "SELECT nbDetesteEtu FROM evenement WHERE nom = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbDetesteEtu"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbDetesteEtu = $count WHERE nom = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                    }
                }
                else if($type == "employeur"){
                    switch($addN){
                        case 1:
                            $sql = "SELECT nbAimeEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbAimeEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbAimeEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                        case 2:
                            $sql = "SELECT nbNeutreEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbNeutreEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbNeutreEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                        case 3:
                            $sql = "SELECT nbDetesteEmp FROM evenement WHERE id = $event";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $count = $row["nbDetesteEmp"];
                            $count++;
    
                            $sql = "UPDATE evenement SET nbDetesteEmp = $count WHERE id = $event";
                            $result = $conn->query($sql);
                            ?>

                                <script>
                                    alert("Succès! Merci d'avoir pris de temps de répondre au formulaire :) ");
                                </script>
                            
                            <?php
                            break;
                    }
                    header("Location: index.php");
                }
        }
        else{
            header("Location: index.php");
        }
    }
?>
