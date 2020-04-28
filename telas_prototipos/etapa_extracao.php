<?php


require_once '../classes/Pagina/Pagina.php';
/*use InfUfrgs\Pagina\Pagina;
use InfUfrgs\Excecao\Excecao;
session_start();

date_default_timezone_set('America/Sao_Paulo');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$dateLogin = date('d/m/Y  H:i:s');
$_SESSION['DATA_LOGIN']  = $dateLogin;

 //echo $actual_link;*/
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



    #principal-capela{
        margin-top: 10px;
        width: 100%;
        height: 130px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    #select-capela{
        margin: 20px;
        height: 30px;
        width: 250px;
        border-radius: 4px;
    }

    #btn-capela{
        width: 30%;
        height: 25%; 
    }

    #btn-capela:hover{
        width: 30%;
        height: 25%; 
    }

    #principal-grupos{
        margin-top: 10px;
        width: 100%;
        height: 250px;
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

    

    #kit-lote{
        margin-top: 10px;
        width: 100%;
        height: 200px;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }
    
    #btn-kit-lote{
        width: 30%;
        height: 32px; 
        display: block;
        margin: 30px;
    }

    #cancel-confirm{
        margin-top: 10px;
        width: 100%;
        height: auto;
        display: flex;
    }

    #secundario-amostras{
        width: 100%;
        height: auto;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
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
            <h1 id="title">ETAPA DE EXTRAÇÃO<h1>
            <div id="principal-capela">
                <h1 id="title1">ALOCAR UMA CAPELA<h1>
                <select id="select-capela" class="form-control" name="sel-capela">
                    <option value="">Selecione uma capela</option>
                    <option value="Capela 1">Capela 1</option>
                    <option value="Capela 2">Capela 2</option>
                    <option value="Capela 3">Capela 3</option>
                </select>
                <button onclick="showDiv('principal-grupos')" type="submit" name="alocar-capela" class="btn" id="btn-capela">ALOCAR</button><br><br>
            </div>
            <div id="principal-grupos">    
                <h1 id="title1">SELECIONAR UM GRUPO DE EXTRAÇÃO<h1>
                <div id="select-lista">
                    <div id="select-busca">
                        <select id="select-grupo" class="form-control" name="sel-grupo">
                            <option value="">Selecione um grupo</option>
                            <option value="Grupo 1">Grupo 1</option>
                            <option value="Grupo 2">Grupo 2</option>
                            <option value="Grupo 3">Grupo 3</option>
                        </select>
                        <br>
                        <div id="busca-amostra">
                            <input type="checkbox" id="select-busca-amostra" name="select-busca">
                            <input type="text" id="buscar-amostra" name="obs" placeholder="Buscar por ID de amostra">
                            <button type="submit" name="buscar-amostra" class="btn" id="btn-buscar">BUSCAR</button>
                        </div>
                        <button onclick="showDiv('kit-lote')" type="submit" name="confirmar-grupo" class="btn" id="btn-grupo">CONFIRMAR GRUPO DE EXTRAÇÃO</button>
                    </div>
                
                    <div id="tabela-amostras">
                        <table border="1" id="table-amostras">
                            <thead>
                                <tr class="listagem-titulo">
                                    <th scope="col">AMOSTRA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 1</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 2</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 3</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 4</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 5</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 6</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 7</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 8</th> 
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 9</th> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
            </div>


            <div id="kit-lote">
                <h1 id="title1">SELECIONAR UM KIT E UM LOTE PARA EXTRAÇÃO<h1>
                <select id="select-kit" class="form-control" name="sel-kit">
                    <option value="">Selecione um kit</option>
                    <option value="Kit 1">Kit 1</option>
                    <option value="Kit 2">Kit 2</option>
                    <option value="Kit 3">Kit 3</option>
                </select>
                <select id="select-lote" class="form-control" name="sel-lote">
                    <option value="">Selecione um lote</option>
                    <option value="Lote 1">Lote 1</option>
                    <option value="Lote 2">Lote 2</option>
                    <option value="Lote 3">Lote 3</option>
                </select>
                <div id="cancel-confirm">
                    <button type="submit" name="cancelar-kit-lote" class="btn2">CANCELAR INÍCIO DA EXTRAÇÃO</button>
                    <button onclick="showDiv('secundario-amostras')" type="submit" name="confirmar-kit-lote" class="btn2">CONFIRMAR INÍCIO DA EXTRAÇÃO</button>
                </div>
            </div>

            <div id="secundario-amostras">
                <h1 id="title1">AMOSTRAS RELACIONADAS AO GRUPO DE EXTRAÇÃO<h1>
                <div class="conteudo_listar">
                    <div class="conteudo_tabela">
                        <table class="table2">
                            <thead>
                                <tr class="listagem-titulo">
                                    <th scope="col">AMOSTRA</th>
                                    <th scope="col">VOLUME (μl)</th>
                                    <th scope="col">PROBLEMA</th>
                                    <th scope="col">OBSERVAÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 1</th>
                                    <th scope="col"><input type="number" id="amostra1Vol" name="vol" class="txtbox" placeholder="Volume (μl)"></th>
                                    <th scope="col"><input type="checkbox" id="amostra1Prob" name="problema"></th>
                                    <th scope="col"><input type="text" id="amostra1Obs" name="obs" placeholder="Observações"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 2</th>
                                    <th scope="col"><input type="number" id="amostra2Vol" name="vol" class="txtbox" placeholder="Volume (μl)"></th>
                                    <th scope="col"><input type="checkbox" id="amostra2Prob" name="problema"></th>
                                    <th scope="col"><input type="text" id="amostra2Obs" name="obs" placeholder="Observações"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 3</th>
                                    <th scope="col"><input type="number" id="amostra3Vol" name="vol" class="txtbox" placeholder="Volume (μl)"></th>
                                    <th scope="col"><input type="checkbox" id="amostra3Prob" name="problema"></th>
                                    <th scope="col"><input type="text" id="amostra3Obs" name="obs" placeholder="Observações"></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="cancel-confirm">
                    <button type="submit" name="cancelar-kit-lote" class="btn2">CANCELAR</button>
                    <button onclick="showDiv('secundario-amostras')" type="submit" name="confirmar-kit-lote" class="btn2">CONFIRMAR</button>
                </div>
            </div>
        </div>
        </div>
        </main>

        <script>

            function showDiv(div){
                document.getElementById(div).style.display = "";
            }

            function eventListenerForSearch(object, searchObj, selectObj){
                const checkbox = document.querySelector('#'+object);
                const search = document.querySelector('#'+searchObj);
                const select = document.querySelector('#'+selectObj);

                search.disabled = true;

                checkbox.addEventListener("change", (el) => {
                    if(checkbox.checked){
                        search.disabled = false;
                        select.disabled = true;
                    }else{
                        search.disabled = true;
                        select.disabled = false;
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


            document.getElementById('principal-grupos').style.display = 'none';
            //document.getElementById('tabela-amostras').style.display = 'none';
            document.getElementById('kit-lote').style.display = 'none';
            document.getElementById('secundario-amostras').style.display = 'none';
            eventListenerForSearch('select-busca-amostra', 'buscar-amostra', 'select-grupo');

            createEventListener("amostra1");
            createEventListener("amostra2");
            createEventListener("amostra3");

            createEventListener("amostra1");
            createEventListener("amostra2");
            createEventListener("amostra3");


        </script>
    </body>