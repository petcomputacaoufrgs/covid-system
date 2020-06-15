<?php
session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';

require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

Sessao::getInstance()->validar();

$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$objUsuario->setIdUsuario(Sessao::getInstance()->getIdUsuario());
$objUsuario = $objUsuarioRN->consultar($objUsuario);
//print_r($objUsuario);


Pagina::getInstance()->abrir_head("Processo de tratamento de amostras para diagnóstico de COVID-19"); 
Pagina::getInstance()->adicionar_css("precadastros"); ?>
      	
<style>
	
        .conteudo{
            background-color: white;
            padding: 5px;
            margin-top: 100px;
            text-align: center;
          }
        
        .conteudo h4 {
            color: #808080;
            background: #e9e9e9;
            font-weight: normal;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius:  5px;
            border-bottom: 1px solid #949494;
              /*box-shadow: 2px;*/
          }
          
          .conteudo .navbar-nav{
              background: purple;
              margin-top: -8px;
          }

          .conteudo .navbar-nav li{
              background-color: #bdbebd;
              padding: 10px;
              font-size: 20px;
          }

          .conteudo .navbar-nav li a{
              text-decoration: none;
              color: white;
          }

          .conteudo .navbar-nav li:hover{
              text-decoration: none;
              color: white;
              background-color: #949494;
          }

        
	</style> 
