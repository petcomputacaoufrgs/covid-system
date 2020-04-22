<?php

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/RTPCR_BD.php';

class RTPCR_RN
{

    public function configuraObjeto(RTPCR $objRTPCR, $arrayLinha)
    {
        $objRTPCR->setWell($arrayLinha[0]);
        $objRTPCR->setSampleName($arrayLinha[1]);
        $objRTPCR->setTargetName($arrayLinha[2]);
        $objRTPCR->setTask($arrayLinha[3]);
        $objRTPCR->setReporter($arrayLinha[4]);
        $objRTPCR->setQuencher($arrayLinha[5]);
        $objRTPCR->setCt($arrayLinha[6]);
    }

    public function printObjeto(RTPCR $obj)
    {
        echo "<br>";
        echo "Well ->" . $obj->getWell() . "<br>";
        echo "Sample Name ->" . $obj->getSampleName() . "<br>";
        echo "Target Name ->" . $obj->getTargetName() . "<br>";
        echo "Task ->" . $obj->getTask() . "<br>";
        echo "Reporter ->" . $obj->getReporter() . "<br>";
        echo "Quencer ->" . $obj->getQuencher() . "<br>";
        echo "Ct ->" . $obj->getCt() . "<br>";
    }

    public function cadastrar(RTPCR $rtpcr)
    {
        try {

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            /*Realizar validacoes*/

            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();
            $objRTPCR_BD->cadastrar($rtpcr, $objBanco);

            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro no cadastramento do RTPCR.', $e);
        }
    }

    public function alterar(RTPCR $rtpcr)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            /*Realizar validacoes*/

            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();
            $objRTPCR_BD->alterar($rtpcr, $objBanco);

            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro na alteração do RTPCR.', $e);
        }
    }

    public function consultar(RTPCR $rtpcr)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();
            $arr = $objRTPCR_BD->consultar($rtpcr, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {

            throw new Excecao('Erro na consulta do RTPCR.', $e);
        }
    }

    public function remover(RTPCR $rtpcr)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();
            $arr = $objRTPCR_BD->remover($rtpcr, $objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro na remoção do RTPCR.', $e);
        }
    }

    public function listar(RTPCR $rtpcr)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();

            $arr = $objRTPCR_BD->listar($rtpcr, $objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro na listagem do RTPCR.', $e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario)
    {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objRTPCR_BD = new RTPCR_BD();
            $arr = $objRTPCR_BD->pesquisar($campoBD, $valor_usuario, $objBanco);
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro na pesquisa do RTPCR.', $e);
        }
    }

}
