<?php
    session_start();

    $servername = "cours.cegep3r.info";
    $username = "2230572";
    $password = "2230572";
    $dbname = "2230572-mathis-grondin";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    // Check connection
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    if(!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1 || $_SERVER["REQUEST_METHOD"] != "POST") {
        header('Location: index.php');
    }


    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["admin"] == 1){
        if(isset($_SESSION["user"]) && $_SESSION["admin"] == true){
            if(isset($_POST["nomUser"], $_POST["prenomUser"], $_POST["courriel"], $_POST["mdp1"], $_POST["mdp2"]) && $_POST["nomUser"] != "" && $_POST["prenomUser"] != "" && $_POST["courriel"] != "" && $_POST["mdp1"] != "" && $_POST["mdp2"] != "") {
                
                // Déclaration des variables et vérification des champs
                    $nomUser    = test_input($_POST["nomUser"]      );
                    $prenomUser = test_input($_POST["prenomUser"]   );
                    $courriel   = test_input($_POST["courriel"]     );
                    $mdp1       = sha1($_POST["mdp1"]);
                    $mdp2       = sha1($_POST["mdp2"]);

                // Checke si mot de passe et la confirmation du mdp sont pareils
                    if($_POST["mdp1"] == $_POST["mdp2"]){
                        $mdpValide = true;
                    }    
                    else{
                        $mdpValide = false;
                    }               
                
                // Checke si on crée un user admin ou non
                    if(isset($_POST["checkAdmin"]) == true){
                        $adminUser = 1;                       
                    }
                    else{
                        $adminUser = 0;                        
                    }


                $sql = "INSERT INTO users VALUES (null, '$nomUser', '$prenomUser', '$adminUser', '$courriel', '$mdp1')";
                $result = $conn->query($sql);
                
                // Si l'insertion a fonctionné
                    if($result && $mdpValide == true) {
                        header("Location: admin.php?page=users&state=0");
                    }
                // Si l'insertion n'a pas fonctionné
                    else {
                        header("Location: admin.php?page=users&state=3");
                    }
            }
            // Si un champ est vide
                else if($_POST["nomUser"] == "" || $_POST["prenomUser"] == "" || $_POST["courriel"] == "" || $_POST["mdp1"] == "" || $_POST["mdp2"] == ""){
                    header("Location: admin.php?page=users&state=2");
                }
            // Si les mots de passe ne sont pas pareils
                else if($mdpValide == false){
                    header("Location: admin.php?page=users&state=3");
                }
            // Sinon
            else{
                header("Location: admin.php?page=users&state=1");
            }
        }
    }  
?>


<?php 

    // FONCTIONS 

    function test_input($data){
        $data = trim($data);
        $data = addslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


?>