<?php Pagina::getInstance()->fechar_head(); 
      Pagina::getInstance()->montar_menu_topo();


      //verificação capela

      ?>



    
    <body>
        <!--<a href="controlador.php?action=montar_caixas">montar caixas</a>-->

        <div class="conjunto_itens">
            <div class="row" style="text-align: center;">
                <h5 style="padding-left10px;color: red;"> Banco de dados atualizado em 11/06/2020 - 14:02</h5>
            </div>
        </div>

         <div class="conjunto_itens">
          <div class="row">

              <?php
                    if(Sessao::getInstance()->verificar_permissao('cadastrar_amostra') ||
                        Sessao::getInstance()->verificar_permissao('listar_amostra')
                        || Sessao::getInstance()->verificar_permissao('gerar_estatisticas')) {
                        echo '<div class="col-md-2">
                            <h5>Etapa RECEPÇÃO AMOSTRA</h5>
                            </div>';
                    }
              ?>

            <?php
                // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                if(Sessao::getInstance()->verificar_permissao('cadastrar_amostra')){
                      echo '<div class="col-md-4">
                              <a  class="btn btn-primary" STYLE="margin-top: 17px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra').'">CADASTRO AMOSTRA</a>'
                              . '</div>';
                }
            ?>

              <?php
              // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
              if(Sessao::getInstance()->verificar_permissao('listar_amostra')){
                  echo '<div class="col-md-3">
                          <a  class="btn btn-primary" STYLE="margin-top: 17px;background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra').'"><i class="fas fa-list icon" ></i> LISTAR AMOSTRAS</a>'
                      . '</div>';
              }
              ?>

              <?php
              // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
              if(Sessao::getInstance()->verificar_permissao('gerar_estatisticas')){
                  echo '<div class="col-md-3">
                          <a target="_blank" class="btn btn-primary"  STYLE="margin-top: 17px;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=gerar_estatisticas').'">ESTATÍSTICAS DO CADASTRO </a>'
                      . '</div>';
              }
              ?>
        


          </div>
         </div>

        <div class="conjunto_itens" STYLE="margin-top: 10px;">
            <div class="row">
                <?php
                    if(Sessao::getInstance()->verificar_permissao('montar_preparo_extracao') ||
                        Sessao::getInstance()->verificar_permissao('realizar_preparo_inativacao') ||
                        Sessao::getInstance()->verificar_permissao('listar_preparo_lote')) {
                        echo '<div class="col-md-2">
                            <h5>Etapa MONTAGEM e PREPARO</h5>
                            </div>';
                    }
                 ?>

                  <?php
                  // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                  if(Sessao::getInstance()->verificar_permissao('montar_preparo_extracao')){
                      echo '
                            <div class="col-md-4">
                          <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao').'">MONTAGEM DO GRUPO DE AMOSTRAS PARA PREPARAÇÃO </a>'
                          . '</div>';
                  }
                  ?>


                  <?php
                  if(Sessao::getInstance()->verificar_permissao('realizar_preparo_inativacao')){
                      echo '<div class="col-md-2" style="margin-top: 0px;">
                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao').'">REALIZAR PREPARO/INATIVAÇÃO </a>'
                          . '</div>';
                  }
                  ?>

                    <?php
                    if(Sessao::getInstance()->verificar_permissao('listar_preparo_lote')){
                        echo '<div class="col-md-4">
                              <a class="btn btn-primary"  style="background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_preparo_lote').'">LISTAR LOTES DE MONTAGEM DE GRUPOS E DE PREPARAÇÃO </a>'
                            . '</div>';
                    }
                    ?>



            </div>
        </div>



        <div class="conjunto_itens" STYLE="margin-top: 10px;">
            <div class="row">
                <?php
                if(Sessao::getInstance()->verificar_permissao('realizar_extracao') ||
                    Sessao::getInstance()->verificar_permissao('listar_preparo_inativacao')) {

                    echo '<div class="col-md-2">
                            <h5>Etapa EXTRAÇÃO</h5>
                            </div>';
                }
                ?>


                <?php
                    if(Sessao::getInstance()->verificar_permissao('realizar_extracao')){
                        echo '<div class="col-md-3">
                              <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao').'">EXTRAÇÃO </a>'
                            . '</div>';
                    }
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_preparo_inativacao')){
                    echo '<div class="col-md-3">
                  <a class="btn btn-primary" style="background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_preparo_inativacao').'">LISTAR LOTES DE EXTRAÇÃO </a>'
                        . '</div>';
                }
                ?>



            </div>
        </div>


        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">

                <?php
                if(Sessao::getInstance()->verificar_permissao('solicitar_montagem_placa_RTqPCR') ||
                    Sessao::getInstance()->verificar_permissao('listar_preparo_inativacao')) {
                    echo '<div class="col-md-2">
                            <h5>Etapa SOLICITAÇÃO MONTAGEM PLACA RTqPCR</h5>
                            </div>';
                }
                ?>

            <?php
            if(Sessao::getInstance()->verificar_permissao('solicitar_montagem_placa_RTqPCR')){
                echo '<div class="col-md-4">
                                      <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR').'">SOLICITAÇÃO MONTAGEM PLACA RTqPCR</a>'
                    . '</div>';
            }
            ?>

            <?php
            if(Sessao::getInstance()->verificar_permissao('listar_solicitacao_montagem_placa_RTqPCR')){
                echo '<div class="col-md-4">
                                      <a class="btn btn-primary "  style="background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_solicitacao_montagem_placa_RTqPCR').'">LISTAR SOLICITAÇÕES MONTAGEM PLACA RTqPCR</a>'
                    . '</div>';
            }
            ?>

            </div>
        </div>

        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">

                <?php
                if(Sessao::getInstance()->verificar_permissao('mix_placa_RTqPCR') ||
                    Sessao::getInstance()->verificar_permissao('listar_mix_placa_RTqPCR')) {
                    echo '<div class="col-md-2">
                            <h5>Etapa MIX DA PLACA RTqPCR</h5>
                            </div>';
                }
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('mix_placa_RTqPCR')){
                    echo '<div class="col-md-4">
                                      <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR').'">MIX PLACA RTqPCR</a>'
                        . '</div>';
                }
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_mix_placa_RTqPCR')){
                    echo '<div class="col-md-4">
                                      <a class="btn btn-primary "  style="background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_mix_placa_RTqPCR').'">LISTAR MIX PLACA RTqPCR</a>'
                        . '</div>';
                }
                ?>


            </div>
        </div>

        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">

                <?php
                if(Sessao::getInstance()->verificar_permissao('montar_placa_RTqPCR')
                    || Sessao::getInstance()->verificar_permissao('listar_montagem_placa_RTqPCR')) {
                    echo '<div class="col-md-2">
                            <h5>Etapa MONTAGEM DA PLACA RTqPCR</h5>
                            </div>';
                }
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('montar_placa_RTqPCR')){
                    echo '<div class="col-md-4">
                                      <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=montar_placa_RTqPCR').'">MONTAGEM PLACA RTqPCR</a>'
                        . '</div>';
                }
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_montagem_placa_RTqPCR')){
                    echo '<div class="col-md-4">
                                      <a class="btn btn-primary "  style="background-color: #67BFDB;"   href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_montagem_placa_RTqPCR').'">LISTAR MONTAGEM DA PLACA RTqPCR</a>'
                        . '</div>';
                }
                ?>


            </div>
        </div>


        <div class="conjunto_itens" STYLE="margin-top: 10px;">
            <div class="row">
                <?php


                if(Sessao::getInstance()->verificar_permissao('listar_equipamento')  ||
                    Sessao::getInstance()->verificar_permissao('analisar_RTqPCR') ||
                    Sessao::getInstance()->verificar_permissao('finalizar_RTqPCR')) {
                    echo '<div class="col-md-2">
                        <h5>Etapa RTqPCR</h5>
                        </div>';
                }

                if(Sessao::getInstance()->verificar_permissao('listar_equipamento')){
                    echo '<div class="col-md-4">
                             <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_equipamento').'">EQUIPAMENTOS DE RTQPCR</a>'
                        . '</div>';
                }

                if(Sessao::getInstance()->verificar_permissao('analisar_RTqPCR')){
                    echo '<div class="col-md-3">
                             <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR').'">ANÁLISE RTQPCR</a>'
                        . '</div>';
                }




                if(Sessao::getInstance()->verificar_permissao('finalizar_RTqPCR')){
                    echo '<div class="col-md-3">
                             <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=finalizar_RTqPCR').'">FINALIZAR RTQPCR</a>'
                        . '</div>';
                }

                ?>
            </div>
        </div>

        <div class="conjunto_itens" STYLE="margin-top: 10px;">
            <div class="row">

                <?php
                    if(Sessao::getInstance()->verificar_permissao('listar_laudo')) {
                        echo '<div class="col-md-2">
                                                <h5>Etapa LAUDO</h5>
                                                </div>';
                    }
                ?>

                <?php

                if (Sessao::getInstance()->verificar_permissao('listar_laudo')) {
                    echo '<div class="col-md-3">
                              <a class="btn btn-primary" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_laudo') . '">LISTAR LAUDOS </a>'
                        . '</div>';
                }

                ?>

            </div>
        </div>


        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">


        <?php
        // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
        if(Sessao::getInstance()->verificar_permissao('rastrear_amostras')){
            echo '<div class="col-md-4" style="margin-top: 10px;">
                        <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=rastrear_amostras').'">RASTREAR AMOSTRAS </a>'
                . '</div>';
        }
        ?>


            </div>
        </div>



        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">


                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_kitExtracao')){
                    echo '<div class="col-md-4">
                              <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_kitExtracao').'">LISTAR KITS DE EXTRAÇÃO </a>'
                        . '</div>';
                }


                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_protocolo')){
                    echo '<div class="col-md-4">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_protocolo').'">LISTAR PROTOCOLOS</a>'
                        . '</div>';
                }
                ?>


                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_placa')){
                    echo '<div class="col-md-4">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_placa').'">LISTAR PLACAS</a>'
                        . '</div>';
                }
                ?>


            </div>
        </div>




        <div class="conjunto_itens" style="margin-top: 10px;">
            <div class="row">
                <?php
                /*
                if(Sessao::getInstance()->verificar_permissao('listar_divisao_protocolo')){
                    echo '<div class="col-md-4">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_divisao_protocolo').'">LISTAR DIVISÃO PROTOCOLO</a>'
                        . '</div>';
                }
                */
                ?>

                <?php
                if(Sessao::getInstance()->verificar_permissao('listar_localArmazenamentoTxt')){
                    echo '<div class="col-md-4">
                              <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_localArmazenamentoTxt').'">LISTAR LOCAIS DE ARMAZENAMENTO </a>'
                        . '</div>';
                }
                ?>

                <?php

                if(Sessao::getInstance()->verificar_permissao('cadastrar_poco')){
                    echo '<div class="col-md-4">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_poco').'">CADASTRAR POÇO</a>'
                        . '</div>';
                }
                ?>



            </div>
        </div>



        <div class="conjunto_itens">
            <div class="row">


                <?php
                // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                if(Sessao::getInstance()->verificar_permissao('cadastrar_localArmazenamento')){
                    /*echo '<div class="col-md-2">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_localArmazenamento').'">CADASTRAR LOCAL DE ARMAZENAMENTO </a>'
                        . '</div>';*/
                }
                ?>

                <?php

                if(Sessao::getInstance()->verificar_permissao('cadastrar_tipoLocalArmazenamento')){
                    echo '<div class="col-md-2">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_tipoLocalArmazenamento').'">CADASTRAR TIPO LOCAL DE ARMAZENAMENTO </a>'
                        . '</div>';
                }
                ?>

                <?php
                // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                if(Sessao::getInstance()->verificar_permissao('mostrar_localArmazenamento')){
                    /*echo '<div class="col-md-2">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_localArmazenamento').'">MOSTRAR LOCAL DE ARMAZENAMENTO </a>'
                        . '</div>';*/
                }
                ?>

                <?php
                // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                if(Sessao::getInstance()->verificar_permissao('editar_caixa')){
                    /*echo '<div class="col-md-2">
                                  <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=editar_caixa').'">EDITAR CAIXA </a>'
                        . '</div>';*/
                }
                ?>

            </div>
        </div>


        <div class="conjunto_itens">
          <div class="row">
              
              <?php /*
                    // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                    if(Sessao::getInstance()->verificar_permissao('listar_amostra')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra').'">LISTAR AMOSTRA</a>'
                                  . '</div>';
                    } */
              ?>
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_capela')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_capela').'">CAPELA</a>'
                                  . '</div>';
                    } 
              ?>
              
               <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_detentor')){
                        /* echo '<div class="col-md-2">
                                <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_detentor').'">DETENTOR</a>'
                                . '</div>';*/
                    } 
              ?>
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_doenca')){ 
                          /*echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_doenca').'">DOENÇA</a>'
                                  . '</div>';*/
                    } 
              ?>
              

             
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_marca')){
                        /*  echo '<div class="col-md-2">
                                 <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_marca').'">MARCA</a>'
                                 . '</div>';*/
                    } 
              ?>
               
          </div>
        </div>
        
        <div class="conjunto_itens">
          <div class="row">
              
                <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_modelo')){ 
                        /*   echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_modelo').'">MODELO</a>'
                                  . '</div>';*/
                    } 
              ?>
             
              
               <?php 
                    // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                    if(Sessao::getInstance()->verificar_permissao('listar_nivelPrioridade')){ 
                         /*  echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_nivelPrioridade').'">NÍVEL PRIORIDADE</a>'
                                  . '</div>';*/
                    } 
              ?>

              <?php
              /*
                    if(Sessao::getInstance()->verificar_permissao('listar_paciente')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_paciente').'">PACIENTE</a>'
                                  . '</div>';
                    }
              */
              ?>

              
             
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_perfilPaciente')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilPaciente').'">PERFIL PACIENTE</a>'
                                  . '</div>';
                    } 
              ?>
              
             
             
              
              
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_rel_perfilUsuario_recurso')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_rel_perfilUsuario_recurso').'">PERFIL USUÁRIO + RECURSO</a>'
                                  . '</div>';
                    } 
              ?>
              
               <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_usuario_perfilUsuario')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario_perfilUsuario').'">USUÁRIO + PERFIL</a>'
                                  . '</div>';
                    } 
              ?>
          </div>
        </div>
        
        
        <div class="conjunto_itens" >
          <div class="row">
              
             
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_recurso')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_recurso').'">RECURSO</a>'
                                  . '</div>';
                    } 
              ?>
              
               
               <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_sexoPaciente')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_sexoPaciente').'">SEXO PACIENTE</a>'
                                  . '</div>';
                    } 
              ?>
              
               
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_usuario')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " style="background-color: #67BFDB;" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario').'">LISTAR USUÁRIO</a>'
                                  . '</div>';
                    } 
              ?>
             <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_perfilUsuario')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_perfilUsuario').'">PERFIL USUÁRIO</a>'
                                  . '</div>';
                    } 
              ?>
              
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_etnia')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_etnia').'">ETNIA</a>'
                                  . '</div>';
                    } 
              ?>
             
          </div>
        </div>








    </body>
        
<?php
    Pagina::getInstance()->fechar_corpo();

