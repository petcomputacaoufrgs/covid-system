<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/KitExtracaoBD.php';

class KitExtracaoRN
{
    private function validarNome(KitExtracao $kitExtracao,Excecao $objExcecao){
        $strNome = trim($kitExtracao->getNome());

        if ($strNome == '') {
            $objExcecao->adicionar_validacao('O kit de extração não foi informado','idDetentor','alert-danger');
        }else{
            if (strlen($strNome) > 300) {
                $objExcecao->adicionar_validacao('O kit de extração possui mais que 300 caracteres.','idDetentor','alert-danger');
            }

        }

        return $kitExtracao->setNome($strNome);

    }

    private function validarIndexNome(KitExtracao $kitExtracao,Excecao $objExcecao){
        $strIndexNome = trim($kitExtracao->getIndexNome());


        $kitExtracaoRN = new KitExtracaoRN();
        $array_kits = $kitExtracaoRN->listar($kitExtracao);
        //print_r($array_sexos);
        foreach ($array_kits as $k){
            if($k->getIndexNome() == $strIndexNome){
                //$objExcecao->adicionar_validacao('O detentor já existe.','idDetentor');
                return false;
            }
        }

        return true;

    }

    private function validarRemocao(KitExtracao $kitExtracao,Excecao $objExcecao){

        /*
         *  SE NÃO TIVER SENDO UTILIZADO EM NENHUM GRUPO DE EXTRAÇÃO
         */


    }



    public function cadastrar(KitExtracao $kitExtracao) {
        try {

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objKitExtracaoBD = new KitExtracaoBD();

            $this->validarNome($kitExtracao,$objExcecao);

            $objExcecao->lancar_validacoes();
            $kitExtracao = $objKitExtracaoBD->cadastrar($kitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $kitExtracao;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o detentor.', $e);
        }
    }

    public function alterar(KitExtracao $kitExtracao) {
        try {

            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            $this->validarDetentor($kitExtracao,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objKitExtracaoBD = new KitExtracaoBD();
            $kitExtracao = $objKitExtracaoBD->alterar($kitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $kitExtracao;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o detentor.', $e);
        }
    }

    public function consultar(KitExtracao $kitExtracao) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objKitExtracaoBD = new KitExtracaoBD();
            $arr =  $objKitExtracaoBD->consultar($kitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o detentor.',$e);
        }
    }

    public function remover(KitExtracao $kitExtracao) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

            //$this->validarRemocao($kitExtracao,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objKitExtracaoBD = new KitExtracaoBD();
            $arr =  $objKitExtracaoBD->remover($kitExtracao,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o detentor.', $e);
        }
    }

    public function listar(KitExtracao $kitExtracao) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objKitExtracaoBD = new KitExtracaoBD();

            $arr = $objKitExtracaoBD->listar($kitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o detentor.',$e);
        }
    }


    public function pesquisar_index(KitExtracao $kitExtracao) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objKitExtracaoBD = new KitExtracaoBD();
            $arr = $objKitExtracaoBD->pesquisar_index($kitExtracao,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o detentor.', $e);
        }
    }

}