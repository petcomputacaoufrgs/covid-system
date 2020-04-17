/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function getDadosEnderecoPorCEP(cep) {
    let url = 'https://viacep.com.br/ws/' + cep + '/json/unicode/';

    let xmlHttp = new XMLHttpRequest();
    xmlHttp.open('GET', url);

    xmlHttp.onreadystatechange = () => {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            let dadosJSONText = xmlHttp.responseText;
            let dadosJSONObj = JSON.parse(dadosJSONText);
            console.log(dadosJSONObj);

            document.getElementById('idEndereco').value = dadosJSONObj.logradouro;
            //document.getElementById('bairro').value = dadosJSONObj.bairro;
            //document.getElementById('cidade').value = dadosJSONObj.localidade;
            //document.getElementById('uf').value = dadosJSONObj.uf;
        }
    }
    xmlHttp.send();

    var strTipo = document.getElementById("idCEP");
    //var tipoAmostra = '<?=$objTipoAmostra->getTipo() ?>';
    var div_feedback = document.getElementById("feedback_cep");
    var x = document.getElementById("id_desaparecer_aparecerCEP");

    if (strTipo.value.length == 0 || strTipo.value.length > 8) { // não digitou nada
        strTipo.classList.add("is-invalid");
        if (strTipo.classList.contains("is-valid"))
            strTipo.classList.remove("is-valid");
        if (div_feedback.classList.contains("valid-feedback"))
            div_feedback.classList.remove("valid-feedback");
        div_feedback.classList.add("invalid-feedback");

        if (strTipo.value.length == 0) {
            div_feedback.innerHTML = " Informe um motivo. ";
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        }
        if (strTipo.value.length > 8)
            div_feedback.innerHTML = " Digite o CEP com 8 caracteres. ";
    } else if (strTipo.value.length > 0 && strTipo.value.length == 10) {
        x.style.display = "none";
        strTipo.classList.add("is-valid");
        if (strTipo.classList.contains("is-invalid"))
            strTipo.classList.remove("is-invalid");
        if (div_feedback.classList.contains("invalid-feedback"))
            div_feedback.classList.remove("invalid-feedback");
        div_feedback.classList.add("valid-feedback");
        div_feedback.innerHTML = " Tudo certo. ";
    }



}

		