<?php
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/PosicaoBD.php';

class PosicaoRN
{
    public static $TSP_LIBERADA = 'C';
    public static $TSP_OCUPADA = 'S';

    public static function listarValoresTipoEstado(){
        try {

            $arrObjStaColuna = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_LIBERADA);
            $objSituacao->setStrDescricao('Posição na caixa liberada');
            $arrObjStaColuna[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_OCUPADA);
            $objSituacao->setStrDescricao('Posição na caixa ocupada');
            $arrObjStaColuna[] = $objSituacao;

            return $arrObjStaColuna;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo situação da posição da caixa',$e);
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

    private function validarStrTipoPosicao(Posicao $Posicao,Excecao $objExcecao){

        if ($Posicao->getSituacaoPosicao() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoEstado() as $tipo){
                if($tipo->getStrTipo() == $Posicao->getSituacaoPosicao()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('Situação da posição da caixa não foi encontrada',null,'alert-danger');
            }
        }

    }



    public function cadastrar(Posicao $Posicao) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objPosicaoBD = new PosicaoBD();
            $objPosicaoBD->cadastrar($Posicao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $Posicao;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a posição da caixa.', $e);
        }
    }

    public function alterar(Posicao $Posicao) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();



            $objExcecao->lancar_validacoes();
            $objPosicaoBD = new PosicaoBD();
            $objPosicaoBD->alterar($Posicao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $Posicao;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a posição da caixa.', $e);
        }
    }

    public function consultar(Posicao $Posicao) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPosicaoBD = new PosicaoBD();
            $arr =  $objPosicaoBD->consultar($Posicao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a posição da caixa.',$e);
        }
    }

    public function remover(Posicao $Posicao) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPosicaoBD = new PosicaoBD();
            $arr =  $objPosicaoBD->remover($Posicao,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a posição da caixa.', $e);
        }
    }

    public function listar(Posicao $Posicao) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objPosicaoBD = new PosicaoBD();

            $arr = $objPosicaoBD->listar($Posicao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a posição da caixa.',$e);
        }
    }

    public function bloquear_registro(Posicao $Posicao,Tubo $tubo, LocalArmazenamento $local) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            //$this->validarUnicoTubo($Posicao, $tubo, $objExcecao);
            $objExcecao->lancar_validacoes();

            $objPosicaoBD = new PosicaoBD();


            $arr = $objPosicaoBD->bloquear_registro($Posicao,$local,$objBanco);
            if(empty($arr)){
                return $arr;
            }
            $flag_encontrou = false;
            $objCaixa = new Caixa();
            $objCaixaRN = new CaixaRN();
            $objCaixa->setIdCaixa($arr[0]->getIdCaixa_fk());
            $objCaixa = $objCaixaRN->consultar($objCaixa);
            $objPosicao = new Posicao();
            $objPosicaoRN = new PosicaoRN();
            for($i=1; $i<=$objCaixa->getQntLinhas(); $i++){
                for($j=1; $j<=$objCaixa->getQntColunas(); $j++){
                    $objPosicao->setLinha($i);
                    $objPosicao->setColuna($j);
                    $objPosicao->setIdTuboFk($tubo->getIdTubo());
                    if(count($objPosicaoRN->listar($objPosicao)) > 0){
                        $flag_encontrou = true;
                        $i =$objCaixa->getQntLinhas();
                        $j =$objCaixa->getQntColunas();
                        //$objExcecao->adicionar_validacao('Tubo já se encontra na caixa da posição da caixa não foi encontrada',null,'alert-danger');
                    }
                }
            }

            $objPosicao = new Posicao();
            if(!$flag_encontrou) {

                $objPosicao->setIdPosicaoCaixa($arr[0]->getIdPosicaoCaixa());
                $objPosicao->setIdCaixa_fk($arr[0]->getIdCaixa_fk());
                $objPosicao->setColuna($arr[0]->getColuna());
                $objPosicao->setSituacaoPosicao(PosicaoRN::$TSP_OCUPADA);
                $objPosicao->setLinha($arr[0]->getLinha());
                $objPosicao->setIdTuboFk($tubo->getIdTubo());

                $posicaoRN = new PosicaoRN();
                $posicaoRN->alterar($objPosicao);
                $objBanco->confirmarTransacao();
                $objBanco->fecharConexao();
                return $objPosicao;
            }

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return null;
        } catch (Exception $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro bloqueando a capela.',$e);
        }
    }


}