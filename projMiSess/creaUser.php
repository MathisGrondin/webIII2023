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
                $nomUser = $_POST["nomUser"];
                $prenomUser = $_POST["prenomUser"];
                $courriel = $_POST["courriel"];
                $mdp1 = sha1($_POST["mdp1"]);
                $mdp2 = sha1($_POST["mdp2"]);
                                
                $placeQuoteNomUser = stripos($nomUser, '\'');
                $placeQuotePrenom = stripos($prenomUser, '\'');
                $placeQuoteCourriel = stripos($courriel, '\'');
                
                if($placeQuoteNomUser != null){
                    $substringNomUser = substr($nomUser, 0, $placeQuoteNomUser);
                    echo $substringNomUser . "<br>";
                }
                else{
                    echo $nomUser . "<br>";
                    $substringNomUser = $nomUser;
                }
                
                if($placeQuotePrenom != null){
                    $substringPrenom = substr($prenomUser, 0, $placeQuotePrenom);
                    echo $substringPrenom . "<br>";
                }
                else{
                    echo $prenomUser . "<br>";
                    $substringPrenom = $prenomUser;
                }
            
                if($placeQuoteCourriel != null){
                    $substringCourriel = substr($courriel, 0, $placeQuoteCourriel);
                    echo $substringCourriel . "<br>";
                }
                else{
                    echo $courriel . "<br>";
                    $substringCourriel = $courriel;
                }  
            
                if($_POST["mdp1"] == $_POST["mdp2"]){
                    $mdpValide = true;
                }    
                else{
                    $mdpValide = false;
                }               
                
                if(isset($_POST["checkAdmin"]) == true){
                    $adminUser = 1;                       
                }
                else{
                    $adminUser = 0;                        
                }

                $sql = "INSERT INTO users
                    VALUES (null, '$substringNomUser', '$substringPrenom', '$adminUser', '$substringCourriel', '$mdp1')";
                $result = $conn->query($sql);
                
                echo $sql . "<br>";
                echo $result;
                
                if($result && $mdpValide == true) {
                    header("Location: admin.php?page=users&state=0");
                }
                else {
                    header("Location: admin.php?page=users&state=3");
                }
            }
            else if($_POST["nomUser"] == "" || $_POST["prenomUser"] == "" || $_POST["courriel"] == "" || $_POST["mdp1"] == "" || $_POST["mdp2"] == ""){
                header("Location: admin.php?page=users&state=2");
            }
            else if($mdpValide == false){
                header("Location: admin.php?page=users&state=3");
            }
            else{
                header("Location: admin.php?page=users&state=1");
            }
        }
    }  
?>