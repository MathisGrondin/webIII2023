<?php 
    if(!isset($_SESSION['style'])){
        $_SESSION['style'] = 0;
    }

    if(isset($_SESSION['style'])){
        $style = $_SESSION['style'];

        switch($style){
            case 0 : $style = 1; break;
            case 1 : $style = 0; break;
        }

        $_SESSION['style'] = $style;

        if($style == 0){
            $CardHeader = "bg-bleuCegep border-rouge-cegep";
            $CardBody = "bgLilasCegep border-bleuCegep border-top-0 border-bottom-0";
            $CardFooter = "bg-bleuCegep border-rouge-cegep";

            $Table = "fontCegep bleuCegep";

            $Bouton = "bgLilasCegep border-rouge-cegep rounded";
            $TextBouton = "fontCegep bleuCegep fw-bold";

            $BtnA = "btn bgLilasCegep border-rouge-cegep";
            $TextBtnA = "fontCegep fw-bold bleuCegep";

            $TextCardHeader = "lilasCegep fw-bold text-center fontCegep";
            $TextCardBody = "bleuCegep fw-bold fontCegep";
            $TextErreur = "rougeCegep fw-bold fontCegep";
            $Label = "fontCegep bleuCegep fw-bold fs-6";

            $borderInput = "rounded text-center border-bleuCegep";

            $BarreAdmin = "bg-bleuCegep";
            $Background = "background1";
           
        }    
        else{
            
        }
    }     









?>