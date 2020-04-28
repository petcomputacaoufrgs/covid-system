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


<?php Pagina::abrir_head("Preparacao e Inativação"); ?>

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

    .HeaderImg{
        width: 100%;
        height: auto;
    }

    .btn{
        border: none;
        border-radius: 7px;
        width: 30%;
        height: 25%;
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
        width: 30%;
        height: 25%;
        font-weight: regular;
        color: white;
        letter-spacing: 2px;
        display: inline-block;
        background-color: #73a1b8;
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

    #secundario-amostras{
        width: 100%;
        height: auto;
        background-color: #efefef;
        box-shadow: 0px 0px 5px #a8a8a8;
    }

    #title2{
        margin-top: 50px;
        font-family: 'Roboto', sans-serif;
        color: #445f6d;
        font-size: 18px;
        text-align: left;
        padding: 10px;
    }

    #cancel-confirm{
        margin-top: 10px;
        width: 100%;
        height: auto;
        display: flex;
    }

    .table{
        width: 100%;
        border-spacing: 0;
    }

    .table thead{
        background-color: #c1c1c1;
        height: 30px;
    }

    .table thead .listagem-titulo{
        height: 30px;
        box-shadow: 0px 0px 1px #a8a8a8;
    }

    .table tbody{
        overflow-y: auto;
        overflow-x: hidden;
    }

    .table tbody .listagem{
        height: 40px;
        background-color: white;
        box-shadow: 0px 0px 2px #a8a8a8;
    }

    .table tbody input{
        height: 30px;
        text-align: center;
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



</style>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>Preparo e Inativação</title>
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
        <div id="principal-capela">
            <select id="select-capela" class="form-control" name="sel-capela">
                <option value="">Selecione uma capela</option>
                <option value="Capela 1">Capela 1</option>
                <option value="Capela 2">Capela 2</option>
                <option value="Capela 3">Capela 3</option>
            </select>
            <button onclick="printTable('table-amostras')"type="submit" name="confirmar-capela" class="btn">CONFIRMAR</button><br><br>
        </div>
        <h1 id="title2">AMOSTRAS RELACIONADAS COM A CAPELA SELECIONADA<h1>
                <div id="secundario-amostras">
                    <div class="conteudo_listar">
                        <div class="conteudo_tabela">
                            <table class="table table-hover">
                                <thead>
                                <tr class="listagem-titulo">
                                    <th scope="col">AMOSTRA</th>
                                    <th scope="col">OBSERVAÇÃO</th>
                                    <th scope="col">PROBLEMA</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 1</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 2</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 3</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 4</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 5</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 6</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                <tr class="listagem">
                                    <th scope="col">AMOSTRA 7</th>
                                    <th scope="col"><input type="text" name="obs" class="txtbox" placeholder="Observações"></th>
                                    <th scope="col"><input type="text" name="prob" class="txtbox" placeholder="Problemas"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </div>
    <div id="cancel-confirm">
        <button type="submit" name="cancelar-preparacao" class="btn2">CANCELAR</button><br><br>
        <button type="submit" name="confirmar-preparacao" class="btn2">CONFIRMAR</button><br><br>
    </div>
</main>


<script>
    document.getElementById("secundario-amostras").style.display = "none";
    document.getElementById("title2").style.display = "none";

    function printTable(){
        document.getElementById("secundario-amostras").style.display = "";
        document.getElementById("title2").style.display = "";
    }
</script>


</body>