<?php 
/* 
 *  Author: Carine Bertagnolli Bathaglini
 *  Classe das regras de negócio do código GAL do paciente
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/CodigoGAL_BD.php';


class CodigoGAL_RN{
    

    private function validarCodGAL(CodigoGAL $codGAL,Excecao $objExcecao){

        $numCodGAL = $codGAL->getCodigo();

        /*if (strlen($strCodGAL) <= 1) {
            $objExcecao->adicionar_validacao('O código GAL informado é inválido','idCodGAL','alert-danger');
        } */

        if (strlen($numCodGAL) > 20) {
            $objExcecao->adicionar_validacao('O código GAL possui mais de 20 caracteres','idCodGAL','alert-danger');
        }

        $objCodigoGALAux = new CodigoGAL();
        $objCodigoGALRN = new CodigoGAL_RN();
        $arr_codigos = $objCodigoGALRN->listar($objCodigoGALAux);

        foreach ($arr_codigos as $codigo){
            //echo $codigo->getCodigo().' == '. $codGAL->getCodigo()."\n";
            if( $codigo->getCodigo() == $codGAL->getCodigo() &&
                $codigo->getIdPaciente_fk() != $codGAL->getIdPaciente_fk()){
                $objExcecao->adicionar_validacao('O código GAL já está associado a outro paciente','idCodGAL','alert-danger');
                break;
            }


        }
                
        return $codGAL->setCodigo($numCodGAL);
    }


    private function validaObsCodGAL(CodigoGAL $codGAL, Excecao $objExcecao) {
        if($codGAL->getObsCodGAL() != null) {
            $strObsCodGAL = trim($codGAL->getObsCodGAL());

            if (strlen($strObsCodGAL) > 300) {
                $objExcecao->adicionar_validacao('As observações do código GAL possui mais que 300 caracteres.', null, 'alert-danger');
            }


            return $codGAL->setObsCodGAL($strObsCodGAL);
        }
    }
         
    public function cadastrar(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {
            
            $objExcecao = new Excecao();
            $objBanco->abrirConexao(); 
            
            $objBanco->abrirTransacao(); 
           
            /* VALIDAÇÕES */
            $this->validarCodGAL($codGAL,$objExcecao);
            $this->validaObsCodGAL($codGAL,$objExcecao);

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $objCodigoGAL_BD->cadastrar($codGAL, $objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();

            return $codGAL;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando o código GAL.', $e);
        }
    }

    public function alterar(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            
            /* VALIDAÇÕES */
            $this->validarCodGAL($codGAL,$objExcecao);
            $this->validaObsCodGAL($codGAL,$objExcecao);
            
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $codigoGAL = $objCodigoGAL_BD->alterar($codGAL,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $codigoGAL;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro alterando o código GAL.', $e);
        }
    }

    public function consultar(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr =  $objCodigoGAL_BD->consultar($codGAL,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro consultando o código GAL.',$e);
        }
    }

    public function remover(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr =  $objCodigoGAL_BD->remover($codGAL,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro removendo o código GAL.', $e);
        }
    }

    public function listar(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr = $objCodigoGAL_BD->listar($codGAL,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o código GAL.',$e);
        }
    }


    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr = $objCodigoGAL_BD->pesquisar($campoBD,$valor_usuario,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro pesquisando o código GAL.', $e);
        }
    }
    
    
    public function validar_cadastro(CodigoGAL $codGAL) {
        $objBanco = new Banco();
        try {

            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            $arr = $objCodigoGAL_BD->validar_cadastro($codGAL,$objBanco);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro validando cadastron do código GAL.', $e);
        }
    }
    
    
    public function procurarGAL($codGAL) {
        try {
            $objExcecao = new Excecao();
            $objBanco = new Banco();
            $objBanco->abrirConexao(); 
            $objExcecao->lancar_validacoes();
            $objCodigoGAL_BD = new CodigoGAL_BD();
            
            $arr = $objCodigoGAL_BD->procurarGAL($codGAL,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro listando o código GAL.',$e);
        }
    }

   
}

