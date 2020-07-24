<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Sessao/Sessao.php';
require_once __DIR__ . '/../Log/Log.php';
require_once __DIR__ . '/../Log/LogRN.php';
require_once __DIR__ .'/../../utils/Alert.php';

class Pagina {

    private $array_validacoes;
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Pagina();
        }
        return self::$instance;
    }
    
    function __construct() {
        $this->array_validacoes = array();
    }

    
    
    public function adicionar_javascript($strArquivo){
        $strVersao ='';
        if(Configuracao::getInstance()->getValor('producao')){
            $strVersao =Configuracao::getInstance()->getValor('versao');
        }else{
           $strVersao = rand(); 
        }
        
        echo '<script type="text/javascript" src="js/'.$strArquivo.'.js?'.$strVersao.'"></script>';
    }
    
    public function adicionar_css($strArquivo){
        $strVersao ='';
        if(Configuracao::getInstance()->getValor('producao')){
            $strVersao =Configuracao::getInstance()->getValor('versao');
        }else{
           $strVersao = rand(); 
        }

        echo '<link rel="stylesheet" type="text/css" href="css/'.$strArquivo.'.css?'.$strVersao.'">';
    }
    
    public function processar_excecao($e) {
        if ($e instanceof Excecao && $e->possui_validacoes()) {
            $this->array_validacoes = $e->get_validacoes();
        } else {

            try {
                
                $log = new Log();
                $log->setIdUsuario(Sessao::getInstance()->getIdUsuario());
                $log->setTexto($e->__toString()."\n".$e->getTraceAsString());
                date_default_timezone_set('America/Sao_Paulo');
                $log->setDataHora(date("Y-m-d H:i:s"));
                print_r($log);
                $logRN = new LogRN();
                $logRN->cadastrar($log);
                //die("aqui");
                
            } catch (Throwable $ex) {      
            }
            //header('Location: controlador.php?action=erro');
            die('pagina->processarexcecao ' . $e);
        }
    }

    public function montar_menu_topo()
    {
        //echo '<a href="controlador.php?action=principal">TELA INICIAL</a>';
        echo '<header >
            <!--<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=principal') . '" ></a> -->
            
           <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">

                <a class="navbar-brand" style="border: none;" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=principal') . '">Tela Inicial<i class="fas fa-virus"></i></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarsExample11">
                    <ul class="navbar-nav">';


        if (Sessao::getInstance()->verificar_permissao('cadastrar_amostra')) {
            echo '<li class="nav-item active">
                            <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_amostra') . '">Cadastro Amostra</a>
                        </li>';
        }


        if (Sessao::getInstance()->verificar_permissao('montar_preparo_extracao') ||
            Sessao::getInstance()->verificar_permissao('realizar_preparo_inativacao') ||
            Sessao::getInstance()->verificar_permissao('realizar_extracao')) {
            echo ' <li class="nav-item">
                        <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          PREPARAÇÃO E EXTRAÇÃO
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

        if (Sessao::getInstance()->verificar_permissao('montar_preparo_extracao')) {
            echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao') . '">Montar grupo preparação</a>';
        }

        if (Sessao::getInstance()->verificar_permissao('realizar_preparo_inativacao')) {
            echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_preparo_inativacao') . '">Realizar Preparação/Inativação</a>';
        }

        if (Sessao::getInstance()->verificar_permissao('realizar_extracao')) {
            echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=realizar_extracao') . '">Realizar Extração</a>';
        }
    }


        if (Sessao::getInstance()->verificar_permissao('solicitar_montagem_placa_RTqPCR') ||
            Sessao::getInstance()->verificar_permissao('mix_placa_RTqPCR') ||
            Sessao::getInstance()->verificar_permissao('montar_placa_RTqPCR') ||
            Sessao::getInstance()->verificar_permissao('analisar_RTqPCR')) {
            echo ' <li class="nav-item">
                        <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          RTQPCR
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';


        if (Sessao::getInstance()->verificar_permissao('solicitar_montagem_placa_RTqPCR')) {
            echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR') . '">Solicitação Montagem Placa RTqPCR</a>';
        }

        if (Sessao::getInstance()->verificar_permissao('mix_placa_RTqPCR')) {
            echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=mix_placa_RTqPCR') . '">Mix da Placa RTqPCR</a>';
        }

        if (Sessao::getInstance()->verificar_permissao('montar_placa_RTqPCR')) {
            echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_placa_RTqPCR') . '">Montagem da Placa RTqPCR</a>';
        }

        if (Sessao::getInstance()->verificar_permissao('analisar_RTqPCR')) {
            echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=analisar_RTqPCR') . '">Análise RTqPCR</a>';
        }

        echo '          </div>
                      </div>';
    }

        if (Sessao::getInstance()->verificar_permissao('cadastrar_diagnostico') ||
            Sessao::getInstance()->verificar_permissao('listar_laudo')) {
            echo ' <li class="nav-item">
                        <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          DIAGNÓSTICO E LAUDO
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';


            if (Sessao::getInstance()->verificar_permissao('cadastrar_diagnostico')) {
                echo ' <a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=cadastrar_diagnostico') . '">Cadastrar Diagnóstico</a>';
            }

            if (Sessao::getInstance()->verificar_permissao('listar_laudo')) {
                echo '<a class="nav-link" href="' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_laudo') . '">Ver Laudos</a>';
            }

            echo '          </div>
                     </div>';

        }
        echo '               <!--<li class="nav-item">
                            <a class="nav-link" href="#">Preparo e Armazenamento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Extração</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">RTPCR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Laudo</a>
                        </li>
                         <li class="nav-item divisor"></li> -->
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Usuário logado:  '.Sessao::getInstance()->getMatricula().'
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <a class="dropdown-item" href="'.Sessao::getInstance()->assinar_link('controlador.php?action=sair').'">Logoff</a>
                                </div>
                              </div>
                            
                            <!--<div class="dropdown">
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Usuário logado:  '.Sessao::getInstance()->getMatricula().'
                                </button>
                                 <div class="dropdown-menu">
                                  <a class="dropdown-item" href=>Logoff</a>
                                </div>
                              </div>-->
                          
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                  

          </header>';
    } 

    public static function abrir_head($titulo) {
        echo '<html>
                    <head>
                        <meta charset="utf-8">
                        <title>' . $titulo . '</title>
                        <link rel="icon" type="text/css" href="docs/img/coronavirus.png"><!--<i class="fas fa-virus"></i>-->
                        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                        
                         <script src="js/jquery.min.js"></script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                        <!-- Font Awesome --><!-- NÃO REMOVER SENÃO NÃO APARECEM OS ÍCONES -->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


                        <!--<script src="css/bootstrap-combined.min.css"></script>-->
                        
                        <!-- HTML5Shiv -->
                        <!--[if lt IE 9]>
                          <script src="js/html5shiv.min.js"></script>

                        <link rel="stylesheet" href="css/fontawesome.css">
                        <![endif]-->

                        <!-- Bootstrap CSS -->
                        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->

                        <!--<script src="js/jquery-3.3.1.slim.min.js"></script>-->
                       
                        <script src="js/popper.min.js"></script>
                        <script src="js/bootstrap.min.js"></script>

                        
                        
                        <!-- Bootstrap CSS -->
                        <link rel="stylesheet" href="css/bootstrap.min.css">

                        <!-- Latest compiled and minified CSS -->
                        <link rel="stylesheet" href="css/bootstrap-select.min.css">

                        <!-- Latest compiled and minified JavaScript -->
                        <script src="js/bootstrap-select.min.js"></script>

                        <!-- Latest compiled and minified JavaScript -->
                        <script src="js/datetime-copy-paste.js"></script>
                        
                        <script src="js/Chart.js"></script>
                       
                        <!-- Estilo customizado -->
                        <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
                        
                        <style>
                        
                       
                        
                        /* Barra de rolagem */
                        ::-webkit-scrollbar {width:9px;height:auto;background: #fff;border-bottom:none;}
                        ::-webkit-scrollbar-button:vertical {height:2px;display:block;} 
                        ::-webkit-scrollbar-thumb:vertical {background-color: #3a5261; -webkit-border-radius: 1px;}
                        ::-webkit-scrollbar-button:horizontal {height:2px;display:block;}
                        ::-webkit-scrollbar-thumb:horizontal {background-color: #3a5261; -webkit-border-radius: 1px;}
                         
                        .fas{
                            color:#3a5261;
                        }
                        .btn-primary{
                            background-color:#3a5261;
                            border:none;
                        }
                        
                        .btn-primary:hover{
                            background-color:#DBDFE2;
                            color: #3a5261;
                            transition: .5s;
                        }
                        
                        .btn-secondary{
                            background: none;
                            border-radius: 0px;
                            border: none;
                            color:#3a5261;
                        }
                        
                        .btn-secondary:hover,.btn-secondary:active{
                            border-bottom: 1px solid #3a5261;
                            background: none;
                            color:#3a5261;
                            /*color: white;
                            background-color:#3a5261;*/
                        }

                        
                       
                        html,body{
                                height: 100%;
                                
                                overflow-x: hidden; 
                                /*white-space: nowrap;*/
                        
                        }

                        /*body{
                                background: 
                                            linear-gradient(50deg,#dcdcdc, #fff);
                                background-attachment: fixed; 
                                font-family: Helvetica,Arial, sans-serif;
                        }*/
                         .divisor{
                                width: 1px;
                                margin: 12px 15px;
                                background: #3a5261;
                        }  

                        </style>
                        
                                                                     
                        <!-- google fonts -->
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">';
/*
                        if(isset($_GET['action']) && $_GET['action'] !=  'login') {
                            echo '<script type="text/javascript">
                                        //$( document ).ready(function() {
                                        //  alert( "ready!" );
                                        setInterval(verificarAmostras, 3000);
                                    //});
                            
                                    function verificarAmostras(){
                                        $.ajax({url: "' . Sessao::getInstance()->assinar_link('controlador.php?action=verificar_amostras') . '", success: function(result){
                                            //alert(result);
                                            if(result !== null){
                                                document.getElementById("idResultadoRTQPCR").classList.add("verificarAmostras");
                                                document.getElementById("idResultadoRTQPCR").innerHTML = "Finalização do RTqPCR <a href=\"' . Sessao::getInstance()->assinar_link("controlador.php?action=listar_analise_RTqPCR") . '\">aqui</a>" 
        
                                            }
                                            }});
                                    } 
                                </script>';
                        }*/
    }

    public  function fechar_head() {
        echo '</head>
                                         
                    <body>
                     <div id="idResultadoRTQPCR" class="">
                         
                       </div>
                    <!--<a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'" >-->
                         <img src="img/header.png" class="HeaderImg"></a>
                         
                         ';

    }

    public function mostrar_excecoes() {
        //print_r($this->array_validacoes);
        // $script = '';
        
        if (count($this->array_validacoes)) {
            //print_r($this->array_validacoes);
            //ECHO count($this->array_validacoes);
            $alert = '';
            //echo $this->array_validacoes[0][0];
            //$alert = Alert::alert_danger($this->array_validacoes[0][0]);
            
            //echo $alert;
            
           
            $msg = '';
            $campo = '';
            
            foreach ($this->array_validacoes as $validacao) {
                /* if($msg != ''){
                  $msg .= "\n";
                  } */
                $msg .= $validacao[0];
                $alert .= Alert::alert_msg($validacao[0],$validacao[2]);
                             

                /*if ($validacao[1] != null) {

                    echo 'var campo = document.getElementById("' . $validacao[1] . '");
                          
                          if(!campo.classList.contains("is-invalid")){
                            campo.classList.add("is-invalid");
                          }
                          campo.value="";
                          campo.classList.add("placeholder_colored");
                          campo.placeholder = "' . $msg . '";
                          
                            
                        ' . "\n";
                    die($msg);
                }*/
            }
              //echo '<script type="text/javascript">';
              //echo '$(\'#validacao\').html(\'<div style="background-color: blue;"> oi </div>\')';
              //echo '$(\'#validacao\').html(\'.$alert.')';
              //echo '</script>';
                //echo '<script type="text/javascript"> var div_feedback = document.getElementById("validacao");';
                //echo 'div_feedback.innerHTML ="'.$alert.'";</script>';
                echo $alert;
            //echo 'alert(\''.$msg.'\');';
            
        }
        //return $script;
    }

    public function fechar_corpo() {
        echo '     </body>
                </html>';
    }
    
    public static function formatar_html($strValor){
        return htmlentities($strValor,ENT_QUOTES);
    }
    
    public static function montar_topo_listar($titulo=null ,$link1 =null, $novo1= null,$link2= null,$novo2=null) {
        echo '<div class="topo_listar">
                <div class="row">
                    <div class="col-md-6" ><h3>'.$titulo.'</h3></div>
                    <div class="col-md-3" >';
                      if(Sessao::getInstance()->verificar_permissao($link1)){ //só aparece o botão de cadastro para alguns perfis
                          echo '<a class="btn btn-primary " 
                            style="width:108%;margin-left: 0px; border-left: 1px solid white;" 
                            href="' . Sessao::getInstance()->assinar_link('controlador.php?action='.$link1). '">'.$novo1.'</a> ';
                      }
                    echo '</div>
                    <div class="col-md-3">';
                      if(Sessao::getInstance()->verificar_permissao($link2)){ //só aparece o botão de cadastro para alguns perfis
                          echo '<a class="btn btn-primary" style="width:100%;border-left:1px solid white;" 
                            href="' . Sessao::getInstance()->assinar_link('controlador.php?action='.$link2). '">'.$novo2.'</a> ';
                      }
                    echo '</div>
                </div>
            </div>';
                
    }

    public static function montar_topo_pesquisar($input_1=null,$input_2=null) {
        echo '<div class="conteudo_grande" style="width:100%;margin-left: 5px;margin-top: -10px;">
                <form method="post" id="formPesquisa">
                    <div class="form-row">
                        <input type="hidden" id="hdnPagina" name="hdnPagina" value="1">
                        <div class="col-md-4" >
                              <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                                '.$input_1.'
                              </div>
                        </div>';
        //if(isset($_POST['sel_pesquisa_coluna']) || $aparecer) {
            echo '  <div class="col-md-4" >
                            ' . $input_2 . '
                        </div>
                        <div class="col-md-2" >
                            <input style="width: 100%;" type="submit" class="btn btn-outline-add" name="btn_pesquisar" value="PESQUISAR">
                        </div>
                        <div class="col-md-2" >
                            <input style="width: 100%;" type="button" class="btn btn-outline-add" onclick="window.location.href=window.location.href" name="btn_resetar" value="LIMPAR">
                        </div>';
       // }
        echo '              </div>';
          echo '        </form>
            </div>';
            


    }
}
