<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/ResultadoPCR_BD.php';
require_once __DIR__ . '/../../vendor/fpdf/fpdf.php';
class ResultadoPCR_RN
{

    public function configuraObjeto(ResultadoPCR $objResultado, $arrayLinha) {
        $objResultado->setWell($arrayLinha[0]);
        $objResultado->setSampleName($arrayLinha[1]);
        $objResultado->setTargetName($arrayLinha[2]);
        $objResultado->setTask($arrayLinha[3]);
        $objResultado->setReporter($arrayLinha[4]);
        $objResultado->setCt($arrayLinha[5]);
    }

    public function printObjeto(ResultadoPCR $obj) {
        echo "<br>";
        echo "Well ->" . $obj->getWell() . "<br>";
        echo "Sample Name ->" . $obj->getSampleName() . "<br>";
        echo "Target Name ->" . $obj->getTargetName() . "<br>";
        echo "Task ->" . $obj->getTask() . "<br>";
        echo "Reporter ->" . $obj->getReporter() . "<br>";
        echo "Ct ->" . $obj->getCt() . "<br>";
    }
    public function cadastrar(ResultadoPCR $resultadoPCR) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            /*Realizar validacoes*/

            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();
            $objResultadoPCR = $objResultadoPCR_BD->cadastrar($resultadoPCR,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objResultadoPCR;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento do resultado do PCR.', $e);
        }
    }

    public function alterar(ResultadoPCR $resultadoPCR) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            /*Realizar validacoes*/

            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();
            $objResultadoPCR = $objResultadoPCR_BD->alterar($resultadoPCR,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objResultadoPCR;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do resultado do PCR.', $e);
        }
    }

    public function consultar(ResultadoPCR $resultadoPCR) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();
            $arr =  $objResultadoPCR_BD->consultar($resultadoPCR,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do resultado do PCR.',$e);
        }
    }

    public function remover(ResultadoPCR $resultadoPCR) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();
            $arr =  $objResultadoPCR_BD->remover($resultadoPCR,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do resultado do PCR.', $e);
        }
    }

    public function listar(ResultadoPCR $resultadoPCR) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();

            $arr = $objResultadoPCR_BD->listar($resultadoPCR,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do resultado do PCR.',$e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try{

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objResultadoPCR_BD = new ResultadoPCR_BD();
            $arr = $objResultadoPCR_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na pesquisa do resultado do PCR.', $e);
        }
    }

}