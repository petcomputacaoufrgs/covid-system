<?php


require_once __DIR__.'/../../classes/Pagina/Pagina.php';

$objPagina = new Pagina();
?>


<?php Pagina::abrir_head("Extração"); ?>

<style>

    @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');
    *{
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
    }

    body,html{
        font-size: 14px !important;
    }

    main{
        width: 100%;
        height: auto;
    }

    header{
        background-color: white;
        height: fixed;
        width: 100%;
        height: auto;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    input{
        height: 30px;
        text-align: center;
    }

    .dropdown-toggle{
        height: 45px;
    }

    .placeholder_colored::-webkit-input-placeholder  {
        color: red;
        text-align: left;
    }

    .sucesso{
        width: 100%;
        background-color: green;
    }

    .form{
        margin: 50px;
    }

    .form-control{
        height: 30px;
        width: 250px;
        border-radius: 4px;
        margin: 20px;
    }

    .HeaderImg{
        width: 100%;
        height: auto;
    }

    .btn{
        border: none;
        border-radius: 7px;
        background-color: #445f6d;
        font-weight: regular;
        text-align: center;
        color: white;
        letter-spacing: 2px;
        display: inline-block;
        transition-duration: 0.2s;
        cursor: pointer;
    }

    .btn:hover{
        border: none;
        border-radius: 7px;
        font-weight: regular;
        text-align: center;
        color: white;
        letter-spacing: 2px;
        display: inline-block;
        background-color: #73a1b8;
    }

    .btn2{
        border: none;
        border-radius: 7px;
        width: 220px;
        height: 60px;
        background-color: #445f6d;
        font-weight: regular;
        text-align: center;
        color: white;
        letter-spacing: 2px;
        transition-duration: 0.2s;
        cursor: pointer;
        margin-left: 20%
    }

    .btn2:hover{
        border: none;
        border-radius: 7px;
        width: 220px;
        height: 60px;
        font-weight: regular;
        color: white;
        letter-spacing: 2px;
        display: inline-block;
        background-color: #73a1b8;
    }

    .table2{
        width: 100%;
        border-spacing: 0;
    }

    .table2 thead{
        background-color: #c1c1c1;
        height: 30px;
    }

    .table2 thead .listagem-titulo{
        height: 30px;
        box-shadow: 0px 0px 1px #a8a8a8;
    }

    .table2 tbody{
        overflow-y: auto;
        overflow-x: hidden;
    }

    .table2 tbody .listagem{
        height: 40px;
        background-color: white;
        box-shadow: 0px 0px 2px #a8a8a8;
    }

    .table2 tbody input{
        height: 30px;
        text-align: center;
    }

    #title{
        margin-top: 50px;
        font-family: 'Roboto', sans-serif;
        color: #445f6d;
        font-size: 24px;
        text-align: left;
        padding: 10px;
    }

    #title1{
        margin-top: 50px;
        font-family: 'Roboto', sans-serif;
        color: #445f6d;
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }



    #principal-diagnostico{
        margin-top: 10px;
        width: 100%;
        height: 100px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    #select-diagnostico{
        margin: 20px;
        height: 30px;
        width: 250px;
        border-radius: 4px;
        margin-left: 8px;
    }

    #btn-principal{
        width: 320px;
        height: 40px;
    }

    #btn-principal:hover{
        width: 320px;
        height: 40px;
    }

    #principal-amostras{
        margin-top: 10px;
        width: 100%;
        height: 370px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }


    #select-lista{
        display: flex;
        justify-content: space-around;
    }

    #select-busca-amostra{
        width: 15px;
        height: 15px;
        padding: 5px;
    }

    #btn-buscar{
        padding: 8px;

    }

    #tabela-amostras{
        width: 300px;
        overflow: scroll;
    }

    #table-amostras{
        width: 100%;
        border-spacing: 0;
        position: relative;
    }

    #table-amostras thead{
        background-color: #c1c1c1;
        height: 30px;
    }
    #table-amostras thead{
        background-color: #c1c1c1;
        height: 30px;
    }
    #table-amostras tbody .listagem{
        height: 20px;
        background-color: white;
        box-shadow: 0px 0px 2px #a8a8a8;
    }


    #btn-grupo{
        width: 50%;
        height: 32px;
        margin: 30px;
    }

    #btn-grupo:hover{
        width: 50%;
        height: 32px;
        margin: 30px;
    }



    #dados-amostra{
        margin-top: 10px;
        width: 100%;
        height: 226px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    #dados-amostra p {
        font-size: 16px;
    }

    #dados-amostra button {
        margin-left: 5px;
        margin-right: 15px;
    }

    #btn-dados-amostra{
        width: 30%;
        height: 32px;
        display: block;
        margin: 30px;
    }

    #cancel-confirm{
        margin-top: 10px;
        width: 50%;
        height: 10%;
        display: flex;
    }

    #confirmacao{
        width: 100%;
        height: 128px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    .alert {
        font-size: 16px;
    }

    #confirmacao label {
        font-size: 16px;
        margin-top: 9px;
    }

    #btn-amostra{
        width: auto;
        height: 36px;
    }

    #btn-amostra:hover{
        width: auto;
        height: 36px;
    }

    #btn-diagnostico{
        width: auto;
        height: 36px;
        margin-left: auto;
    }

    #btn-diagnostico:hover{
        margin-left: 6px;
        width: auto;
        height: 36px;
    }

    #dados-amostra select {
        margin-top: -2px;
        margin-left: 0px;
    }

    .form-check {
        margin-left: 8px;
    }

    #btn-confirm{
        margin-left: 6px;
        width: auto;
        height: 36px;
    }

    #btn-confirm:hover{
        margin-left: 6px;
        width: auto;
        height: 36px;
    }

    #sucesso-diagnostico {
        margin-top: 20px;
    }

