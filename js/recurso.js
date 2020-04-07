/*
 *  Author: Carine Bertagnolli Bathaglini
 */

function validaNome(){
     
    var strTipo = document.getElementById("idNomeRecurso");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_nome");
    //console.log(strTipo.value); 
       
    if(strTipo.value.length == 0 || strTipo.value.length > 100 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 )div_feedback.innerHTML = " Digite um nome. ";
        if(strTipo.value.length > 100 )div_feedback.innerHTML = " Digite um nome com menos 100 caracteres. ";
    }
    else if(strTipo.value.length > 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaSNmenu(){
     
    var strTipo = document.getElementById("idSNRecurso");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_s_n_menu");
    //console.log(strTipo.value); 
       
    if(strTipo.value.length == 0 || strTipo.value.length > 1 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 )div_feedback.innerHTML = " Digite um caractere s/n. ";
        if(strTipo.value.length > 1 )div_feedback.innerHTML = " Digite apenas 1 caractere. ";
    }else if(strTipo.value >=0 &&  strTipo.value <= '9'){
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        div_feedback.innerHTML = " Digite um caractere s/n. ";
    }
    else if(strTipo.value.length > 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}
