<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class RelPerfilPlacaBD
{
    public function cadastrar(RelPerfilPlaca $objRelPerfilPlaca, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_rel_perfil_placa (
                            idPlaca_fk,
                            idPerfil_fk
                            ) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdPerfilFk());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objRelPerfilPlaca->setIdRelPerfilPlaca($objBanco->obterUltimoID());
            return $objRelPerfilPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function alterar(RelPerfilPlaca $objRelPerfilPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_rel_perfil_placa SET '
                . ' idPlaca_fk = ?,'
                . ' idPerfil_fk = ?'
                . '  where idRelPerfilPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdPlacaFk());
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdPerfilFk());
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdRelPerfilPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objRelPerfilPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function listar(RelPerfilPlaca $objRelPerfilPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_rel_perfil_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objRelPerfilPlaca->getIdPerfilFk() != null) {
                $WHERE .= $AND . " idPerfil_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelPerfilPlaca->getIdPerfilFk());
            }

            if ($objRelPerfilPlaca->getIdPlacaFk() != null) {
                $WHERE .= $AND . " idPlaca_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objRelPerfilPlaca->getIdPlacaFk());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $perfiPlaca = new RelPerfilPlaca();
                $perfiPlaca->setIdRelPerfilPlaca($reg['idRelPerfilPlaca']);
                $perfiPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $perfiPlaca->setIdPerfilFk($reg['idPerfil_fk']);

                $array[] = $perfiPlaca;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function consultar(RelPerfilPlaca $objRelPerfilPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_rel_perfil_placa WHERE idRelPerfilPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdRelTuboLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $perfiPlaca = new RelPerfilPlaca();
            $perfiPlaca->setIdRelPerfilPlaca($arr[0]['idRelPerfilPlaca']);
            $perfiPlaca->setIdPlacaFk($arr[0]['idPlaca_fk']);
            $perfiPlaca->setIdPerfilFk($arr[0]['idPerfil_fk']);

            return $perfiPlaca;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o relacionamento dos perfis com uma placa no BD.",$ex);
        }

    }

    public function remover(RelPerfilPlaca $objRelPerfilPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_rel_perfil_placa WHERE idRelPerfilPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objRelPerfilPlaca->getIdRelPerfilPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o relacionamento dos perfis com uma placa no BD.",$ex);
        }
    }
}