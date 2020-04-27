<?php 
/*********************************************
 *  Classe das regras de negócio dos tubos   *
 *********************************************/

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/TuboBD.php'; 

class TuboRN{


    private function validarTuboOriginal(Tubo $tubo, Excecao $objExcecao){
        $boolTuboOriginal = $tubo->getTuboOriginal();

        if($boolTuboOriginal == null){
            $objExcecao->adicionar_validacao('A originalidade do tubo precisa ser informada', 'idTuboOriginal');
        }
        return $tubo->setTuboOriginal($boolTuboOriginal);
    }

    public function cadastrar(Tubo $tubo){
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarTuboOriginal($tubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $objTuboBD->cadastrar($tubo,$objBanco);

            if($tubo->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if($tubo->getObjInfosTubo()->getIdInfosTubo() == null) { // info tubo é novo
                    $objInfosTubo = $tubo->getObjInfosTubo();
                    $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());

                    $objInfosTuboRN->cadastrar($objInfosTubo);
                }else{
                    $objInfosTuboRN->alterar($tubo->getObjInfosTubo());
                }

            }
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
        }catch(Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do tubo.', $e);
        }
    }

    public function alterar(Tubo $tubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            
            $this->validarTuboOriginal($tubo, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $objTuboBD->alterar($tubo,$objBanco);

            if($tubo->getObjInfosTubo() != null){
                $objInfosTuboRN = new InfosTuboRN();
                if($tubo->getObjInfosTubo()->getIdInfosTubo() == null) { // info tubo é novo
                    $objInfosTubo = $tubo->getObjInfosTubo();
                    $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());

                    $objInfosTuboRN->cadastrar($objInfosTubo);
                }else{
                    $objInfosTuboRN->alterar($tubo->getObjInfosTubo());
                }

            }
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do tubo.', $e);
        }
    }

    public function consultar(Tubo $tubo){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr =  $objTuboBD->consultar($tubo,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do tubo.', $e);
        }
    }

    public function remover(Tubo $tubo){
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            $objInfosTubo = new InfosTubo();
            $objInfosTuboRN = new InfosTuboRN();

            $objInfosTubo->setIdTubo_fk($tubo->getIdTubo());
            $arr_infos = $objInfosTuboRN->listar($objInfosTubo);
            foreach ($arr_infos as $info){
                $objInfosTuboRN->remover($info);
            }

            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr =  $objTuboBD->remover($tubo,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do tubo.', $e);
        }
    }

    public function listar(Tubo $tubo){
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            
            $arr = $objTuboBD->listar($tubo,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do tubo.',$e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            $objBanco->abrirTransacao();
            
            $objExcecao->lancar_validacoes();
            $objTuboBD = new TuboBD();
            $arr = $objTuboBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na pesquisa do tubo.', $e);
        }
    }
}