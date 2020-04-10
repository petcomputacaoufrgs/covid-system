<?php 
require_once 'classes/Pagina/Pagina.php';

$objPagina = new Pagina();
Pagina::abrir_head("Login - Processo de tratamento de amostras para diagnóstico de COVID-19"); ?>

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
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>        
    
    <body>
        

        
        
        <!-- PRINCIPAIS -->
       <!-- <div class="conteudo">
          <div class="row">
             <div class="col-md-2"><h1>TELAS PRINCIPAIS</h1></div>
             <div class="col-md-2">
                <h4>CADASTRAR AMOSTRA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>ARMAZENAR AMOSTRA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>EXTRAIR AMOSTRA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>RTPCR AMOSTRA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>LAUDO AMOSTRA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div>
             
            </div>
        </div> -->
        
        <div class="conteudo">
          <div class="row">
              <div class="col-md-2"><h1>AMOSTRA</h1></div>
              <div class="col-md-2">
                <h4>AMOSTRA</h4>
                <ul class="navbar-nav">
                   <li><a href="controlador.php?action=cadastrar_amostra">Cadastrar</a></li>
                   <li><a href="controlador.php?action=listar_amostra">Listar</a></li>
                </ul>               
             </div>

             <div class="col-md-2">
                <h4>TIPO DE AMOSTRA</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_tipoAmostra">Cadastrar </a></li>
                    <li><a href="controlador.php?action=listar_tipoAmostra">Listar</a></li>
                </ul>               
             </div>
              
                           
              
            <div class="col-md-2">
                <h4>DOENÇA</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=cadastrar_doenca">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_doenca">Listar</a></li>
                </ul>               
             </div>
              
              
              
              <div class="col-md-2">
                <h4>NÍVEL DE PRIORIDADE</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=cadastrar_nivelPrioridade">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_nivelPrioridade">Listar</a></li>
                </ul>               
             </div>
              
              <!--<div class="col-md-2">
                <h4>...</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=#">Cadastrar</a></li>
                    <li><a href="controlador.php?action=#">Listar</a></li>
                </ul>               
             </div> -->
             
            </div>
        </div>
        
         <div class="conteudo">
          <div class="row">
              <div class="col-md-2"><h1>PACIENTE</h1></div>
              <div class="col-md-2">
                <h4>PACIENTES</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=cadastrar_paciente">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_paciente">Listar</a></li>
                </ul>               
             </div>
             
                           
              
              <div class="col-md-2">
                <h4>SEXO PACIENTES</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=cadastrar_sexoPaciente">Cadastrar</a></li>
                <li><a href="controlador.php?action=listar_sexoPaciente">Listar</a></li>
                </ul>               
             </div>
              
              
              
              <div class="col-md-2">
                <h4>PERFIL PACIENTE</h4>
                <ul class="navbar-nav">
                  <li><a href="controlador.php?action=cadastrar_perfilPaciente">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_perfilPaciente">Listar</a></li>
                </ul>               
             </div>
              
              
             
            </div>
        </div>
          
          
        
        <div class="conteudo">
          <div class="row">
              <div class="col-md-2"><h1>EQUIPAMENTO</h1></div>
              <div class="col-md-2">
                <h4>EQUIPAMENTO</h4>
                <ul class="navbar-nav">
                 <li><a href="controlador.php?action=cadastrar_equipamento">Cadastrar</a></li>
                <li><a href="controlador.php?action=listar_equipamento">Listar</a></li>
                </ul>               
             </div>
             
                           
              
              <div class="col-md-2">
                <h4>MARCA</h4>
                <ul class="navbar-nav">
                 <li><a href="controlador.php?action=cadastrar_marca">Cadastrar</a></li>
                <li><a href="controlador.php?action=listar_marca">Listar</a></li>
                </ul>               
             </div>
              
              
              
              <div class="col-md-2">
                <h4>MODELO</h4>
                <ul class="navbar-nav">
                   <li><a href="controlador.php?action=cadastrar_modelo">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_modelo">Listar</a></li>
                </ul>               
             </div>
              
               <div class="col-md-2">
                <h4>DETENTOR</h4>
                <ul class="navbar-nav">
                 <li><a href="controlador.php?action=cadastrar_detentor">Cadastrar</a></li>
                <li><a href="controlador.php?action=listar_detentor">Listar</a></li>
                </ul>               
             </div>
             
            </div>
        </div>
        
        
         <div class="conteudo">
          <div class="row">
              <div class="col-md-2"><h1>USUÁRIO</h1></div>
              <div class="col-md-2">
                <h4>USUÁRIO</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_usuario">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_usuario">Listar</a></li>
                </ul>               
             </div>
             
                           
              
              <div class="col-md-2">
                <h4>RECURSO</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_recurso">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_recurso">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>PERFIS USUÁRIO</h4>
                <ul class="navbar-nav">
                   <li><a href="controlador.php?action=cadastrar_perfilUsuario">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_perfilUsuario">Listar</a></li>
                </ul>               
             </div>
              
              <div class="col-md-2">
                <h4>USUÁRIO + PERFIL + RECURSO </h4>
                <ul class="navbar-nav">
                   <li><a href="controlador.php?action=cadastrar_rel_usuario_perfil_recurso">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_rel_usuario_perfil_recurso">Listar</a></li>
                </ul>               
             </div>
              
                            
            </div>
        </div>
        
        <div class="conteudo">
          <div class="row">
              <div class="col-md-3"><h1>ARMAZENAMENTO</h1></div>
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
              
               <div class="col-md-2">
                <h4>CAPELA</h4>
                <ul class="navbar-nav">
                    <li><a href="controlador.php?action=cadastrar_capela">Cadastrar</a></li>
                    <li><a href="controlador.php?action=listar_capela">Listar</a></li>
                    <li><a href="controlador.php?action=bloquear_capela">Bloquear</a></li>
                </ul>               
             </div>
             
                           
              
             
              
              
            </div>
        </div>
        
           <li><a href="controlador.php?action=recepcionar_amostra">Etapa Recepção Amostra</a></li>
        <li><a href="controlador.php?action=cadastrar_amostra_localArmazenamento">Preparação e Armazenamento</a></li>
        <li><a href="controlador.php?action=extrair_amostra">Etapa Extração</a></li>
        <li><a href="controlador.php?action=exibir_laudo">Etapa Laudo</a></li>    
        
        
        
        

    <?php
    $objPagina->fechar_corpo();
    
    ?>
