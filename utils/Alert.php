<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class Alert{
   
    private static $instance;
    
    public static  function getInstance(){
        if(self::$instance == null){
            self::$instance= new Alert();
        }
        return self::$instance;
    }
    
    public static function alert_msg($mensagem,$tipoAlert){
        $strong = '';
        if($tipoAlert == 'alert-primary'){
            $strong = 'Aviso!';
        }
        if($tipoAlert == 'alert-danger'){
            $strong = 'Erro!';
        }
        if($tipoAlert == 'alert-success'){
            $strong = 'Sucesso!';
        }
        return '<div class="alert '. $tipoAlert .' alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>'.$strong.'</strong> '.$mensagem.'.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
    
    public static function alert_primary($mensagem){
        return '<div class="alert alert-primary alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Aviso!</strong> '.$mensagem.'.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
    public static function alert_danger($mensagem){
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Erro!</strong> '.$mensagem.'.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
    public static function alert_warning($mensagem){
        return '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Opa!</strong> '.$mensagem.'.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
        
    public static function alert_success($mensagem){
        return '<div class="alert alert-success alert-dismissible fade show" role="alert" >
                <strong>Sucesso!</strong> '.$mensagem.'.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    
    public static function alert_success_editar(){
        return '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> Os dados foram ALTERADOS com sucesso.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    
    
    public static function alert_error_semCapelaDisponivel(){
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!</strong> Nenhuma capela está disponível.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    
    public static function alert_success_capelaDisponivel(){
        return '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> Há capelas disponíveis.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    
    
     public static function alert_error_encontrar_paciente($campoProcurado){
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Ops!</strong> Nenhum paciente foi encontrado com esse campo ('.$campoProcurado.').
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
    public static function alert_success_encontrar_paciente($campoProcurado){
        return '<div class="alert alert-success alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Sucesso!</strong> Foi encontrado paciente com esse campo ('.$campoProcurado.').
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
     



}