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
    
    
    
    public static function alert_error_cadastrar_editar(){
        return '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="alert_id" >
                <strong>Opa!</strong> Os dados foram já haviam sido cadastrados anteriormente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
             ';
    }
    
        
    public static function alert_success_cadastrar(){
        return '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> Os dados foram CADASTRADOS com sucesso.
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
    
     



}