<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do detentor do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LocalArmazenamentoBD.php';

class LocalArmazenamentoRN{


    private function validarNome(LocalArmazenamento $localArmazenamento,Excecao $objExcecao){
        $strNomeLocal = trim($localArmazenamento->getNome());

        if ($strNomeLocal == '') {
            $objExcecao->adicionar_validacao('O nome do local de armazenamento não foi informado','idLocalArmazenamento', 'alert-danger');
        }else{
            $objLocalArmazenamento = new LocalArmazenamento();
            $objLocalArmazenamentoRN = new LocalArmazenamentoRN();

            $arr_locais = $objLocalArmazenamentoRN->listar($objLocalArmazenamento);
            foreach ($arr_locais as $item) {
                if($item->getNome() == $localArmazenamento->getNome() && $item->getIdLocalArmazenamento() != $localArmazenamento->getIdLocalArmazenamento){
                    $objExcecao->adicionar_validacao('O nome do local já está sendo utilizado','idLocalArmazenamento', 'alert-danger');
                }
            }


        }

        return $localArmazenamento->setNome($strNomeLocal);

    }
    

    private function validarIdTipoLocal(LocalArmazenamento $localArmazenamento,Excecao $objExcecao){
        $numIdTipoLocal = $localArmazenamento->getIdTipoLocalArmazenamento_fk();

        if($numIdTipoLocal == null ){
            $objExcecao->adicionar_validacao('O tipo do  local de armazenamento não foi informado','idLocalArmazenamento', 'alert-danger');
        }

    }
     

    public function cadastrar(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarNome($localArmazenamento, $objExcecao);
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $localArmazenamentoAux = new LocalArmazenamento();
            $localArmazenamentoAux = $objLocalArmazenamentoBD->cadastrar($localArmazenamento,$objBanco);

            for($i=1; $i<=$localArmazenamento->getQntPortas();$i++){
                $objPorta = new Porta();
                $objPortaRN = new PortaRN();

                $objPorta->setNome("Porta ". $i. " do local ".$localArmazenamentoAux->getIdLocalArmazenamento());
                $objPorta->setSituacaoPorta(PortaRN::$TSP_COM_ESPACO_LIVRE);
                $objPorta->setIdLocalArmazenamentoFk($localArmazenamentoAux->getIdLocalArmazenamento());
                $objPorta = $objPortaRN->cadastrar($objPorta);
                for ($t =1; $t<= ($localArmazenamento->getQntPrateleiras()+1); $t++){
                    $objPrateleira = new Prateleira();
                    $objPrateleiraRN = new PrateleiraRN();

                    $objPrateleira->setNome("Espaço da prateleira ". $t." da porta ".$objPorta->getIdPorta());
                    $objPrateleira->setSituacaoPrateleira(PrateleiraRN::$TSR_COM_ESPACO_LIVRE);
                    $objPrateleira->setIdPorta_fk($objPorta->getIdPorta());
                    $objPrateleira = $objPrateleiraRN->cadastrar($objPrateleira);

                    for($c=1; $c<= ($localArmazenamento->getQntColunas()+1); $c++){
                        $objColuna = new Coluna();
                        $objColunaRN = new ColunaRN();

                        $objColuna->setNome("Espaço da coluna ". $c." da prateleira ".$objPrateleira->getIdPrateleira() ." da porta ".$objPorta->getIdPorta());
                        $objColuna->setSituacaoColuna(ColunaRN::$TSC_COM_ESPACO_LIVRE);
                        $objColuna->setIdPrateleira_fk($objPrateleira->getIdPrateleira());
                        $objColuna = $objColunaRN->cadastrar($objColuna);

                        for($x=1; $x<=$localArmazenamento->getQntCaixas(); $x++){
                            $objCaixa = new Caixa();
                            $objCaixaRN = new CaixaRN();

                            $objCaixa->setQntColunas($localArmazenamento->getQntColunasCaixa());
                            $objCaixa->setQntLinhas($localArmazenamento->getQntLinhasCaixa());
                            $objCaixa->setQntSlotsVazios(($localArmazenamento->getQntColunasCaixa()*$localArmazenamento->getQntLinhasCaixa()));
                            $objCaixa->setNome("Caixa ".$x ." da coluna ". $objColuna->getIdColuna()." da prateleira ".$objPrateleira->getIdPrateleira() ." da porta ".$objPorta->getIdPorta());
                            $objCaixa->setQntSlotsOcupados(0);
                            $objCaixa->setIdColuna_fk($objColuna->getIdColuna());
                            $objCaixa = $objCaixaRN->cadastrar($objCaixa);
                            for ($s = 1; $s<= $localArmazenamento->getQntColunasCaixa(); $s++){
                                for ($l = 1; $l<= $localArmazenamento->getQntLinhasCaixa(); $l++) {
                                    $objposicao = new Posicao();
                                    $objposicaoRN = new PosicaoRN();

                                    $objposicao->setLinha($l);
                                    $objposicao->setColuna($s);
                                    $objposicao->setIdCaixa_fk($objCaixa->getIdCaixa());
                                    $objposicao->setSituacaoPosicao(PosicaoRN::$TSP_LIBERADA);
                                    $objposicaoRN->cadastrar($objposicao);
                                }
                            }

                        }
                    }

                }

            }


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $localArmazenamento;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o local de armazenamento.', $e);
        }
    }

    public function alterar(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $objLocalArmazenamentoBD->alterar($localArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $localArmazenamento;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o local de armazenamento.', $e);
        }
    }

    public function consultar(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr =  $objLocalArmazenamentoBD->consultar($localArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
 
            throw new Excecao('Erro consultando o local de armazenamento.',$e);
        }
    }

    public function pegar_valores(LocalArmazenamento $localArmazenamento, $qntLugares) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr =  $objLocalArmazenamentoBD->pegar_valores($localArmazenamento,$qntLugares,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();

            throw new Excecao('Erro consultando o local de armazenamento.',$e);
        }
    }

    public function remover(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr =  $objLocalArmazenamentoBD->remover($localArmazenamento,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o local de armazenamento.', $e);
        }
    }

    public function listar(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            
            $arr = $objLocalArmazenamentoBD->listar($localArmazenamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o local de armazenamento.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr = $objLocalArmazenamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o local de armazenamento.', $e);
        }
    }


    public function existe(LocalArmazenamento $localArmazenamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoBD = new LocalArmazenamentoBD();
            $arr = $objLocalArmazenamentoBD->existe($localArmazenamento,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o local de armazenamento.', $e);
        }
    }

}

