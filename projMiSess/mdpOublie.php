<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["courrielReset"])){

            if($_POST["courrielReset"] == ""){
                header("Location: admin.php?action=mdpOublie&erreurMDP=2");
            }
            else{
                $courrielReset = $_POST["courrielReset"];

                include("connBD.php");

                $sql = "SELECT * FROM users WHERE email = '$courrielReset'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $to = $courrielReset;
                    $subject = "Mot de passe oublié";
                    $message = "Voici le lien pour réinitialiser votre mot de passe : https://cours.cegep3r.info/A2023/420326RI/GR01/m_grondin/admin.php?action=mdpOublie";
                    $headers = "From: Les Événements du Cégep de Trois-Rivières";
                    // mail($to,$subject,$message,$headers);
                    // echo $message;
                    header("Location: admin.php");
                }
                else{
                    header("Location: admin.php?action=mdpOublie&erreurMDP=1");
                }
            }
            
        }
        else if(isset($_POST["nouvMDP"]) && isset($_POST["confirmMDP"])){
            if($_POST["nouvMDP"] != "" && $_POST["confirmMDP"] != ""){
                if($_POST["nouvMDP"] == $_POST["confirmMDP"]){

                    $nouvMDP = $_POST["nouvMDP"];
                    $nouvMDP = sha1($nouvMDP);

                    $id = $_POST["idCompte"];

                    include("connBD.php");

                    $sql = "SELECT * FROM users WHERE id = $id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $sql = "UPDATE users SET MDP = '$nouvMDP' WHERE id = '$id'";
                        $result = $conn->query($sql);
                        header("Location: admin.php?action=mdpOublie&erreurMDP=0");
                    }
                    else{
                        header("Location: admin.php?action=mdpOublie&erreurMDP=4");
                    }
                }
                else{
                    header("Location: admin.php?action=mdpOublie&erreurMDP=5");
                }
            }
            else{
                header("Location: admin.php?action=mdpOublie&erreurMDP=6");
            }
        }
        else{
            header("Location: admin.php?action=mdpOublie&erreurMDP=7");
        }
        
    }
    else{
        if(isset($_GET["mdp"]) && $_GET["mdp"] != ""){
            header("admin.php?action=mdpOublie&mdp=".$_GET["mdp"]);
        }
    }





?>