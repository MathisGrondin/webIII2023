<!DOCTYPE html>
<html lang="fr-ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleIndex.css">
    <link rel="stylesheet" href="css/cegepCSS.css">
    <title>Formulaire satisfaction 2023</title>
</head>
<body>
    <div class="container-fluid" id="conteneurCarte">
        <div class="row d-flex justify-content-center align-items-center" id="rowCarte">
            <div class="offset col-xl-2 col-m-2"></div>
            <div class="col-xl-8 col- col-m-8 col-12">
                <div class="card border border-1 border-secondary">
                    <div class="card-header bg bg-bleuCegep">
                        <h1 class="fontCegep lilasCegep text-center">Appréciation de l'événement</h1>
                    </div>
                    <div class="card-body">
                        <div class="row text-center my-5">
                        <div class="offset col-1"></div>
                            <div class="col-2">
                                    <a href="add.php?addN=1" class="btn btn-success w-100 border border-1 border-secondary rounded">
                                        <div class="d-flex justify-content-between flex-column w-100 h-100">
                                            <img src="icones/aime.png" alt="aime" class="imgAvis">
                                            <p class="p-0 m-0 fw-bold">Adore</p>
                                        </div>
                                    </a>                                
                            </div>
                        <div class="offset col-1"></div>
                        <div class="offset col-1"></div>
                            <div class="col-2">
                                <a href="add.php?addN=2" class="btn btn-warning w-100 h-100 border border-1 border-secondary rounded">
                                    <div class="d-flex justify-content-between flex-column w-100 h-100">
                                        <img src="icones/neutre.png" alt="neutre" class="imgAvis">
                                        <p class="p-0 m-0 fw-bold">Neutre</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset col-1"></div>
                            <div class="offset col-1"></div>
                            <div class="col-2">
                                <a href="add.php?addN=3" class="btn btn-danger w-100 h-100 border border-1 border-secondary rounded">
                                    <div class="d-flex justify-content-between flex-column w-100 h-100">
                                        <img src="icones/deteste.png" alt="deteste" class="imgAvis">
                                        <p class="p-0 m-0 fw-bold">Déteste</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset col-1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset col-xl-2 col-m-2"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>