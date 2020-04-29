<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PortaBD.php';

class PortaRN{

    public static $TSP_COM_ESPACO_LIVRE = 'C';
    public static $TSP_SEM_ESPACO_LIVRE = 'S';

    public static function listarValoresTipoEstado(){
        try {

            $arrObjStaColuna = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_COM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Porta com espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_SEM_ESPACO_LIVRE);
            $objSituacao->setStrDescricao('Porta sem espaço livre');
            $arrObjStaColuna[] = $objSituacao;

            return $arrObjStaColuna;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo situação da porta',$e);
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

    private function validarStrTipoPorta(Porta $porta,Excecao $objExcecao){

        if ($porta->getSituacaoPorta() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoEstado() as $tipo){
                if($tipo->getStrTipo() == $porta->getSituacaoPorta()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('Situação da porta não foi encontrada',null,'alert-danger');
            }
        }

    }

    private function validarNome(Porta $porta,Excecao $objExcecao){
        $strNome = trim($porta->getNome());
        
        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O nome da porta não foi informado','idNomePorta', 'alert-danger');
        }else{
            if (strlen($strNome) > 50) {
                $objExcecao->adicionar_validacao('O nome da porta possui mais que 50 caracteres.','idNomePorta', 'alert-danger');
            }
        }
        
        return $porta->setNome($strNome);
    }

    public function cadastrar(Porta $porta) {
        $objBanco = new Banco();
        try {
            
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            /*REALIZAR VALIDACOES*/
            $this->validarNome($porta,$objExcecao);



            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            $objPortaBD->cadastrar($porta,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $porta;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a porta.', $e);
        }
    }

    public function alterar(Porta $porta) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           
           /*REALZIAR VALIDACOES*/
            $this->validarNome($porta,$objExcecao);

           $objExcecao->lancar_validacoes();
           $objPortaBD = new PortaBD();
           $objPortaBD->alterar($porta,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $porta;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro alterando a porta.', $e);
       }
   }

   public function consultar(Porta $porta) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            $arr =  $objPortaBD->consultar($porta,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a porta.',$e);
        }
    }

    public function remover(Porta $porta) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
           $objExcecao->lancar_validacoes();
           $objPortaBD = new PortaBD();
           $arr =  $objPortaBD->remover($porta,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
           throw new Excecao('Erro removendo a porta.', $e);
       }
   }

   public function listar(Porta $porta) {
       $objBanco = new Banco();
       try {

           $objExcecao = new Excecao();
           $objBanco->abrirConexao();
           $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPortaBD = new PortaBD();
            
            $arr = $objPortaBD->listar($porta,$objBanco);

           $objBanco->confirmarTransacao();
           $objBanco->fecharConexao();
           return $arr;
       } catch (Throwable $e) {
           $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a porta.',$e);
        }
    }
}