<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do tipo da amostra
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/TipoLocalArmazenamentoBD.php';

require_once __DIR__ . '/../LocalArmazenamento/LocalArmazenamento.php';
require_once __DIR__ . '/../LocalArmazenamento/LocalArmazenamentoRN.php';

class TipoLocalArmazenamentoRN{

    public static $TL_BANCO_AMOSTRAS = 'B';
    public static $TL_GELADEIRA = 'G';
    public static $TL_FREEZER = 'F';
    public static $TL_APOS_EXTRACAO = 'P';

    public static function listarValoresTipoLocal(){
        try {

            $arrObjStaColuna = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_BANCO_AMOSTRAS);
            $objSituacao->setStrDescricao('Tipo banco de amostras');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_GELADEIRA);
            $objSituacao->setStrDescricao('Tipo geladeira');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_FREEZER);
            $objSituacao->setStrDescricao('Tipo freezer');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TL_APOS_EXTRACAO);
            $objSituacao->setStrDescricao('Tipo de armazenamento após extração');
            $arrObjStaColuna[] = $objSituacao;

            return $arrObjStaColuna;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo situação da posição da caixa',$e);
        }
    }

    public static function mostrarDescricaoTipo($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoLocal() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }

        //$objExcecao->adicionar_validacao('Não encontrou o tipo informadoo.','alert-danger');
    }

    private function validarStrTipoPosicao(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){

        if ($tipoLocalArmazenamento->getTipoLocal() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoLocal() as $tipo){
                if($tipo->getStrTipo() == $tipoLocalArmazenamento->getTipoLocal()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('O tipo do local de armazenamento não foi encontrado',null,'alert-danger');
            }
        }

    }


    private function validarTipo(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){
        $strTipo = trim($tipoLocalArmazenamento->getTipo());

        if ($strTipo == '') {
            $objExcecao->adicionar_validacao('O tipo do local de armazenamento não foi informado','idNomeColuna', 'alert-danger');
        }else{
            if (strlen($strTipo) > 100) {
                $objExcecao->adicionar_validacao('O tipo do local de armazenamento possui mais que 100 caracteres.','idNomeColuna', 'alert-danger');
            }
            $objTipoLocalArmazenamento = new TipoLocalArmazenamento();
            $objTipoLocalArmazenamentoRN = new TipoLocalArmazenamentoRN();

            $arr_locais = $objTipoLocalArmazenamentoRN->listar($objTipoLocalArmazenamento);

            foreach ($arr_locais as $item) {
                if($item->getIndexTipo() == $tipoLocalArmazenamento->getIndexTipo()
                    &&  $item->getIdTipoLocalArmazenamento() != $tipoLocalArmazenamento->getIdTipoLocalArmazenamento()){
                        $objExcecao->adicionar_validacao('O nome do local já está sendo utilizado','idLocalArmazenamento', 'alert-danger');
                }
            }
        }

        return $tipoLocalArmazenamento->setTipo($strTipo);

    }


    private function validarRemocao(TipoLocalArmazenamento $tipoLocalArmazenamento,Excecao $objExcecao){

            $objLocalArmazenamento = new LocalArmazenamento();
            $objLocalArmazenamentoRN = new LocalArmazenamentoRN();


            $objLocalArmazenamento->setIdTipoLocalArmazenamento_fk($tipoLocalArmazenamento->getIdTipoLocalArmazenamento());
            $arr = $objLocalArmazenamentoRN->existe($objLocalArmazenamento);

            //print_r($arr);
            if(count($arr) > 0){
                $objExcecao->adicionar_validacao('O tipo do local não pode ser excluído porque ele está associado a um local de armazenamento','idLocalArmazenamento', 'alert-danger');
            }

    }





    

    public function cadastrar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarTipo($tipoLocalArmazenamento,$objExcecao);

            
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $objTipoLocalArmazenamentoBD->cadastrar($tipoLocalArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $tipoLocalArmazenamento;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o tipo do local de armazenamento.', $e);
        }
    }

    public function alterar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarTipo($tipoLocalArmazenamento,$objExcecao);

            
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $objTipoLocalArmazenamentoBD->alterar($tipoLocalArmazenamento,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $tipoLocalArmazenamento;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o tipo do local de armazenamento.', $e);
        }
    }

    public function consultar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr =  $objTipoLocalArmazenamentoBD->consultar($tipoLocalArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
 
            throw new Excecao('Erro consultando o tipo do local de armazenamento.',$e);
        }
    }


    public function remover(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();

            $this->validarRemocao($tipoLocalArmazenamento,$objExcecao);
            $objExcecao->lancar_validacoes();

            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr =  $objTipoLocalArmazenamentoBD->remover($tipoLocalArmazenamento,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o tipo do local de armazenamento.', $e);
        }
    }

    public function listar(TipoLocalArmazenamento $tipoLocalArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            
            $arr = $objTipoLocalArmazenamentoBD->listar($tipoLocalArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o tipo do local de armazenamento.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objTipoLocalArmazenamentoBD = new TipoLocalArmazenamentoBD();
            $arr = $objTipoLocalArmazenamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o tipo do local de armazenamento.', $e);
        }
    }

}

