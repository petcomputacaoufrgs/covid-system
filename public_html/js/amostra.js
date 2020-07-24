/*
 *  Author: Carine Bertagnolli Bathaglini
 */


function validaCEPAmostra(){
        
    var strTipo = document.getElementById("idCEPAmostra");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_cepAmostra");
    var x = document.getElementById("id_desaparecer_aparecerCEPAmostra");
    
    if(strTipo.value.length == 0 || strTipo.value.length != 8 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe um motivo. ";
            if (x.style.display === "none") {
                x.style.display = "block";
            } 
        }
        if(strTipo.value.length != 8 ) div_feedback.innerHTML = " Digite o CEP com 8 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 8 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }


    
}


function validaMotivo(){
        
    var strTipo = document.getElementById("idMotivo");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_motivo");
    var x = document.getElementById("id_desaparecer_aparecerMotivo");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 100 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe um motivo. ";
            if (x.style.display === "none") {
                x.style.display = "block";
            } 
        }
        if(strTipo.value.length > 100 ) div_feedback.innerHTML = " Digite o motivo com até 100 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length <= 100 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function validaHoraColeta(){
        
    var strTipo = document.getElementById("idHoraColeta");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_horaColeta");
    var x = document.getElementById("id_desaparecer_aparecerHoraColeta");
    
    if(strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe um motivo. ";
            if (x.style.display === "none") {
                x.style.display = "block";
            } 
        }
        
    }
    else if(strTipo.value.length > 0 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}





function validaObs(){
     
    var strTipo = document.getElementById("idTxtAreaObs");
    var div_feedback = document.getElementById("feedback_obsAmostra");
       
    if( strTipo.value.length > 300 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length > 300 )div_feedback.innerHTML = " Digite uma observação com menos 300 caracteres. ";
    }
    else if(strTipo.value.length == 0 || (strTipo.value.length > 0 && strTipo.value.length < 300)){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaQntTubos(){
     
    var strTipo = document.getElementById("idQntTubos");
    var div_feedback = document.getElementById("feedback_qntTubos");
       
    if( strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = " Informe a quantidade de tubos. ";
    }
    else if(strTipo.value.length == 0 || (strTipo.value.length > 0 && strTipo.value.length < 300)){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}




function validaObsLugarOrigem(){
     
    var strTipo = document.getElementById("idObsLugarOrigem");
    var div_feedback = document.getElementById("feedback_lugarOrigem");
       
    
     if(strTipo.value.length == 0 ){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaDataColeta(){
     
    var strTipo = document.getElementById("idDtColeta");
    var div_feedback = document.getElementById("feedback_dataColeta");
       
    if( strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = " Informe a data em que a coleta foi realizada. ";
    }
    else if(strTipo.value.length == 0 || (strTipo.value.length > 0 && strTipo.value.length < 300)){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaAceitaRecusa(){
     
    var strTipo = document.getElementById("idSelAceitaRecusada");
    var div_feedback = document.getElementById("feedback_aceita_recusada");
       
    if( strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = " Informe se a amostra foi aceita ou recusada. ";
    }
    else if(strTipo.value.length == 0 || (strTipo.value.length > 0 && strTipo.value.length < 300)){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function val_radio_obsCEPamostra() {

    var radios = document.getElementsByName('obsCEPamostra');
    //var input_outro = document.getElementById('CEP_amostra');
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[0].checked) {
            // do whatever you want with the checked radio
            //alert("desconhecido");
            document.getElementById('idObsCEPAmostra').readOnly = true;
            // only one radio can be logically checked, don't check the rest
            break;
        }
        if (radios[1].checked) {
            // do whatever you want with the checked radio
            //alert("outro");
            document.getElementById('idObsCEPAmostra').readOnly = false;
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }

}



function val_radio_obsMotivo() {

    var radios = document.getElementsByName('obsMotivo');
    //var input_outro = document.getElementById('CEP_amostra');
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[0].checked) {
            // do whatever you want with the checked radio
            //alert("desconhecido");
            document.getElementById('idObsMotivo').readOnly = true;
            // only one radio can be logically checked, don't check the rest
            break;
        }
        if (radios[1].checked) {
            // do whatever you want with the checked radio
            //alert("outro");
            document.getElementById('idObsMotivo').readOnly = false;
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }

}


function val_radio_obsHoraColeta() {

    var radios = document.getElementsByName('obsHoraColeta');
    //var input_outro = document.getElementById('CEP_amostra');
    for (var i = 0, length = radios.length; i < length; i++) {
        if (radios[0].checked) {
            // do whatever you want with the checked radio
            //alert("desconhecido");
            document.getElementById('idObsHoraColeta').readOnly = true;
            // only one radio can be logically checked, don't check the rest
            break;
        }
        if (radios[1].checked) {
            // do whatever you want with the checked radio
            //alert("outro");
            document.getElementById('idObsHoraColeta').readOnly = false;
            // only one radio can be logically checked, don't check the rest
            break;
        }
    }

}