</style>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>Extração</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<header>
    <nav>
        <a><img src="../public_html/docs/img/header.png" class='HeaderImg'></a>
    </nav>
</header>
<main>
    <div class="form">
        <h1 id="title">ETAPA DE DIAGNÓSTICO E LAUDO<h1>
            <div id="principal-diagnostico">
                <h1 id="title1">SELECIONAR PERFIS<h1>
                    <select id="select-perfil" class="selectpicker" name="sel-diagnostico" data-live-search="true" multiple title="Selecione os perfis">
                        <option value="diagnostico 1">Perfil 1</option>
                        <option value="diagnostico 2">Perfil 2</option>
                        <option value="diagnostico 3">Perfil 3</option>
                    </select>
                    <button onclick="showDiv('principal-amostras')" type="submit" name="selecionar-diagnostico" class="btn" id="btn-principal">SELECIONAR</button><br><br>
            </div>
            <div id="principal-amostras">
                <h1 id="title1">SELECIONAR AMOSTRA<h1>
                    <div class="alert alert-info" role="alert">
                        <strong>INFORMAÇÃO!</strong>
                        Total de amostras encontradas: <strong>3</strong>.
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <strong>ATENÇÃO!</strong>
                        Nenhuma amostra foi encontrada.
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">PERFIL</th>
                            <th scope="col">?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><button onclick="showDiv('dados-amostra')" type="submit" name="selecionar-diagnostico" class="btn" id="btn-amostra">#1</button></th>
                            <td>Perfil 1</td>
                            <td>?</td>
                        </tr>
                        <tr>
                            <th scope="row"><button onclick="showDiv('dados-amostra')" type="submit" name="selecionar-diagnostico" class="btn" id="btn-amostra">#2</button></th>
                            <td>Perfil 1</td>
                            <td>?</td>
                        </tr>
                        <tr>
                            <th scope="row"><button onclick="showDiv('dados-amostra')" type="submit" name="selecionar-diagnostico" class="btn" id="btn-amostra">#3</button></th>
                            <td>Perfil 2</td>
                            <td>?</td>
                        </tr>
                        </tbody>
                    </table>
            </div>

            <div id="dados-amostra">
                <h1 id="title1">REALIZAR DIAGNÓSTICO<h1>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Status</th>
                            <th scope="col">Resultado RTqPCR</th>
                            <th scope="col">Retestes</th>
                            <th scope="col">Volume Armazenado</th>
                            <th scope="col">Observações (Opcional)</th>
                            <th scope="col">Diagnóstico (Obrigatório)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            <td><textarea rows="3"></textarea></td>
                            <td><select id="select-diagnostico" class="form-control" name="sel-diagnostico">
                                <option value="" selected="selected">Selecione um diagnóstico</option>
                                <option value="Positivo">Positivo</option>
                                <option value="Negativo">Negativo</option>
                                <option value="Reteste">Reteste</option>
                                <option value="Inconclusivo">Inconclusivo</option>
                            </select></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-danger" role="danger" id="erro-diagnostico" style="display: none">
                        <strong>ERRO!</strong> Nenhum diagnóstico foi selecionado.
                    </div>
                    <div id="cancel-confirm">
                        <button type="submit" name="cancelar-diagnostico" class="btn btn-danger" id="btn-diagnostico">CANCELAR DIAGNÓSTICO</button>
                        <button type="submit" onclick="confirmaDiagnostico()" name="salvar-diagnostico" class="btn" id="btn-diagnostico">SALVAR DIAGNÓSTICO</button>
                    </div>
                    <div class="alert alert-success" role="success" id="sucesso-diagnostico" style="display: none">
                        <strong>SUCESSO!</strong> Diagnóstico salvo!
                    </div>
            </div>

            <div id="confirmacao">
                <h1 id="title1">ENVIO DE LAUDO<h1>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="check-confirmacao">
                        <label class="form-check-label" for="check-confirmacao">
                            O laudo foi enviado corretamente para x?
                        </label>
                    </div>
                    <div id="cancel-confirm">
                        <button type="submit" name="salvar-diagnostico" class="btn" id="btn-confirm">CONFIRMAR</button>
                    </div>
            </div>
    </div>
    </div>
