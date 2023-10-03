<?php
    session_start();

    $servername = "cours.cegep3r.info";
    $username = "2230572";
    $password = "2230572";
    $dbname = "2230572-mathis-grondin";
    
    $dateEvent = $lieuEvent = $nomEvent = $prog1 = $prog2 = $prog3 = $programme = "";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    // Check connection
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(!isset($_SESSION['user']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1 || $_SERVER["REQUEST_METHOD"] != "POST") {
        header('Location: index.php');
    }

    

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["admin"] == 1){
        
        if(isset($_POST["dateEvent"], $_POST["lieuEvent"], $_POST["nomEvent"]) && $_POST["dateEvent"] != "" && $_POST["lieuEvent"] != "" && $_POST["nomEvent"] != "" ) {
            $dateEvent = test_input($_POST["dateEvent"]);
            $lieuEvent = test_input($_POST["lieuEvent"]);
            $nomEvent = test_input($_POST["nomEvent"]);
            
            // Check programmes

                // PROG 1
                if(isset($_POST["programme"])){

                    if($_POST["programme"] == "ajout"){
                        $nomProg1 = test_input($_POST["programmeAjout"]);

                        // Ajout du nouveau programme dans la BD
                            $sql = "INSERT INTO programmes VALUES (null, '$nomProg1')";
                            $result = $conn->query($sql);

                        // SET nouv prog 1 dans le nouveau event
                            $prog1 = $prog1 . $nomProg1;
                    }
                    else if($_POST["programme"] != "aucun" && $_POST["programme"] != "ajout"){
                        $idProg = $_POST["programme"];

                        $sql = "SELECT * FROM programmes WHERE id='$idProg'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $prog1 = test_input($row["nom"]);
                    }
                    else{
                        $prog1 = "aucun";
                    }
                }
                else{
                    $prog1 = "aucun";
                }
            
                // PROG 2
                if(isset($_POST["programme2"])){

                    if($_POST["programme2"] == "ajout"){
                        $nomProg2 = test_input($_POST["programmeAjout2"]);

                        // Ajout du nouveau programme dans la BD
                            $sql = "INSERT INTO programmes VALUES (null, '$nomProg2')";
                            $result = $conn->query($sql);

                        // SET nouv prog 1 dans le nouveau event
                            $prog2 = $prog2 . $nomProg2;

                        // ajout du programme dans le string pour la BD
                            $prog1 = $prog1 . ", " . $nomProg2;
                    }
                    else if($_POST["programme2"] != "aucun" && $_POST["programme2"] != "ajout"){
                        $idProg2 = $_POST["programme2"];

                        $sql = "SELECT * FROM programmes WHERE id='$idProg2'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $prog2 = test_input($row["nom"]);

                        // ajout du programme dans le string pour la BD
                            $prog1 = $prog1 . ", " . $prog2;
                    }
                    else{
                        $prog2 = "aucun";
                    }
                }
                else{
                    $prog2 = "aucun";
                }

                // PROG 3
                if(isset($_POST["programme3"])){

                    if($_POST["programme3"] == "ajout"){
                        $nomProg3 = test_input($_POST["programmeAjout3"]);

                        // Ajout du nouveau programme dans la BD
                            $sql = "INSERT INTO programmes VALUES (null, '$nomProg3')";
                            $result = $conn->query($sql);

                        // SET nouv prog 1 dans le nouveau event
                            $prog3 = $prog3 . $nomProg3;

                        // ajout du programme dans le string pour la BD
                            $prog1 = $prog1 . ", " . $nomProg3;
                    }
                    else if($_POST["programme3"] != "aucun" && $_POST["programme3"] != "ajout"){
                        $idProg3 = $_POST["programme3"];

                        $sql = "SELECT * FROM programmes WHERE id='$idProg3'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $prog3 = test_input($row["nom"]);

                        // ajout du programme dans le string pour la BD
                            $prog1 = $prog1 . ", " . $prog3;
                    }
                    else{
                        $prog3 = "aucun";
                    }
                }
                else{
                    $prog3 = "aucun";
                }

            
            




            $sql = "INSERT INTO evenements
                    VALUES (null, '$nomEvent', '$lieuEvent', '$dateEvent', '$prog1', 0, 0, 0, 0, 0, 0)";
            $result = $conn->query($sql);

            echo $sql . "<br>";

            if($result) {
                header("Location: admin.php?page=events&state=0");
            }
            else {
                // echo $result;
                header("Location: admin.php?page=events&state=1");
            }
        }
        else if($_POST["dateEvent"] == "" || $_POST["lieuEvent"] == "" || $_POST["nomEvent"] == "" || $_POST["programme"] == ""){
            header("Location: admin.php?page=events&state=2");
        }
        else{
            // header("Location: admin.php?page=events&errCreation=1");
            header("Location: admin.php?page=events&state=1");
        }


    }



    function test_input($data){
        $data = trim($data);
        $data = addslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
