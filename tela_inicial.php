<?php 
require_once 'classes/Pagina/Pagina.php';

$objPagina = new Pagina();
Pagina::abrir_head("Login - Processo de tratamento de amostras para diagnóstico de COVID-19"); ?>

      	<style>
	.fas{
            color:green;
	}
        .conteudo{
        background-color: white;
        padding: 5px;
        margin-top: 50px;
        text-align: center;
        margin-right: 2%;
        margin-left: 2%;
        width: 96%;
        
      }
        
        .conteudo h4 {
            color: #808080;
            background: #e9e9e9;
            font-weight: normal;
            padding: 10px;
            height: 100px;
            padding-top: 20%;
            text-align: center;
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
        
    
    <body>
        

        
        <h1>Ações</h1>
        <!-- PRINCIPAIS -->
        <div class="conteudo">
          <div class="row">
             
              <div class="col-md-2" style="background-color:red;">
                
                  <h4><a href="controlador.php?action=cadastrar_amostra">CADASTRAR AMOSTRA</a></h4>
                
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
        </div> 
        
                
        
        

    <?php
    $objPagina->fechar_corpo();
    
    ?>
