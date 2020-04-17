/*
 *  Author: Carine Bertagnolli Bathaglini
 */

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