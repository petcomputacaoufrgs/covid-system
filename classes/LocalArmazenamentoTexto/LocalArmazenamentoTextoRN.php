<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/LocalArmazenamentoTextoBD.php';

class LocalArmazenamentoTextoRN
{
    //tipo etapa
    public static $TP_RECEPCAO = 'R';
    public static $TP_MONTAGEM_GRUPOS_AMOSTRAS = 'G';
    public static $TP_PREPARACAO_INATIVACAO = 'I';
    public static $TP_EXTRACAO = 'E';
    public static $TP_ARMAZENAMENTO_EXTRACAO = 'M';
    // ...
    public static $TP_LAUDO = 'L';

    //tipo situacao etapa
    public static $TSP_INICIALIZADO = 'I';
    public static $TSP_AGUARDANDO = 'U';
    public static $TSP_EM_ANDAMENTO = 'N';
    public static $TSP_FINALIZADO = 'F';


    //tipo situação tubo
    public static $TST_TRANSPORTE_PREPARACAO = 'T';
    public static $TST_SEM_UTILIZACAO = 'S';
    public static $TST_EM_UTILIZACAO = 'E';
    public static $TST_DESCARTADO = 'D';
    public static $TST_DESCARTADO_NO_MEIO_ETAPA= 'M';
    public static $TST_TRANSPORTE_EXTRACAO= 'R';
    public static $TST_AGUARDANDO_BANCO_AMOSTRAS= 'B';



    public static function listarValoresTipoEtapa(){
        try {

            $arrObjTEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_RECEPCAO);
            $objSituacao->setStrDescricao('Recepção');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
            $objSituacao->setStrDescricao('Montagem do grupo de preparo/extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_PREPARACAO_INATIVACAO);
            $objSituacao->setStrDescricao('Preparo e Inativação');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_EXTRACAO);
            $objSituacao->setStrDescricao('Extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_ARMAZENAMENTO_EXTRACAO);
            $objSituacao->setStrDescricao('Armazenamento da Preparação/Extração');
            $arrObjTEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TP_LAUDO);
            $objSituacao->setStrDescricao('Laudo');
            $arrObjTEtapa[] = $objSituacao;


            return $arrObjTEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function listarValoresTipoStaEtapa(){
        try {

            $arrObjTStaEtapa = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_INICIALIZADO);
            $objSituacao->setStrDescricao('Inicializada');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_AGUARDANDO);
            $objSituacao->setStrDescricao('Aguardando');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_EM_ANDAMENTO);
            $objSituacao->setStrDescricao('Em andamento');
            $arrObjTStaEtapa[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TSP_FINALIZADO);
            $objSituacao->setStrDescricao('Finalizada');
            $arrObjTStaEtapa[] = $objSituacao;

