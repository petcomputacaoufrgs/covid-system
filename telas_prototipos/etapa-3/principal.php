<?php


require_once '../../classes/Pagina/Pagina.php';
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

<style>
  @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

  *{
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
  }
  
  .HeaderImg{
        width: 100%;
        height: auto;
    }

    .nav-item a{
      color: black;
    }

    .nav-item a:hover{
      color: black;
    }

    #criar-placa{
      background-color: #445f6d;
      margin-bottom: 5%;

    }

    #txt-criar-placa{
      font-size: 30px;
      margin-top: 15px;
      color: white;
    }

    #btn-criar-placa{
      width: 200px;
      height: 100%;
      background-color: #445f6d;
      border: none;
      border-radius: 0;
      outline:none;
      color: white;
    }

    #btn-criar-placa:hover{
      width: 200px;
      height: 100%;
      background-color: white;
      color: #445f6d;
      border: none;
      border-radius: 0;
    }

    #btn-confirm{
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
        margin-left: 20%;
        margin-top: 5%;
        margin-bottom: 5%;
    }

    #btn-confirm:hover{
        border: none;
        border-radius: 7px;
        width: 220px;
        height: 60px;
        font-weight: regular;
        color: white;
        letter-spacing: 2px;
        display: inline-block;
        background-color: #73a1b8;
        margin-top: 5%;
        margin-bottom: 5%;
    }





