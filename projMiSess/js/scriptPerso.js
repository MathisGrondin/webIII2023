var selectProg1 = document.getElementById("selectProg1");
var selectProg2 = document.getElementById("selectProg2");
var selectProg3 = document.getElementById("selectProg3");


selectProg1.addEventListener('change', function(event) {
    if(selectProg1.value == "ajout"){
        document.getElementById("inputNouvProg").style.display = "flex";
        document.getElementById("progAjout").setAttribute("required", "required");
    }
    else{
        document.getElementById("inputNouvProg").style.display = "none";
        document.getElementById("progAjout").removeAttribute("required");
    }
});

selectProg2.addEventListener('change', function(event) {
    if(selectProg2.value == "ajout"){
        document.getElementById("inputNouvProg2").style.display = "flex";
        document.getElementById("progAjout2").setAttribute("required", "required");
    }
    else{
        document.getElementById("inputNouvProg2").style.display = "none";
        document.getElementById("progAjout2").removeAttribute("required");
    }
});

selectProg3.addEventListener('change', function(event) {
    if(selectProg3.value == "ajout"){
        document.getElementById("inputNouvProg3").style.display = "flex";
        document.getElementById("progAjout3").setAttribute("required", "required");
    }
    else{
        document.getElementById("inputNouvProg3").style.display = "none";
        document.getElementById("progAjout3").removeAttribute("required");
    }
});