            return $arrObjTStaEtapa;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function listarValoresTipoStaTubo(){
        try {

            $arrObjTStaTubo = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_SEM_UTILIZACAO);
            $objSituacao->setStrDescricao('Sem utilização no momento');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_EM_UTILIZACAO);
            $objSituacao->setStrDescricao('Em utilização');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_DESCARTADO);
            $objSituacao->setStrDescricao('Descartado');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_TRANSPORTE_PREPARACAO);
            $objSituacao->setStrDescricao('Em transporte para preparação');
            $arrObjTStaTubo[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_TRANSPORTE_EXTRACAO);
            $objSituacao->setStrDescricao('Em transporte para preparação');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_DESCARTADO_NO_MEIO_ETAPA);
            $objSituacao->setStrDescricao('Descartado no meio da etapa');
            $arrObjTStaTubo[] = $objSituacao;


            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TST_AGUARDANDO_BANCO_AMOSTRAS);
            $objSituacao->setStrDescricao('Aguardando no banco de amostras');
            $arrObjTStaTubo[] = $objSituacao;

            return $arrObjTStaTubo;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function retornarStaTubo($situacaoTubo){
        $arr = self::listarValoresTipoStaTubo();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoTubo ){
                return $a->getStrDescricao();
            }
        }
    }

    public static function retornarStaEtapa($situacaoEtapa){
        $arr = self::listarValoresTipoStaEtapa();
        foreach ($arr as $a){
            if($a->getStrTipo() == $situacaoEtapa ){
                return $a->getStrDescricao();
            }
        }
    }

    public static function retornarEtapa($etapa){
        $arr = self::listarValoresTipoEtapa();

        foreach ($arr as $a){
            if($a->getStrTipo() == $etapa ){
                return $a->getStrDescricao();
            }
        }
    }


    private function validarNome(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){
        $StrNome = trim($LocalArmazenamentoTxt->getNome());

        if(strlen($StrNome) > 150 ){
            $objExcecao->adicionar_validacao('O nome possui mais de 150 caracteres - Amostra <strong>'.$LocalArmazenamentoTxt->getObjInfos()->getCodAmostra().'</strong>', null,'alert-danger');
        }


        if(($LocalArmazenamentoTxt->getObjInfos()->getObsProblema() == null && $LocalArmazenamentoTxt->getNome() == null) ||
            ($LocalArmazenamentoTxt->getObjInfos()->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA && $LocalArmazenamentoTxt->getNome() == null)){
            $objExcecao->adicionar_validacao('Informe o nome do local de armazenamento da amostra <strong>'.$LocalArmazenamentoTxt->getObjInfos()->getCodAmostra().'</strong>', null,'alert-danger');
        }

        return $LocalArmazenamentoTxt->setNome($StrNome);
    }

    private function validarPorta(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){
        $StrPorta = trim($LocalArmazenamentoTxt->getPorta());

        if(strlen($StrPorta) > 150 ){
            $objExcecao->adicionar_validacao('A porta possui mais de 150 caracteres', null,'alert-danger');
        }

        return $LocalArmazenamentoTxt->setPorta($StrPorta);
    }

    private function validarPrateleira(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){
        $StrPrateleira = trim($LocalArmazenamentoTxt->getPrateleira());

        if(strlen($StrPrateleira) > 150 ){
            $objExcecao->adicionar_validacao('A prateleira possui mais de 150 caracteres.', null,'alert-danger');
        }

        return $LocalArmazenamentoTxt->setPrateleira($StrPrateleira);
    }

    private function validarColuna(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){
        $StrColuna = trim($LocalArmazenamentoTxt->getColuna());

        if(strlen($StrColuna) > 150 ){
            $objExcecao->adicionar_validacao('A coluna possui mais de 150 caracteres', null,'alert-danger');
        }

        return $LocalArmazenamentoTxt->setColuna($StrColuna);
    }

    private function validarCaixa(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){
        $StrCaixa = trim($LocalArmazenamentoTxt->getCaixa());

        if(($LocalArmazenamentoTxt->getObjInfos()->getObsProblema() == null && $LocalArmazenamentoTxt->getCaixa() == null) ||
            ($LocalArmazenamentoTxt->getObjInfos()->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA && $LocalArmazenamentoTxt->getCaixa() == null)){
            $objExcecao->adicionar_validacao('Informe a caixa da amostra <strong>'.$LocalArmazenamentoTxt->getObjInfos()->getCodAmostra().'</strong>', null,'alert-danger');
        }

        if(strlen($StrCaixa) > 150 ){
            $objExcecao->adicionar_validacao('A caixa possui mais de 150 caracteres - Amostra <strong>'.$LocalArmazenamentoTxt->getObjInfos()->getCodAmostra().'</strong>', null,'alert-danger');
        }

        return $LocalArmazenamentoTxt->setCaixa($StrCaixa);
    }

    private function validarPosicao(LocalArmazenamentoTexto $LocalArmazenamentoTxt, Excecao $objExcecao){

        if($LocalArmazenamentoTxt->getPosicao() != null) {
            $StrPosicao = trim($LocalArmazenamentoTxt->getPosicao());

            if($LocalArmazenamentoTxt->getPosicao() != null && $LocalArmazenamentoTxt->getCaixa() == null) {
                $objExcecao->adicionar_validacao('Informe a caixa onde fica essa posição- Amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>',null, 'alert-danger');
            }

            if (($LocalArmazenamentoTxt->getObjInfos()->getObsProblema() == null && $LocalArmazenamentoTxt->getPosicao() == null) ||
                //($LocalArmazenamentoTxt->getObjsInfos()->getObsProblema() == '' && $LocalArmazenamentoTxt->getPosicao() == '') ||
                ($LocalArmazenamentoTxt->getObjInfos()->getSituacaoTubo() != InfosTuboRN::$TST_DESCARTADO_NO_MEIO_ETAPA && $LocalArmazenamentoTxt->getPosicao() == null)) {
                $objExcecao->adicionar_validacao('Informe a posição da amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>', null, 'alert-danger');
            }


            if (strlen($StrPosicao) > 6) {
                $objExcecao->adicionar_validacao('A posicao possui mais de 6 caracteres - Amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>', null, 'alert-danger');
            }
            if (is_numeric($StrPosicao[0])) {
                $objExcecao->adicionar_validacao('A primeira letra deve ser um caractere alfabético e não um número - Amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>', null, 'alert-danger');
            }

            if (strlen($StrPosicao) < 2) {
                $objExcecao->adicionar_validacao('A posicao deve possuir no mínimo 2 caracteres (letra + número) - Amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>', null, 'alert-danger');
            }

            if (strlen($StrPosicao) > 2 && strlen($StrPosicao) <= 6) {
                for ($i = 0; $i < strlen($StrPosicao); $i++) {
                    if ($i > 0) {
                        if (!is_numeric($StrPosicao[$i])) {
                            $objExcecao->adicionar_validacao('A posição informada tem caracteres inválidos. Modo correto (letra + número)', null, 'alert-danger');
                        }
                    }
                }
            }

            /*if ($LocalArmazenamentoTxt->getNome() != null && $LocalArmazenamentoTxt->getCaixa() != null) {
                $objLocalTXT = new LocalArmazenamentoTexto();
                $objLocalTXTRN = new LocalArmazenamentoTextoRN();
                $objLocalTXT->setNome($LocalArmazenamentoTxt->getNome());
                $objLocalTXT->setCaixa($LocalArmazenamentoTxt->getCaixa());
                $objLocalTXT->setPosicao($LocalArmazenamentoTxt->getPosicao());
                $arr = $objLocalTXTRN->listar($objLocalTXT);
                if(count($arr) > 0){
                    $objExcecao->adicionar_validacao('A posição informada já tem uma amostra - Amostra <strong>' . $LocalArmazenamentoTxt->getObjInfos()->getCodAmostra() . '</strong>', null, 'alert-danger');
                }
            }*/
        }


        return $LocalArmazenamentoTxt->setPosicao($StrPosicao);
    }




    public function cadastrar(LocalArmazenamentoTexto $LocalArmazenamentoTxt){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

                $this->validarNome($LocalArmazenamentoTxt, $objExcecao);
                $this->validarPorta($LocalArmazenamentoTxt, $objExcecao);
                $this->validarPrateleira($LocalArmazenamentoTxt, $objExcecao);
                $this->validarColuna($LocalArmazenamentoTxt, $objExcecao);
                $this->validarCaixa($LocalArmazenamentoTxt, $objExcecao);
                $this->validarPosicao($LocalArmazenamentoTxt, $objExcecao);

                $objExcecao->lancar_validacoes();
                $objLocalArmazenamentoTextoBD = new LocalArmazenamentoTextoBD();
                $LocalArmazenamentoTxt = $objLocalArmazenamentoTextoBD->cadastrar($LocalArmazenamentoTxt, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $LocalArmazenamentoTxt;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro no cadastramento dos locais de armazenamento (txt).', $e);
        }
    }

    public function alterar(LocalArmazenamentoTexto $LocalArmazenamentoTxt){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarNome($LocalArmazenamentoTxt, $objExcecao);
            $this->validarPorta($LocalArmazenamentoTxt, $objExcecao);
            $this->validarPrateleira($LocalArmazenamentoTxt, $objExcecao);
            $this->validarColuna($LocalArmazenamentoTxt, $objExcecao);
            $this->validarCaixa($LocalArmazenamentoTxt, $objExcecao);
            $this->validarPosicao($LocalArmazenamentoTxt, $objExcecao);

            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoTextoBD = new LocalArmazenamentoTextoBD();
            $LocalArmazenamentoTxt = $objLocalArmazenamentoTextoBD->alterar($LocalArmazenamentoTxt,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $LocalArmazenamentoTxt;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração dos locais de armazenamento (txt).', $e);
        }
    }

    public function consultar(LocalArmazenamentoTexto $LocalArmazenamentoTxt){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoTextoBD = new LocalArmazenamentoTextoBD();
            $arr = $objLocalArmazenamentoTextoBD->consultar($LocalArmazenamentoTxt,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta dos locais de armazenamento (txt).', $e);
        }
    }

    public function remover(LocalArmazenamentoTexto $LocalArmazenamentoTxt){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoTextoBD = new LocalArmazenamentoTextoBD();
            $arr = $objLocalArmazenamentoTextoBD->remover($LocalArmazenamentoTxt,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção dos locais de armazenamento (txt).', $e);
        }
    }

    public function listar(LocalArmazenamentoTexto $LocalArmazenamentoTxt){
        $objBanco = new Banco();
        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objLocalArmazenamentoTextoBD = new LocalArmazenamentoTextoBD();
            $arr = $objLocalArmazenamentoTextoBD->listar($LocalArmazenamentoTxt,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem dos locais de armazenamento (txt).', $e);
        }
    }


}