</main>

<script>

    function showDiv(div){
        document.getElementById(div).style.display = "";
    }

    function eventListenerForSearch(object, searchObj, selectObj, btnSearch){
        const checkbox = document.querySelector('#'+object);
        const search = document.querySelector('#'+searchObj);
        const select = document.querySelector('#'+selectObj);
        const btn = document.querySelector('#'+btnSearch);

        search.disabled = true;
        btn.disabled = true;

        checkbox.addEventListener("change", (el) => {
            if(checkbox.checked){
                search.disabled = false;
                select.disabled = true;
                btn.disabled = false;
            }else{
                search.disabled = true;
                select.disabled = false;
                btn.disabled = true;
            }
        });
        checkbox.dispatchEvent(new Event("change"));
    }

    function createEventListener(nome){
        var volId = nome + "Vol";
        var probId = nome + "Prob";
        var obsId = nome + "Obs";

        const vol = document.querySelector("#" + volId);
        const prob = document.querySelector("#" + probId);
        const obs = document.querySelector("#" + obsId);

        vol.disabled = true;
        obs.disabled = true;

        prob.addEventListener("change", (el) => {
            if(prob.checked){
                vol.disabled = false;
                obs.disabled = false;
            }else{
                vol.disabled = true;
                obs.disabled = true;
            }
        });
        prob.dispatchEvent(new Event("change"));
    }

    function confirmaDiagnostico() {

        var sel = document.getElementById("select-diagnostico");
        var conf = document.getElementById("confirmacao");
        var suc = document.getElementById("sucesso-diagnostico");
        var erro = document.getElementById("erro-diagnostico");
        var dados = document.getElementById("dados-amostra");

        if(sel.value != "") {
            conf.style.display = "";
            suc.style.display = "";
            erro.style.display = "none";
        }else{
            erro.style.display = "";
            conf.style.display = "none";
            suc.style.display = "none";
        }
        dados.style.height="280";
    }

    document.getElementById('principal-amostras').style.display = 'none';
    document.getElementById('dados-amostra').style.display = 'none';
    document.getElementById('confirmacao').style.display = 'none';
    eventListenerForSearch('select-busca-amostra', 'buscar-amostra', 'select-grupo', 'btn-buscar');

    createEventListener("amostra1");
    createEventListener("amostra2");
    createEventListener("amostra3");

    createEventListener("amostra1");
    createEventListener("amostra2");
    createEventListener("amostra3");


</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

</body>