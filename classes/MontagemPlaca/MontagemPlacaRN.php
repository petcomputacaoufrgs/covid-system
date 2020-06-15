<?php
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MontagemPlacaBD.php';
require_once __DIR__ . '/../Situacao/Situacao.php';
class MontagemPlacaRN
{

    public static $STA_MONTAGEM_ANDAMENTO = 'A';
    public static $STA_MONTAGEM_FINALIZADA = 'F';

    public static function listarValoresStaMontagemPlaca(){
        try {

            $arrObjTEtapa = array();


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_MONTAGEM_ANDAMENTO);
            $objSituacao->setStrDescricao('EM ANDAMENTO');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$STA_MONTAGEM_FINALIZADA);
            $objSituacao->setStrDescricao('FINALIZADA');
            $arrObjTEtapa[] = $objSituacao;

            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Situação da montagem da placa',$e);
        }
    }

    public static function mostrar_descricao_staMontagemPlaca($situacaoMontagemPlaca){
        $arr = self::listarValoresStaMontagemPlaca();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoMontagemPlaca ){
                return $a->getStrDescricao();
            }
        }
    }


    private function validarIdUsuario(MontagemPlaca $objMontagemPlaca,Excecao $objExcecao){
        if($objMontagemPlaca->getIdUsuarioFk() == null){
            $objExcecao->adicionar_validacao('O identificador do usuário, responsável pela montagem da placa, não foi informado',null,'alert-danger');
        }
    }

    private function validarIdMix(MontagemPlaca $objMontagemPlaca,Excecao $objExcecao){
        if($objMontagemPlaca->getIdMixFk() == null){
            $objExcecao->adicionar_validacao('O identificador do mix, da montagem da placa, não foi informado',null,'alert-danger');
        }
    }

    private function validarIdMontagemPlaca(MontagemPlaca $objMontagemPlaca,Excecao $objExcecao){
        if($objMontagemPlaca->getIdMontagem() == null){
            $objExcecao->adicionar_validacao('O identificador da montagem da placa não foi informado',null,'alert-danger');
        }
    }

    private function validarSituacaoMontagem(MontagemPlaca $objMontagemPlaca,Excecao $objExcecao){
        if($objMontagemPlaca->getSituacaoMontagem() == null){
            $objExcecao->adicionar_validacao('A situação da montagem da placa não foi informada',null,'alert-danger');
        }else{
            if(self::mostrar_descricao_staMontagemPlaca($objMontagemPlaca->getSituacaoMontagem()) == null){
                $objExcecao->adicionar_validacao('A situação da montagem da placa informada é inválida',null,'alert-danger');
            }
        }
    }


    private function validar_existe_montagemPlaca(MontagemPlaca $objMontagemPlaca,Excecao $objExcecao){
        $objMontagemPlacaRN= new PlacaRN();
        $numMontagens = $objMontagemPlacaRN->listar($objMontagemPlaca,1);
        if(count($numMontagens) > 0 ){
            $objExcecao->adicionar_validacao('A montagem de placa informada já existe',null,'alert-danger');
        }
    }

    public function cadastrar(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdUsuario($objMontagemPlaca,$objExcecao);
            $this->validarIdMix($objMontagemPlaca,$objExcecao);
            $this->validarSituacaoMontagem($objMontagemPlaca,$objExcecao);
            $objExcecao->lancar_validacoes();


            if($objMontagemPlaca->getObjInfosTubo() != null){
                if(is_array($objMontagemPlaca->getObjInfosTubo())){
                    foreach ($objMontagemPlaca->getObjInfosTubo() as $infoTubo){
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTuboRN->cadastrar($infoTubo);
                    }
                }
            }

            if($objMontagemPlaca->getObjMix() !=null){
                $objMixRN = new MixRTqPCR_RN();
                $objMixRN->alterar($objMontagemPlaca->getObjMix());
                if($objMontagemPlaca->getObjMix()->getObjPlaca() !=null){
                    $objPlacaRN = new PlacaRN();
                    $objPlacaRN->alterar($objMontagemPlaca->getObjMix()->getObjPlaca());
                }
            }


            $objMontagemPlacaBD = new MontagemPlacaBD();
            $montagemPlaca  = $objMontagemPlacaBD->cadastrar($objMontagemPlaca,$objBanco);



            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $montagemPlaca;
        } catch (Throwable $e) {

            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a montagem da placa.', $e);
        }
    }

    public function alterar(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarIdUsuario($objMontagemPlaca,$objExcecao);
            $this->validarIdMix($objMontagemPlaca,$objExcecao);
            $this->validarIdMontagemPlaca($objMontagemPlaca,$objExcecao);
            $this->validarSituacaoMontagem($objMontagemPlaca,$objExcecao);
            $objExcecao->lancar_validacoes();

            if($objMontagemPlaca->getObjPocos() != null){

                $objTubo = new Tubo;
                $objTuboRN = new TuboRN();
                $objInfosTuboRN = new InfosTuboRN();
                $objPocoRN = new PocoRN();
                if(is_array($objMontagemPlaca->getObjPocos())){
                    foreach ($objMontagemPlaca->getObjPocos() as $poco){
                        $infosTubo = $poco->getObjTubo()->getObjInfosTubo();
                        $objTubo = $objTuboRN->cadastrar($poco->getObjTubo());
                        $poco->setIdTuboFk($objTubo->getIdTubo());
                        //$infosTubo->setIdTuboFk($objTubo->getIdTubo());
                        $objPoco = $objPocoRN->alterar($poco);
                        //$objInfosTuboRN->cadastrar($infosTubo);
                    }
                }

            }


            if($objMontagemPlaca->getObjInfosTubo() != null){
                if(is_array($objMontagemPlaca->getObjInfosTubo())){
                    $contador = 0;
                    foreach ($objMontagemPlaca->getObjInfosTubo() as $infoTubo){
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTuboRN->cadastrar($infoTubo);
                    }
                }
            }

            if($objMontagemPlaca->getObjMix() != null){
                $objMixRN = new MixRTqPCR_RN();
                $objMixRN->alterar($objMontagemPlaca->getObjMix());
                if($objMontagemPlaca->getObjMix()->getObjPlaca() !=null){
                    $objPlacaRN = new PlacaRN();
                    $objPlacaRN->alterar($objMontagemPlaca->getObjMix()->getObjPlaca());
                }
            }


            $objMontagemPlacaBD = new MontagemPlacaBD();
            $montagemPlaca = $objMontagemPlacaBD->alterar($objMontagemPlaca,$objBanco);



            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $montagemPlaca;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando a montagem da placa.', $e);
        }
    }

    public function consultar(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMontagemPlacaBD = new MontagemPlacaBD();
            $arr =  $objMontagemPlacaBD->consultar($objMontagemPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando a montagem da placa.',$e);
        }
    }

    public function remover(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMontagemPlacaBD = new MontagemPlacaBD();

            if($objMontagemPlaca->getObjMix() != null){
                $objMixRN = new MixRTqPCR_RN();
                $objMixRN->alterar($objMontagemPlaca->getObjMix());
                if($objMontagemPlaca->getObjMix()->getObjPlaca() !=null){
                    $objPlacaRN = new PlacaRN();
                    $objPlacaRN->alterar($objMontagemPlaca->getObjMix()->getObjPlaca());
                }
            }

            if($objMontagemPlaca->getObjInfosTubo() != null){
                if(is_array($objMontagemPlaca->getObjInfosTubo())){
                    foreach ($objMontagemPlaca->getObjInfosTubo() as $infoTubo){
                        $objInfosTuboRN = new InfosTuboRN();
                        $objInfosTuboRN->cadastrar($infoTubo);
                    }
                }
            }

            //$this->validar_existe_RTqPCR_com_a_placa($objMontagemPlaca, $objExcecao);

            if($objMontagemPlaca->getSituacaoMontagem() != MontagemPlacaRN::$STA_MONTAGEM_FINALIZADA) {
                $arr = $objMontagemPlacaBD->remover($objMontagemPlaca, $objBanco);
            }else{
                $objExcecao->adicionar_validacao("A montagem da placa RTqPCR já foi finalizada, logo não pode ser removida");
            }
            $objExcecao->lancar_validacoes();
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo a montagem da placa.', $e);
        }
    }


    public function listar(MontagemPlaca $objMontagemPlaca,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMontagemPlacaBD = new MontagemPlacaBD();

            $arr = $objMontagemPlacaBD->listar($objMontagemPlaca,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a montagem da placa.',$e);
        }
    }

    /**** EXTRAS ****/
    public function paginacao(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMontagemPlacaBD = new MontagemPlacaBD();

            $arr = $objMontagemPlacaBD->paginacao($objMontagemPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando a montagem da placa.',$e);
        }
    }

    public function ja_existe_placa(MontagemPlaca $objMontagemPlaca) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objMontagemPlacaBD = new MontagemPlacaBD();

            $arr = $objMontagemPlacaBD->ja_existe_placa($objMontagemPlaca,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se já existe a montagem da placa.',$e);
        }
    }


}