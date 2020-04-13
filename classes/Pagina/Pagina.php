<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once '../classes/Sessao/Sessao.php';

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
    
    public function processar_excecao(Exception $e) {
        if ($e instanceof Excecao && $e->possui_validacoes()) {
            $this->array_validacoes = $e->get_validacoes();
        } else {

            die('pagina->processarexcecao ' . $e);
        }
    }

    public function montar_menu_topo() {
        //echo '<a href="controlador.php?action=tela_inicial">TELA INICIAL</a>';
        echo'<hearder >
            <a href="'.Sessao::getInstance()->assinar_link('controlador.php?action=principal').'" ></a>
            
           <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
                <a class="navbar-brand" href="controlador.php?action=tela_inicial">COVID19<i class="fas fa-virus"></i></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarsExample11">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Cadastro Amostra</a>
                        </li>
                        <li class="nav-item">
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
                         <li class="nav-item divisor"></li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Usuário logado:  '.Sessao::getInstance()->getMatricula().'</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                  

          </hearder>';
    }

    

    public  function abrir_head($titulo) {
        echo '<html>
                    <head>
                        <meta charset="utf-8">
                        <title>' . $titulo . '</title>
                        <link rel="icon" type="text/css" href="docs/img/coronavirus.png"><!--<i class="fas fa-virus"></i>-->
                        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                        <!-- Font Awesome -->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

                        <!-- HTML5Shiv -->
                        <!--[if lt IE 9]>
                          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                        <![endif]-->
                        <!-- Bootstrap CSS -->
                        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
                        
                        <!-- Bootstrap CSS -->
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

                            <!-- Latest compiled and minified CSS -->
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
                         <!-- Optional JavaScript -->
                            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

                            <!-- Latest compiled and minified JavaScript -->
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

                                <!-- (Optional) Latest compiled and minified JavaScript translation files -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>

                        

                        <!-- Estilo customizado -->
                        <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
                        
                        <style>
                        /* Barra de rolagem */
                        ::-webkit-scrollbar {width:9px;height:auto;background: #fff;border-bottom:none;}
                        ::-webkit-scrollbar-button:vertical {height:2px;display:block;} 
                        ::-webkit-scrollbar-thumb:vertical {background-color: #3a5261; -webkit-border-radius: 1px;}
                         
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
                        

                        
                       
                        html,body{
                                height: 100%;
                                overflow-x: hidden;
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
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">'

        ;
    }

    public  function fechar_head() {
        echo "</head>
                    
                     <a href=\"controlador.php?action=tela_inicial\"><img src=\"img/header.png\" class=\"HeaderImg\"></a>
                      
                    <body>";

    }

    public function mostrar_excecoes() {
        //print_r($this->array_validacoes);
        // $script = '';
        if (count($this->array_validacoes)) {

            echo '<script>';
            $msg = '';
            $campo = '';

            foreach ($this->array_validacoes as $validacao) {
                /* if($msg != ''){
                  $msg .= "\n";
                  } */
                $msg .= $validacao[0];

                if ($validacao[1] != null) {

                    echo 'var campo = document.getElementById("' . $validacao[1] . '");
                          
                          if(!campo.classList.contains("is-invalid")){
                            campo.classList.add("is-invalid");
                          }
                          campo.value="";
                          campo.classList.add("placeholder_colored");
                          campo.placeholder = "' . $msg . '";
                          
                            
                        ' . "\n";
                }
            }
            //echo 'alert(\''.$msg.'\');';
            echo '</script>';
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
    
    public static function montar_topo_listar($titulo,$link,$novo) {
        echo '<div class="topo_listar">
                <div class="row">
                    <div class="col-md-9"><h3>'.$titulo.'</h3></div>
                    <div class="col-md-3">';
                      if(Sessao::getInstance()->verificar_permissao($link)){ //só aparece o botão de cadastro para alguns perfis
                          echo '<a class="btn btn-primary " 
                            href="' . Sessao::getInstance()->assinar_link('controlador.php?action='.$link). '">'.$novo.'</a> ';
                      }
                    echo '</div>
                </div>
            </div>';
                
    }
}
