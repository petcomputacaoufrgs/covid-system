/*
 *  Author: Carine Bertagnolli Bathaglini
 */

function validaPerfilUsuario(){
     
    var strTipo = document.getElementById("idPerfilUsuario");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    
    var div_feedback = document.getElementById("feedback_perfilUsuario");
    //console.log(strTipo.value); 
       
    if(strTipo.value.length == 0 || strTipo.value.length > 100 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 )div_feedback.innerHTML = " Digite um perfil de paciente. ";
        if(strTipo.value.length > 100 )div_feedback.innerHTML = " Digite um perfil de usuário com menos 100 caracteres. ";
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
