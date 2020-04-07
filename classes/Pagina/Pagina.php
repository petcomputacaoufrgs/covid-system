<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

class Pagina{
    
    private $array_validacoes;
    
    function __construct() {
        $this->array_validacoes = array();
    }
    public function processar_excecao(Exception $e){
        if($e instanceof Excecao && $e->possui_validacoes()){
            $this->array_validacoes = $e->get_validacoes();
            
        }else{

            die('pagina->processarexcecao '.$e);
        }
    }
    
    public function montar_menu_topo(){
        echo '<a href="controlador.php?action=tela_inicial">TELA INICIAL</a>';
    }
    
    public static function abrir_head($titulo) {
        echo '<html>
                    <head>
                        <meta charset="utf-8">
                        <title>'.$titulo.'</title>
                        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                        <!-- Bootstrap CSS -->
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
                        

                        
                        <!-- Font Awesome -->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

                        <!-- HTML5Shiv -->
                        <!--[if lt IE 9]>
                          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                        <![endif]-->

                        <!-- Estilo customizado -->
                        <link rel="stylesheet" type="text/css" href="##">
                        
                        <!-- google fonts -->
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">'
                        
                    ;
        
    }
    
    public static function fechar_head(){
        echo    '</head>
                    <body>';
    }
     public function mostrar_excecoes(){
         //print_r($this->array_validacoes);
        // $script = '';
        if(count($this->array_validacoes)){
           
            echo '<script>';
            $msg = '';
            $campo = '';
            
            foreach ($this->array_validacoes as $validacao){
                /*if($msg != ''){
                    $msg .= "\n";
                }*/
                $msg .= $validacao[0];
                
                if($validacao[1] !=  null){
                    
                    echo 'var campo = document.getElementById("'.$validacao[1].'");
                          
                          if(!campo.classList.contains("is-invalid")){
                            campo.classList.add("is-invalid");
                          }
                          campo.value="";
                          campo.classList.add("placeholder_colored");
                          campo.placeholder = "'.$msg.'";
                          
                            
                        '."\n";
                }
            }
            //echo 'alert(\''.$msg.'\');';
            echo '</script>';
            
        }
        //return $script;
     }
    
     public function fechar_corpo(){
          echo '     </body>
                </html>';
    }
    
    
    
    
}