</style>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1" />
    <title>Criar placa RTqPCR</title>
    <link href="../../public_html/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../public_html/js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="../../public_html/js/bootstrap.min.js"></script>
  </head>

  <body>
    <header>
    <nav>
      <a><img src="../../public_html/docs/img/header.png" class='HeaderImg'></a>
    </nav>
    <header>
    <div id="nav-principal"class="container">
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" href="#">COVID-19</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Criar placa RTqPCR</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Usuario logado: </a>
        </li>
      </ul>
    </div>

    <div id="criar-placa">
      <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto"><p class="align-middle"id="txt-criar-placa">CRIAR PLACA RTqPCR</p></div>
          <div class="col-6 col-md-4">
            <button onclick="showDiv('formulario')" type="button" id="btn-criar-placa">CRIAR NOVA PLACA</button>
          </div>
        </div>
      </div>
    </div>

    <div id="formulario">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="form">
              <p>Selecione um protocolo</p>
              <div class="form-check">
                <input id="prot-sus-lacen"class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                  SUS/LACEN
                </label>
              </div>
              <div class="form-check">
                <input id="prot-1" class="form-check-input outro-protocolo" type="checkbox" value="" id="defaultCheck2">
                <label class="form-check-label" for="defaultCheck2">
                  Protocolo 1
                </label>
              </div>
              <div class="form-check">
                <input id="prot-2" class="form-check-input outro-protocolo" type="checkbox" value="" id="defaultCheck3">
                <label class="form-check-label" for="defaultCheck3">
                  Protocolo 2
                </label>
              </div>
              <div class="form-check">
                <input id="prot-3" class="form-check-input outro-protocolo" type="checkbox" value="" id="defaultCheck4">
                <label class="form-check-label" for="defaultCheck4">
                  Protocolo 3
                </label>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form">
              <p>Selecione um perfil</p>
              <div class="form-check">
                <input id="perfil-1" class="form-check-input outro-perfil" type="checkbox" value="" id="defaultCheck5">
                <label class="form-check-label" for="defaultCheck5">
                  Profissional da Saúde
                </label>
              </div>
              <div class="form-check">
                <input id="perfil-2" class="form-check-input outro-perfil" type="checkbox" value="" id="defaultCheck6">
                <label class="form-check-label" for="defaultCheck6">
                  Equipe de Voluntários
                </label>
              </div>
              <div class="form-check">
                <input id="perfil-sus" class="form-check-input sus" type="checkbox" value="" id="defaultCheck7">
                <label class="form-check-label" for="defaultCheck7">
                  Paciente SUS
                </label>
              </div>
              <div class="form-check">
                <input id="perfil-3" class="form-check-input outro-perfil" type="checkbox" value="" id="defaultCheck8">
                <label class="form-check-label" for="defaultCheck8">
                  Funcionários ENGIE
                </label>
              </div>
              <div class="form-check">
                <input id="perfil-4" class="form-check-input outro-perfil" type="checkbox" value="" id="defaultCheck9">
                <label class="form-check-label" for="defaultCheck9">
                  Outros
                </label>
              </div>
            </div>
          </div>
        </div>

        <button onclick="showDiv('tabela-amostras')" type="button" id="btn-confirm">CONFIRMAR</button>

      </div>
    </div>

    <div id="tabela-amostras">
      <div class="container">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amostra</th>
              <th scope="col">
                <div class="form-check">
                  <input id="select-all" class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar tudo
                  </label>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>AMOSTRA 1</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>AMOSTRA 2</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>AMOSTRA 3</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <td>AMOSTRA 4</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">5</th>
              <td>AMOSTRA 5</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">6</th>
              <td>AMOSTRA 6</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">7</th>
              <td>AMOSTRA 7</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">8</th>
              <td>AMOSTRA 8</td>
              <td>
                <div class="form-check">
                  <input class="form-check-input select-amostra" type="checkbox" value="" id="defaultCheck3">
                  <label class="form-check-label" for="defaultCheck3">
                    Selecionar amostra
                  </label>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <button onclick="showDiv('tabela-amostras')" type="button" id="btn-confirm">SALVAR</button>


      </div>
    </div>



  </body>

  <script>

    function showDiv(div){
      document.getElementById(div).style.display = "";
    }

    function createEventListener(prot_sus, prot1, prot2, prot3){
      const check_sus = document.querySelector("#" + prot_sus);
      const perfil_sus = document.querySelector("#" + 'perfil-sus');
      const prot_1 = document.querySelector("#" + prot1);
      const prot_2 = document.querySelector("#" + prot2);
      const prot_3 = document.querySelector("#" + prot3);
      var outros_perfis = document.getElementsByClassName('outro-perfil');
      var outros_protocolos = document.getElementsByClassName('outro-protocolo')
      check_sus.addEventListener("change", (el) => {
        if(check_sus.checked){
          prot_1.disabled = true;
          prot_2.disabled = true;
          prot_3.disabled = true;
          for(var i in outros_perfis){
            outros_perfis[i].disabled = true;
          }
        }else{
          prot_1.disabled = false;
          prot_2.disabled = false;
          prot_3.disabled = false;
          for(var i in outros_perfis){
            outros_perfis[i].disabled = false;
          }
        }
      });
      check_sus.dispatchEvent(new Event("change"));

      prot_1.addEventListener("change", (el) => {
        if(prot_1.checked){
          check_sus.disabled = true;
          perfil_sus.disabled = true;
        }else{
          check_sus.disabled = false;
          perfil_sus.disabled = false;
        }
      });
      prot_1.dispatchEvent(new Event("change"));

    prot_2.addEventListener("change", (el) => {
        if(prot_2.checked){
          check_sus.disabled = true;
          perfil_sus.disabled = true;
        }else{
          check_sus.disabled = false;
          perfil_sus.disabled = false;
        }
      });
      prot_2.dispatchEvent(new Event("change"));

    prot_3.addEventListener("change", (el) => {
        if(prot_3.checked){
          check_sus.disabled = true;
          perfil_sus.disabled = true;
        }else{
          check_sus.disabled = false;
          perfil_sus.disabled = false;
        }
      });
      prot_3.dispatchEvent(new Event("change"));
    }

    function createEventListenerPerfil(perfil_sus_lacen, perfil1, perfil2, perfil3, perfil4){
      const perfil_sus = document.querySelector("#" + perfil_sus_lacen);
      const prot_sus = document.querySelector("#" + 'prot-sus-lacen');
      const perfil_1 = document.querySelector("#" + perfil1);
      const perfil_2 = document.querySelector("#" + perfil2);
      const perfil_3 = document.querySelector("#" + perfil3);
      const perfil_4 = document.querySelector("#" + perfil4);

      var outros_protocolos =  document.getElementsByClassName('outro-protocolo');

      perfil_sus.addEventListener("change", (el) => {
      if(perfil_sus.checked){
          perfil_1.disabled = true;
          perfil_2.disabled = true;
          perfil_3.disabled = true;
          perfil_4.disabled = true;
          for(var i in outros_protocolos){
            outros_protocolos[i].disabled = true;
          }
        }else{
          perfil_1.disabled = false;
          perfil_2.disabled = false;
          perfil_3.disabled = false;
          perfil_4.disabled = false;
          for(var i in outros_protocolos){
            outros_protocolos[i].disabled = false;
          }
        }
      });
      perfil_sus.dispatchEvent(new Event("change"));


      perfil_1.addEventListener("change", (el) => {
      if(perfil_1.checked){
          perfil_sus.disabled = true;
          prot_sus.disabled = true;
        }else{
          perfil_sus.disabled = false;
          prot_sus.disabled = false;
        }
      });
      perfil_1.dispatchEvent(new Event("change"));

      perfil_2.addEventListener("change", (el) => {
      if(perfil_2.checked){
          perfil_sus.disabled = true;
          prot_sus.disabled = true;
        }else{
          perfil_sus.disabled = false;
          prot_sus.disabled = false;
        }
      });
      perfil_2.dispatchEvent(new Event("change"));

      perfil_3.addEventListener("change", (el) => {
      if(perfil_3.checked){
          perfil_sus.disabled = true;
          prot_sus.disabled = true;
        }else{
          perfil_sus.disabled = false;
          prot_sus.disabled = false;
        }
      });
      perfil_3.dispatchEvent(new Event("change"));

      perfil_4.addEventListener("change", (el) => {
      if(perfil_4.checked){
          perfil_sus.disabled = true;
          prot_sus.disabled = true;
        }else{
          perfil_sus.disabled = false;
          prot_sus.disabled = false;
        }
      });
      perfil_4.dispatchEvent(new Event("change"));
    }

    function createEventListenerTabelaAmostra(class_select_amostra, select_all){
      var checkboxes =  document.getElementsByClassName(class_select_amostra);
      const check_all = document.querySelector("#" + select_all);

      check_all.addEventListener("change", (el) => {
        if(check_all.checked){
          for(var i in checkboxes){
            checkboxes[i].checked = true;
          }
        }else{
          for(var i in checkboxes){
            checkboxes[i].checked = false;
          }
        }
      });
      check_all.dispatchEvent(new Event("change"));
    }

    document.getElementById('formulario').style.display = 'none';
    document.getElementById('tabela-amostras').style.display = 'none';

    createEventListener('prot-sus-lacen', 'prot-1', 'prot-2', 'prot-3');
    createEventListenerPerfil('perfil-sus', 'perfil-1', 'perfil-2', 'perfil-3', 'perfil-4');
    createEventListenerTabelaAmostra('select-amostra', 'select-all');
    
  </script>
</html>