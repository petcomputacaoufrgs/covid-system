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
?>        
    
    <body>
        
         <div class="conjunto_itens">
          <div class="row">
        <?php 
            // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
            if(Sessao::getInstance()->verificar_permissao('cadastrar_amostra')){ 
                  echo '<div class="col-md-2">
                          <a  class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra').'">CADASTRO AMOSTRA</a>'
                          . '</div>';
            } 
        ?>
        
        <?php 
            // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
            if(Sessao::getInstance()->verificar_permissao('gerar_estatisticas')){ 
                  echo '<div class="col-md-2">
                          <a target="_blank" class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=gerar_estatisticas').'">ESTATÍSTICAS </a>'
                          . '</div>';
            } 
        ?>

        <?php
        // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
        if(Sessao::getInstance()->verificar_permissao('montar_preparo_extracao')){
            echo '<div class="col-md-2">
                          <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao').'">MONTAR PREPARO/EXTRAÇÃO </a>'
                . '</div>';
        }
        ?>
          </div>
         </div>
        
        <div class="conjunto_itens">
          <div class="row">
              
              <?php 
                    // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                    if(Sessao::getInstance()->verificar_permissao('listar_amostra')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_amostra').'">AMOSTRA</a>'
                                  . '</div>';
                    } 
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
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_detentor').'">DETENTOR</a>'
                                  . '</div>';
                    } 
              ?>
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_doenca')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_doenca').'">DOENÇA</a>'
                                  . '</div>';
                    } 
              ?>
              
              <?php 
                    // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                    if(Sessao::getInstance()->verificar_permissao('listar_equipamento')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_equipamento').'">EQUIPAMENTO</a>'
                                  . '</div>';
                    } 
              ?>
             
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_marca')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_marca').'">MARCA</a>'
                                  . '</div>';
                    } 
              ?>
               
          </div>
        </div>
        
        <div class="conjunto_itens">
          <div class="row">
              
                <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_modelo')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_modelo').'">MODELO</a>'
                                  . '</div>';
                    } 
              ?>
             
              
               <?php 
                    // echo '<div class="col-md-1><h4>AMOSTRA</h4></div>';
                    if(Sessao::getInstance()->verificar_permissao('listar_nivelPrioridade')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_nivelPrioridade').'">NÍVEL PRIORIDADE</a>'
                                  . '</div>';
                    } 
              ?>
              
              <?php 
                    if(Sessao::getInstance()->verificar_permissao('listar_paciente')){ 
                          echo '<div class="col-md-2">
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_paciente').'">PACIENTE</a>'
                                  . '</div>';
                    } 
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
        
        
        <div class="conjunto_itens">
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
                                  <a class="btn btn-primary " href="'.Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario').'">USUÁRIO</a>'
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
        
        
             
        
        
        
        <!--
        <div class="conteudo">
                <div class="row">        
                       
             <div class="col-md-2">
                <h4>TIPO DE AMOSTRA</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_tipoAmostra">Cadastrar </a></li>
                    <li><a href="controlador.php?action=listar_tipoAmostra">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>LOCAL ARMAZENAMENTO</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_localArmazenamento">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_localArmazenamento">Listar</a></li>
                </ul>               
             </div>
              <div class="col-md-2">
                <h4>TIPO LOCAL ARMAZENAMENTO</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_tipoLocalArmazenamento">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_tipoLocalArmazenamento">Listar</a></li>
                </ul>               
             </div>
         
             
            </div>
        </div>
          -->
        
<?php
    Pagina::getInstance()->fechar_corpo();

