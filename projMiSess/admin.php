<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Display login form
?>

<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styleIndex.css">
    <title>Connexion admin</title>
</head>
<body>
    <?php 


    ?>
    <div class="container-fluid ">
        <div class="row mt-4">
            <div class="offset col-xl-4"></div>
                <div class="col-xl-4">
                    <div class="card border border-1 border-dark">
                        <div class="card-header bg bg-gradient bg-secondary bg-opacity-75 text-white text-opacity-75">
                            <h2 class="text-center ">Connexion admin</h2>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <label for="courriel" class="fw-bold">Courriel</label>
                                <input type="text" name="courriel" placeholder="admin@cegeptr.qc.ca" class="rounded text-center">
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <label for="mdp" class="fw-bold">Mot de passe</label>
                                <input type="text" name="mdp" class="rounded">
                            </div>
                            
                        </div>

                        <div class="card-footer d-flex justify-content-center bg bg-gradient bg-secondary bg-opacity-75">
                            <button type="submit" class="btn btn-secondary border border-1 border-light w-50 ">Connexion</button>
                    </div>
                </div>
            <div class="offset col-xl-4"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>