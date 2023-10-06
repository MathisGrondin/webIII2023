<?php

$valueProgramme = "Techniques de l'informatique | Technologie du génie industriel | Techniques policières";

$valueProgrammeModif = explode(" | ", $valueProgramme);

    $nbProgs = count($valueProgrammeModif);

    switch ($nbProgs) {
        case 1:
            $rowPModif1 = true;
            echo $valueProgrammeModif[0];
            break;
        case 2:
            $rowPModif1 = true;
            $rowPModif2 = true;
            echo $valueProgrammeModif[0];
            echo $valueProgrammeModif[1];
            break;
        case 3:
            $rowPModif1 = true;
            $rowPModif2 = true;
            $rowPModif3 = true;
            echo $valueProgrammeModif[0];
            echo "<br>";
            echo $valueProgrammeModif[1];
            echo "<br>";
            echo $valueProgrammeModif[2];
            echo "<br>";
            break;
        default:
            $rowPModif1 = true;
            $valueProgrammeModif = $valueProgrammeModif[0];
            break;
    }



?>