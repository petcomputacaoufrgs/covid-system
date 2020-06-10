<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do equipamento
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/EquipamentoBD.php';
require_once __DIR__ . '/../Situacao/Situacao.php';

class EquipamentoRN{

    public static $TE_OCUPADO = 'O';
    public static $TE_LIBERADO = 'L';

    public static function listarValoresSituacaoEquipamento(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_LIBERADO);
            $objSituacao->setStrDescricao('LIBERADO');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_OCUPADO);
            $objSituacao->setStrDescricao('OCUPADO');
            $arrObjTECapela[] = $objSituacao;

            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de SITUAÇÃO do equipamento',$e);
        }
    }


    public static function mostrarDescricaoSituacao($strSituacao){
        foreach (self::listarValoresSituacaoEquipamento() as $tipo){
            if($tipo->getStrTipo() == $strSituacao){
                return $tipo->getStrDescricao();
            }
        }
        return null;
    }

    
    private function validarDataUltimaCalibragem(Equipamento $equipamento,Excecao $objExcecao){
        $strDataUltimaCalibragem= trim($equipamento->getDataUltimaCalibragem());
        
        //if ($strDataUltimaCalibragem == '') {
        //    $objExcecao->adicionar_validacao('A data da última calibragem não foi informada',null,'alert-danger');
        //}
        if ($strDataUltimaCalibragem != '') {
            Utils::validarData($strDataUltimaCalibragem, $objExcecao);
        }
        
        return $equipamento->setDataUltimaCalibragem($strDataUltimaCalibragem);

    }
    private function validarDataChegada(Equipamento $equipamento,Excecao $objExcecao){
        $strDataChegada = trim($equipamento->getDataChegada());
        
        //if ($strDataChegada == '') {
        //    $objExcecao->adicionar_validacao('A data de chegada não foi informada',null,'alert-danger');
        //}
        if ($strDataChegada != '') {
            Utils::validarData($strDataChegada, $objExcecao);
            // echo date('d-m-Y');    
        }
        
        return $equipamento->setDataChegada($strDataChegada);

    }
    /*private function validarIdDetentor(Equipamento $equipamento,Excecao $objExcecao){
        $strIdDetentor = trim($equipamento->getIdDetentor_fk());
        
        if ($strIdDetentor == '' || $strIdDetentor == null) {
            $objExcecao->adicionar_validacao('O detentor precisa ser informado',null,'alert-danger');
        }
        return $equipamento->setIdDetentor_fk($strIdDetentor);

    }*/
    private function validarNomeEquipamento(Equipamento $equipamento,Excecao $objExcecao){
        $strNomeEquipamento= trim($equipamento->getNomeEquipamento());

        if (strlen($strNomeEquipamento) > 150 ) {
            $objExcecao->adicionar_validacao('O nome do equipamento deve possuir no máximo 150 caracteres.',null,'alert-danger');
        }

        return $equipamento->setNomeEquipamento($strNomeEquipamento);

    }
    private function validarSituacaoEquipamento(Equipamento $equipamento,Excecao $objExcecao){
        $strSituacaoEquipamento= trim($equipamento->getSituacaoEquipamento());

        if(is_null(self::mostrarDescricaoSituacao($strSituacaoEquipamento))){
            $objExcecao->adicionar_validacao('A situação do equipamento é inválida',null,'alert-danger');
        }
    }
    private function validarJaExiste(Equipamento $equipamento,Excecao $objExcecao){

        $objEquipamentoRN = new EquipamentoRN();
        $numEquipamentos = $objEquipamentoRN->listar_completo($equipamento,1);

        if(count($numEquipamentos) > 0 ){
            $objExcecao->adicionar_validacao('O equipamento já existe.',null,'alert-danger');
        }

    }
    private function validarIdUsuario(Equipamento $equipamento,Excecao $objExcecao){

        if(is_null($equipamento->getIdUsuarioFk())){
            $objExcecao->adicionar_validacao('O id do usuário não foi informado',null,'alert-danger');
        }
    }
    private function validarDataCadastro(Equipamento $equipamento,Excecao $objExcecao){

        if(is_null($equipamento->getDataCadastro())){
            $objExcecao->adicionar_validacao('A data de cadastro do equipamento não foi informado',null,'alert-danger');
        }
    }
    private function validarHoras(Equipamento $equipamento,Excecao $objExcecao){
        if(is_null($equipamento->getHoras())){
            $equipamento->setHoras(0);
        }else if($equipamento->getHoras() > 24){
            $objExcecao->adicionar_validacao('Valor informado para horas é inválido',null,'alert-danger');
        }
    }
    private function validarMinutos(Equipamento $equipamento,Excecao $objExcecao){
        if(is_null($equipamento->getMinutos())){
            $equipamento->setMinutos(0);
        }else if($equipamento->getMinutos() > 60){
            $objExcecao->adicionar_validacao('Valor informado para minutos é inválido',null,'alert-danger');
        }
    }
    private function validarIdEquipamento(Equipamento $equipamento,Excecao $objExcecao){

        if(is_null($equipamento->getIdEquipamento())){
            $objExcecao->adicionar_validacao('O id do equipamento não foi informado',null,'alert-danger');
        }
    }


    public function cadastrar(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarDataChegada($equipamento,$objExcecao); 
            $this->validarDataUltimaCalibragem($equipamento,$objExcecao);
            $this->validarDataCadastro($equipamento,$objExcecao);
            $this->validarIdUsuario($equipamento,$objExcecao);
            $this->validarNomeEquipamento($equipamento,$objExcecao);
            $this->validarSituacaoEquipamento($equipamento,$objExcecao);
            $this->validarHoras($equipamento,$objExcecao);
            $this->validarMinutos($equipamento,$objExcecao);
            $this->validarJaExiste($equipamento,$objExcecao);

            //echo "<pre>";
            //print_r($equipamento);
            //echo "</pre>";
            //die("aq");

            $objExcecao->lancar_validacoes();
            if($equipamento->getObjDetentor() != null){
                $objDetentorRN = new DetentorRN();
                $detentores = $objDetentorRN->listar($equipamento->getObjDetentor(),1);

                if(count($detentores) == 0 ){
                    $objDetentor  = $objDetentorRN->cadastrar($equipamento->getObjDetentor());
                }else{
                    $objDetentor =  $detentores[0];
                }

                $equipamento->setIdDetentor_fk($objDetentor->getIdDetentor());
            }

            if($equipamento->getObjModelo() != null){
                $objModeloRN = new ModeloRN();
                $modelos = $objModeloRN->listar($equipamento->getObjModelo(),1);

                if(count($modelos) == 0 ){
                    $objModelo = $objModeloRN->cadastrar($equipamento->getObjModelo());
                }else{
                    $objModelo =  $modelos[0];
                }
                $equipamento->setIdModelo_fk($objModelo->getIdModelo());
            }

            if($equipamento->getObjMarca() != null){
                $objMarcaRN = new MarcaRN();
                $marcas = $objMarcaRN->listar($equipamento->getObjMarca(),1);

                if(count($marcas) == 0 ){
                    $objMarca = $objMarcaRN->cadastrar($equipamento->getObjMarca());
                }else{
                    $objMarca =  $marcas[0];
                }

                $equipamento->setIdMarca_fk($objMarca->getIdMarca());
            }


            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $objEquipamento = $objEquipamentoBD->cadastrar($equipamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objEquipamento;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o equipamento.', $e);
        }
    }

    public function alterar(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $this->validarDataChegada($equipamento,$objExcecao);
            $this->validarDataUltimaCalibragem($equipamento,$objExcecao);
            $this->validarDataCadastro($equipamento,$objExcecao);
            $this->validarIdUsuario($equipamento,$objExcecao);
            $this->validarNomeEquipamento($equipamento,$objExcecao);
            $this->validarSituacaoEquipamento($equipamento,$objExcecao);
            $this->validarHoras($equipamento,$objExcecao);
            $this->validarMinutos($equipamento,$objExcecao);
            $this->validarJaExiste($equipamento,$objExcecao);
            $this->validarIdEquipamento($equipamento,$objExcecao);
            $objExcecao->lancar_validacoes();
            if($equipamento->getObjDetentor() != null){
                $objDetentorRN = new DetentorRN();
                $detentores = $objDetentorRN->listar($equipamento->getObjDetentor(),1);

                if(count($detentores) == 0 ){
                    $objDetentor  = $objDetentorRN->cadastrar($equipamento->getObjDetentor());
                }else{
                    $objDetentor =  $detentores[0];
                }

                $equipamento->setIdDetentor_fk($objDetentor->getIdDetentor());
            }

            if($equipamento->getObjModelo() != null){
                $objModeloRN = new ModeloRN();
                $modelos = $objModeloRN->listar($equipamento->getObjModelo(),1);

                if(count($modelos) == 0 ){
                    $objModelo = $objModeloRN->cadastrar($equipamento->getObjModelo());
                }else{
                    $objModelo =  $modelos[0];
                }
                $equipamento->setIdModelo_fk($objModelo->getIdModelo());
            }

            if($equipamento->getObjMarca() != null){
                $objMarcaRN = new MarcaRN();
                $marcas = $objMarcaRN->listar($equipamento->getObjMarca(),1);

                if(count($marcas) == 0 ){
                    $objMarca = $objMarcaRN->cadastrar($equipamento->getObjMarca());
                }else{
                    $objMarca =  $marcas[0];
                }

                $equipamento->setIdMarca_fk($objMarca->getIdMarca());
            }
                        

            $objEquipamentoBD = new EquipamentoBD();
            $objEquipamento = $objEquipamentoBD->alterar($equipamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objEquipamento;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o equipamento.', $e);
        }
    }

    public function consultar(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr =  $objEquipamentoBD->consultar($equipamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o equipamento.',$e);
        }
    }

    public function remover(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr =  $objEquipamentoBD->remover($equipamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o equipamento.', $e);
        }
    }

    public function listar(Equipamento $equipamento,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            
            $arr = $objEquipamentoBD->listar($equipamento,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o equipamento.',$e);
        }
    }

    /**** EXTRAS ****/
    public function listar_completo(Equipamento $equipamento,$numLimite = null) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();

            $arr = $objEquipamentoBD->listar_completo($equipamento,$numLimite,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o equipamento completo.',$e);
        }
    }

    public function paginacao(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr =  $objEquipamentoBD->paginacao($equipamento,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o equipamento.',$e);
        }
    }

    public function bloquear_registro(Equipamento $equipamento) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $this->validarIdEquipamento($equipamento,$objExcecao);
            $objExcecao->lancar_validacoes();

            //sleep(5);
            $objEquipamentoBD = new EquipamentoBD();
            $objEquipamento = $objEquipamentoBD->bloquear_registro($equipamento, $objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objEquipamento;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro bloqueando a capela.',$e);
        }
    }


   /* public function pesquisar($campoBD, $valor_usuario) {
         $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr = $objEquipamentoBD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        }catch (Throwable $e){
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o equipamento.', $e);
        }
    }*/

   /* public function existe(Equipamento $equipamento) {
         $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objEquipamentoBD = new EquipamentoBD();
            $arr = $objEquipamentoBD->existe($equipamento,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro verificando se existe o equipamento.', $e);
        }
    }*/



}

