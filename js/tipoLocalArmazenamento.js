/*
 *  Author: Carine Bertagnolli Bathaglini
 */

function validaNomeTipoLocalArmazenamento(){
     
    var strTipo = document.getElementById("idNomeTipoLA");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_nomeLocal");
    //console.log(strTipo.value); 
       
    if(strTipo.value.length == 0 || strTipo.value.length > 50 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = "";
        if(strTipo.value.length == 0 )div_feedback.innerHTML = " Digite um tipo de armazenamento. ";
        if(strTipo.value.length > 50 )div_feedback.innerHTML = " Digite um tipo de armazenamento com menos de 50 caracteres. ";
    }
    else if(strTipo.value.length > 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = "";
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function validaEspacoTotal(){
     
    var strTipo = document.getElementById("idQntTotalEspacoLA");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_qntTotal");
    //console.log(strTipo.value); 
       
    if(strTipo.value < 0 || strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = "";
        if(strTipo.value.length == 0 ) div_feedback.innerHTML = " Digite uma quantidade total de espaços. ";
        else div_feedback.innerHTML = " Digite uma quantidade total de espaços não negativa. ";
    }
    else if(strTipo.value.length > 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = "";
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function validaEspacoAmostra(){
     
    var strTipo = document.getElementById("idQntEspacoAmostra");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_qntAmostra");
    //console.log(strTipo.value); 
       
    if(strTipo.value < 0 || strTipo.value.length == 0 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = "";
        if(strTipo.value.length == 0 ) div_feedback.innerHTML = " Digite uma quantidade total de espaços. ";
        else div_feedback.innerHTML = " Digite uma quantidade total de espaços não negativa. ";
    }
    else if(strTipo.value.length > 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = "";
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}
