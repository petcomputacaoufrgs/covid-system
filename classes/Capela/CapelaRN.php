<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio da capela do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CapelaBD.php';
require_once __DIR__ . '/../Situacao/Situacao.php';

class CapelaRN{

    public static $TE_OCUPADA = 'O';
    public static $TE_LIBERADA = 'L';


    public static $TNS_BAIXA_SEGURANCA = 'B';
    public static $TNS_MEDIA_SEGURANCA = 'M';
    public static $TNS_ALTA_SEGURANCA = 'A';



    public static function listarValoresTipoEstado(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_LIBERADA);
            $objSituacao->setStrDescricao('LIBERADA');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TE_OCUPADA);
            $objSituacao->setStrDescricao('OCUPADA');
            $arrObjTECapela[] = $objSituacao;

            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo estado da capela',$e);
        }
    }

    public static function listarValoresTipoNivelSeguranca(){
        try {

            $arrObjTECapela = array();

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TNS_BAIXA_SEGURANCA);
            $objSituacao->setStrDescricao('Capela de segurança de nível baixo');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TNS_MEDIA_SEGURANCA);
            $objSituacao->setStrDescricao('Capela de segurança de nível médio');
            $arrObjTECapela[] = $objSituacao;

            $objSituacao = new Situacao();
            $objSituacao->setStrTipo(self::$TNS_ALTA_SEGURANCA);
            $objSituacao->setStrDescricao('Capela de segurança de nível alto');
            $arrObjTECapela[] = $objSituacao;

            return $arrObjTECapela;

        }catch(Throwable $e){
            throw new Excecao('Erro listando valores de Tipo de nível de segurança da capela',$e);
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

    public static function mostrarDescricaoTipoSeguranca($strTipo){
        //$objExcecao = new Excecao();

        foreach (self::listarValoresTipoNivelSeguranca() as $tipo){
            if($tipo->getStrTipo() == $strTipo){
                return $tipo->getStrDescricao();
            }
        }

        //$objExcecao->adicionar_validacao('Não encontrou o tipo informadoo.','alert-danger');
    }

    private function validarStrTipoCapela(Capela $capela,Excecao $objExcecao){

        if ($capela->getSituacaoCapela() == null){
            $objExcecao->adicionar_validacao('Tipo não informado',null,'alert-danger');
        }else{
            $flag = false;
            foreach (self::listarValoresTipoEstado() as $tipo){
                if($tipo->getStrTipo() == $capela->getSituacaoCapela()){
                    $flag = true;
                }
            }

            if(!$flag){
                $objExcecao->adicionar_validacao('Situação da capela não foi encontrada',null,'alert-danger');
            }

        }

    }




    private function validarNumero(Capela $capela,Excecao $objExcecao){
        $strNumero = trim($capela->getNumero());
        
        if ($strNumero == '') {
            $objExcecao->adicionar_validacao('O número da capela não foi informado','idNumeroCapela', 'alert-danger');
        }else{

            $objCapela = new Capela();
            $objCapelaRN = new CapelaRN();


            $objCapela->setNumero($capela->getNumero());
            $arr_capelas  = $objCapelaRN->listar($objCapela);

            if($capela->getIdCapela() != null){
                if($arr_capelas[0]->getIdCapela() != $capela->getIdCapela()){
                    echo "aqui";
                    $objExcecao->adicionar_validacao('Já existe uma capela associada a este número',null, 'alert-danger');
                }
            }



        }


        return $capela->setNumero($strNumero);

    }

    private function validarNivelSeguranca(Capela $capela,Excecao $objExcecao){
        $strNivelSeguranca = trim($capela->getNivelSeguranca());

        if ($strNivelSeguranca == '') {
            $objExcecao->adicionar_validacao('O nível de segurança da capela não foi informado','idNumeroCapela', 'alert-danger');
        }
        return $capela->setNivelSeguranca($strNivelSeguranca);

    }

    public function cadastrar(Capela $capela) {
        try {
            
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 

            $this->validarStrTipoCapela($capela,$objExcecao);
            $this->validarNumero($capela,$objExcecao);
            $this->validarNivelSeguranca($capela,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $objCapelaBD->cadastrar($capela,$objBanco);
            
            $objBanco->fecharConexao();
        } catch (Exception $e) {
            throw new Excecao('Erro cadastrando a capela.', $e);
        }
    }

    public function alterar(Capela $capela) {
         try {
             
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();

             $this->validarStrTipoCapela($capela,$objExcecao);
            $this->validarNumero($capela,$objExcecao);
             $this->validarNivelSeguranca($capela,$objExcecao);
                        
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
             $capela = $objCapelaBD->alterar($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $capela;
        } catch (Exception $e) {
            throw new Excecao('Erro alterando a capela.', $e);
        }
    }

    public function consultar(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $arr =  $objCapelaBD->consultar($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
 
            throw new Excecao('Erro consultando a capela.',$e);
        }
    }

    public function remover(Capela $capela) {
         try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $arr =  $objCapelaBD->remover($capela,$objBanco);
            $objBanco->fecharConexao();
            return $arr;

        } catch (Exception $e) {
            throw new Excecao('Erro removendo a capela.', $e);
        }
    }

    public function listar(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            
            $arr = $objCapelaBD->listar($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a capela.',$e);
        }
    }

     public function bloquear_registro(Capela $capela) {
         $objBanco = new Banco();
        try {
            $objCapelaBD = new CapelaBD();
            $objExcecao = new Excecao();

            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if ($capela->getIdCapela() != null){
                //sleep(5);
                $arr = $objCapelaBD->bloquear_registro($capela, $objBanco);
                if (empty($arr)) {
                    return $arr;
                }

                $objCapela = new Capela();
                $objCapela->setIdCapela($arr[0]->getIdCapela());
                $objCapela->setNumero($arr[0]->getNumero());
                $arr[0]->setSituacaoCapela(self::$TE_OCUPADA);
                $objCapela->setSituacaoCapela($arr[0]->getSituacaoCapela());
                $objCapela->setNivelSeguranca($arr[0]->getNivelSeguranca());
            }/*else if($capela->getIdCapela() == null){
                $objCapelaRN = new CapelaRN();
                $objCapela = $objCapelaRN->consultar($capela);
                $objCapela->setSituacaoCapela(self::$TE_OCUPADA);
            }*/
            
            $capelaRN = NEW CapelaRN();
            $objCapela = $capelaRN->alterar($objCapela);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $objCapela;
        } catch (Exception $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro bloqueando a capela.',$e);
        }
    }

    
    public function validar_cadastro(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();
            $this->validarNumero($capela,$objExcecao);

            $arr = $objCapelaBD->validar_cadastro($capela,$objBanco);
            
            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a capela.',$e);
        }
    }


    public function listar_altaSegur_liberada(Capela $capela) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao();
            $objExcecao->lancar_validacoes();
            $objCapelaBD = new CapelaBD();

            $arr = $objCapelaBD->listar_altaSegur_liberada($capela,$objBanco);

            $objBanco->fecharConexao();
            return $arr;
        } catch (Exception $e) {
            throw new Excecao('Erro listando a capela.',$e);
        }
    }


    

}

