<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleIndex.css">
    <title>Statistiques</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row bg-gradient bg-secondary bg-opacity-75 py-3">
            <div class="col-xl-2 col-10 d-flex align-items-center">
                <a href="admin.php" class="btn btn-secondary">Retour</a>                
            </div>

            <div class="col-xl-10 col-10 d-flex align-items-center justify-content-center">
                <h2 class="text-center text-white text-opacity-75">Statistiques</h2>
            </div>
        </div>

<!-- mode tableau ici pour les infos -->

        <table>
            <tr>
                <th class="text-center text-primary">Événement</th>
                <th class="text-center text-success">Aime</th>
                <th class="text-center text-warning">Neutre</th>
                <th class="text-center text-danger">Déteste</th>
            </tr>
            <tr>
                <td class="text-center fw-bold text-primary">Événement 1</td>
                <td class="text-center text-success">10</td>
                <td class="text-center text-warning">5</td>
                <td class="text-center text-danger">2</td>
            </tr>
            <tr >
                <td class="text-center fw-bold text-primary">Événement 2</td>
                <td class="text-center text-success">5</td>
                <td class="text-center text-warning">5</td>
                <td class="text-center text-danger">5</td>
            </tr>
            <tr>
                <td class="text-center fw-bold text-primary">Événement 3</td>
                <td class="text-center text-success">2</td>
                <td class="text-center text-warning">5</td>
                <td class="text-center text-danger">10</td>
            </tr>
        </table>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>