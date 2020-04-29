<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ColunaBD.php';

class ColunaRN{

    public static $TSC_COM_ESPACO_LIVRE = 'C';
    public static $TSC_SEM_ESPACO_LIVRE = 'S';

    public static function listarValoresTipoEstado(){
        try {

            $arrObjStaColuna = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSC_COM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Coluna com espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSC_SEM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Coluna sem espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            return $arrObjStaColuna;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo situação da coluna',$e);
        }
    }

    public static function mostrarDescricaoTipo($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoEstado() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }

        //$objExcecao->adicionar_validacao('Não encontrou o tipo informadoo.','alert-danger');
    }

    private function validarStrTipoColuna(Coluna $coluna,Excecao $objExcecao){

        if ($coluna->getSituacaoColuna() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoEstado() as $tipo){
                if($tipo->getStrTipo() == $coluna->getSituacaoColuna()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('Situação da coluna não foi encontrada',null,'alert-danger');
            }
        }

    }


    private function validarNome(Coluna $coluna,Excecao $objExcecao){
        $strNome = trim($coluna->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da coluna não foi informado','idNomeColuna', 'alert-danger');
        }else{
            if (strlen($strNome) > 100) {
                $objExcecao->adicionar_validacao('O nome da coluna possui mais que 100 caracteres.','idNomeColuna', 'alert-danger');
            }
        }
        
        return $coluna->setNome($strNome);

    }

    public function cadastrar(Coluna $coluna) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            /*REALIZAR VALIDACOES*/ 
            $this->validarNome($coluna,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            $objColunaBD->cadastrar($coluna,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $coluna;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a coluna.', $e);
        }
    }

    public function alterar(Coluna $coluna) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           
           /*REALZIAR VALIDACOES*/
            $this->validarNome($coluna,$objExcecao);

           $objExcecao->lancar_validacoes();
           $objColunaBD = new ColunaBD();
           $objColunaBD->alterar($coluna,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $coluna;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro alterando a coluna.', $e);
       }
   }

   public function consultar(Coluna $coluna) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            $arr =  $objColunaBD->consultar($coluna,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a coluna.',$e);
        }
    }

    public function remover(Coluna $coluna) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           $objExcecao->lancar_validacoes();
           $objColunaBD = new ColunaBD();
           $arr =  $objColunaBD->remover($coluna,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro removendo a coluna.', $e);
       }
   }

   public function listar(Coluna $coluna) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objColunaBD = new ColunaBD();
            
            $arr = $objColunaBD->listar($coluna,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a coluna.',$e);
        }
    }
}
    
    