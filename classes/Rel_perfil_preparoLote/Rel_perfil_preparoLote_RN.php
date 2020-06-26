<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/Rel_perfil_preparoLote_BD.php';
class Rel_perfil_preparoLote_RN
{
    public function cadastrar(Rel_perfil_preparoLote $rel_perfil_preparoLote){
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            if($rel_perfil_preparoLote->getObjPreparoLote() != null){
                $objPreparoLoteRN = new PreparoLoteRN();
                $objPreparoLote = $rel_perfil_preparoLote->getObjPreparoLote();

                if($rel_perfil_preparoLote->getObjPreparoLote()->getIdPreparoLote() == null) { //não existe
                    $objPreparoLote = $objPreparoLoteRN->cadastrar($objPreparoLote);
                }else{
                    $objPreparoLote = $objPreparoLoteRN->alterar($objPreparoLote);
                }
            }



            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();
            if($objPreparoLote->getObjPerfil() != null && $objPreparoLote->getIdPreparoLote() != null) {
                foreach ($objPreparoLote->getObjPerfil() as $perfil) {
                    $rel_perfil_preparoLote->setIdPerfilPacienteFk($perfil->getIdPerfilPaciente());
                    $rel_perfil_preparoLote->setIdPreparoLoteFk($objPreparoLote->getIdPreparoLote());
                    $rel_perfil_preparoLote = $objRel_perfil_preparoLote_BD->cadastrar($rel_perfil_preparoLote, $objBanco);
                }
            }
            $rel_perfil_preparoLote->setObjPreparoLote($objPreparoLote);
            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $rel_perfil_preparoLote;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            //$objExcecao->adicionar_validacao("Os dados não foram cadastrados", null,'alert-danger');
            throw new Excecao('Erro no cadastramento do relacionamento do perfil com um lote.', $e);
        }
    }

    public function alterar(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();
            $objRel_perfil_preparoLote_BD->alterar($rel_perfil_preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na alteração do relacionamento do perfil com um lote.', $e);
        }
    }

    public function consultar(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();
            $arr =  $objRel_perfil_preparoLote_BD->consultar($rel_perfil_preparoLote,$objBanco);



            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na consulta do relacionamento do perfil com um lote.',$e);
        }
    }

    public function remover(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();

            $arr =  $objRel_perfil_preparoLote_BD->remover($rel_perfil_preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento do perfil com um lote.', $e);
        }
    }

    public function remover_peloIdPreparo(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();

            $arr =  $objRel_perfil_preparoLote_BD->remover_peloIdPreparo($rel_perfil_preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na remoção do relacionamento do perfil com um lote.', $e);
        }
    }

    public function listar(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();

            $arr =  $objRel_perfil_preparoLote_BD->listar($rel_perfil_preparoLote,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do relacionamento do perfil com um lote.',$e);
        }
    }

    public function listar_lotes(Rel_perfil_preparoLote $rel_perfil_preparoLote) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();
            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();

            $arr = $objRel_perfil_preparoLote_BD->listar_lotes($rel_perfil_preparoLote,$objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na listagem do relacionamento do perfil com um lote.',$e);
        }
    }

    public function pesquisar($campoBD, $valor_usuario) {
        $objBanco = new Banco();

        try{
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();

            $objExcecao->lancar_validacoes();
            $objRel_perfil_preparoLote_BD = new Rel_perfil_preparoLote_BD();
            $arr = $objRel_perfil_preparoLote_BD->pesquisar($campoBD,$valor_usuario,$objBanco);

            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $arr;
        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro na pesquisa do relacionamento do perfil com um lote.', $e);
        }
    }
}