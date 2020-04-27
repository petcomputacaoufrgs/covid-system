<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class Rel_perfil_preparoLote_BD{

    public function cadastrar(Rel_perfil_preparoLote $objRel_perfil_preparoLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rel_perfil_preparolote (
                            idPreparoLote_fk,
                            idPerfilPaciente_fk
                            ) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdPreparoLoteFk());
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdPerfilPacienteFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRel_perfil_preparoLote->setIdRelPerfilPreparoLote($objBanco->obterUltimoID());

        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function alterar(Rel_perfil_preparoLote $objRel_perfil_preparoLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_perfil_preparolote SET '
                . ' idPreparoLote_fk = ?,'
                . ' idPerfilPaciente_fk = ?'
                . '  where idRelTuboLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdPreparoLoteFk());
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdPerfilPacienteFk());

            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdRelPerfilPreparoLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function listar(Rel_perfil_preparoLote $objRel_perfil_preparoLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_perfil_preparolote";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRel_perfil_preparoLote->getIdPerfilPacienteFk() != null) {
                $WHERE .= $AND . " idPerfilPaciente_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRel_perfil_preparoLote->getIdPerfilPacienteFk());
            }

            if ($objRel_perfil_preparoLote->getIdPreparoLoteFk() != null) {
                $WHERE .= $AND . " idPreparoLote_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRel_perfil_preparoLote->getIdPreparoLoteFk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $perfil_preparoLote = new Rel_perfil_preparoLote();
                $perfil_preparoLote->setIdRelPerfilPreparoLote($reg['idRelPerfilPreparoLote']);
                $perfil_preparoLote->setIdPreparoLoteFk($reg['idPreparoLote_fk']);
                $perfil_preparoLote->setIdPerfilPacienteFk($reg['idPerfilPaciente_fk']);

                $array[] = $perfil_preparoLote;
            }
            return $array;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function consultar(Rel_perfil_preparoLote $objRel_perfil_preparoLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_perfil_preparolote WHERE idRelPerfilPreparoLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdRelPerfilPreparoLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfil_preparoLote = new Rel_perfil_preparoLote();
            $perfil_preparoLote->setIdRelPerfilPreparoLote($arr[0]['idRelPerfilPreparoLote']);
            $perfil_preparoLote->setIdPreparoLoteFk($arr[0]['idPreparoLote_fk']);
            $perfil_preparoLote->setIdPerfilPacienteFk($arr[0]['idPerfilPaciente_fk']);

            return $perfil_preparoLote;
        } catch (Exception $ex) {

            throw new Excecao("Erro consultando o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }

    }

    public function remover(Rel_perfil_preparoLote $objRel_perfil_preparoLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rel_perfil_preparolote WHERE idRelPerfilPreparoLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRel_perfil_preparoLote->getIdRelPerfilPreparoLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o relacionamento do tubo com um dos seus lotes no BD.",$ex);
        }
    }

}
