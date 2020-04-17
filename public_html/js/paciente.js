/*
 *  Author: Carine Bertagnolli Bathaglini
 */

function validaNome(){
     
    var strTipo = document.getElementById("idNome");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_nome");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 130 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 )div_feedback.innerHTML = " Digite um nome. ";
        if(strTipo.value.length > 130 )div_feedback.innerHTML = " Digite um nome com menos 130 caracteres. ";
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


function validaCPF(){
        
    var strTipo = document.getElementById("idCPF");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_cpf");
    var x = document.getElementById("id_desaparecer_aparecerCPF");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 11 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe um motivo. ";
            //var div_display = document.getElementById("id_desaparecer_aparecer");
            
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
             
            //else
            //  document.getElementById('id_desaparecer_aparecer').style.display = 'none';
            
        }
        if(strTipo.value.length > 11 ) div_feedback.innerHTML = " Digite o CPF com 11 caracteres. ";
    }
    else if(strTipo.value.length > 0){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}




function validaCODGAL(){
    
    var strTipo = document.getElementById("idCodGAL");
    var div_feedback = document.getElementById("feedback_codGal");
      
    if( strTipo.value.length > 15 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
      
       div_feedback.innerHTML = " Digite o código GAL com 15 caracteres. ";
    }
    
    if(strTipo.value.length >= 0 && strTipo.value.length  <= 15 ){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

/*
function validaCPF(){
    
    var strTipo = document.getElementById("idCPF");
    var div_feedback = document.getElementById("feedback_cpf");
    var x = document.getElementById("id_desaparecer_aparecerObsCPF");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 11 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe o CPF. ";
        }
        if(strTipo.value.length > 11 ) div_feedback.innerHTML = " Digite o CPF com 11 caracteres. ";
    }
    else if(strTipo.value.length > 0){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}
*/
function validaCPFSUS(){
    
    var strTipo = document.getElementById("idCPF");
    var div_feedback = document.getElementById("feedback_cpf");
    var x = document.getElementById("id_desaparecer_aparecerObsCPF");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 11 ){ // não digitou nada
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
        if(strTipo.value.length > 11 ) div_feedback.innerHTML = " Digite o CPF com 11 caracteres. ";
    }
    else if(strTipo.value.length > 0){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaRG(){
        
    var strTipo = document.getElementById("idRG");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_rg");
    var x = document.getElementById("id_desaparecer_aparecerRG");
    
    if(strTipo.value.length == 0 || strTipo.value.length != 10 ){ // não digitou nada
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
        if(strTipo.value.length > 10 ) div_feedback.innerHTML = " Digite o RG com 10 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 10 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}
//DEIXEI PRONTA
function validaCEP(){
        
    var strTipo = document.getElementById("idCEP");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_cep");
    var x = document.getElementById("id_desaparecer_aparecerCEP");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 8 ){ // não digitou nada
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
        if(strTipo.value.length > 8 ) div_feedback.innerHTML = " Digite o CEP com 8 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 10 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaEndereco(){
        
    var strTipo = document.getElementById("idEndereco");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_endereco");
    var x = document.getElementById("id_desaparecer_aparecerEndereco");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 150 ){ // não digitou nada
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
        if(strTipo.value.length > 150 ) div_feedback.innerHTML = " Digite um endereço com até 150 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 10 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaPassaporte(){
        
    var strTipo = document.getElementById("idPassaporte");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_passaporte");
    var x = document.getElementById("id_desaparecer_aparecerPassaporte");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 15 ){ // não digitou nada
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
        if(strTipo.value.length > 15 ) div_feedback.innerHTML = " Digite o passaporte com até 15 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 10 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function validaCodGAL(){
        
    var strTipo = document.getElementById("idCodGAL");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_codGal");
    var x = document.getElementById("id_desaparecer_aparecerCodGAL");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 15 ){ // não digitou nada
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
        if(strTipo.value.length > 15 ) div_feedback.innerHTML = " Digite o código GAL com até 15 caracteres. ";
    }
    else if(strTipo.value.length > 0 && strTipo.value.length == 10 ){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}


function validaNomeMae(){
        
    var strTipo = document.getElementById("idNomeMae");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_nomeMae");
    var x = document.getElementById("id_desaparecer_aparecerObsNomeMae");
    
    if(strTipo.value.length == 0 || strTipo.value.length > 130 ){ // não digitou nada
        strTipo.classList.add("is-invalid");
        if(strTipo.classList.contains("is-valid")) strTipo.classList.remove("is-valid");
        if(div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");
        if(strTipo.value.length == 0 ){
            div_feedback.innerHTML = " Informe um motivo. ";
            //var div_display = document.getElementById("id_desaparecer_aparecer");
            
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
             
            //else
            //  document.getElementById('id_desaparecer_aparecer').style.display = 'none';
            
        }
        if(strTipo.value.length > 130 ) div_feedback.innerHTML = " Digite o nome da mãe com menos 130 caracteres. ";
    }
    else if(strTipo.value.length > 0){
        x.style.display = "none";
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}

function validaDataNascimento(){
     
    var strTipo = document.getElementById("idDtNascimento");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_dtNascimento");
    
    
     if(strTipo.value.length >= 0){
         strTipo.classList.add("is-valid");
        if(strTipo.classList.contains("is-invalid")) strTipo.classList.remove("is-invalid");
        if(div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }
    
}







function val() {
                                       $('.selectpicker').change(function (e) {
                                           //alert(e.target.value);
                                           //document.getElementById("class1").innerHTML = e.target.value ;
                                           window.location.href = "controlador.php?action=cadastrar_paciente&valuePerfilSelected=" + e.target.value;
                                           /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
                                            alert("data sent and received: "+data);
                                            });*/

                                       });
                                   }

                                   function val_sexo() {
                                       $('.selectpicker').change(function (e) {
                                           alert(e.target.value);
                                           //document.getElementById("class1").innerHTML = e.target.value ;

                                           /*$.post("cadastro_paciente.php", {perfilSelecionado:e.target.value},function(data){
                                            alert("data sent and received: "+data);
                                            });*/

                                       });
                                   }
                                   function val_radio_obsNomeMae() {

                                       var radios = document.getElementsByName('obs');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("desconhecido");
                                               document.getElementById('idObsNomeMae').readOnly = true;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("outro");
                                               document.getElementById('idObsNomeMae').readOnly = false;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                       }

                                   }

                                   function val_radio_obsCPF() {

                                       var radios = document.getElementsByName('obsCPF');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("desconhecido");
                                               document.getElementById('idObsCPF').readOnly = true;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("outro");
                                               document.getElementById('idObsCPF').readOnly = false;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                       }

                                   }

                                   function val_radio_obsRG() {

                                       var radios = document.getElementsByName('obsRG');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("desconhecido");
                                               document.getElementById('idObsRG').readOnly = true;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("outro");
                                               document.getElementById('idObsRG').readOnly = false;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                       }

                                   }


                                   function val_radio_obsEndereco() {

                                       var radios = document.getElementsByName('obsEndereco');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               document.getElementById('idObsEndereco').readOnly = true;
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               document.getElementById('idObsEndereco').readOnly = false;
                                               break;
                                           }
                                       }

                                   }
                                   
                                   
                                   function val_radio_obsPassaporte() {

                                       var radios = document.getElementsByName('obsPassaporte');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               document.getElementById('idObsPassaporte').readOnly = true;
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               document.getElementById('idObsPassaporte').readOnly = false;
                                               break;
                                           }
                                       }

                                   }
                                   
                                   function val_radio_obsCodGAL() {

                                       var radios = document.getElementsByName('obsCodGAL');
                                       //var input_outro = document.getElementById('idObsNomeMae');
                                       for (var i = 0, length = radios.length; i < length; i++) {
                                           if (radios[0].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("desconhecido");
                                               document.getElementById('idObsCodGAL').readOnly = true;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                           if (radios[1].checked) {
                                               // do whatever you want with the checked radio
                                               //alert("outro");
                                               document.getElementById('idObsCodGAL').readOnly = false;
                                               // only one radio can be logically checked, don't check the rest
                                               break;
                                           }
                                       }

                                   }