<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class LoteBD{

    public function cadastrar(Lote $objLote, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_lote (
                            qntAmostrasDesejadas,
                            qntAmostrasAdquiridas,
                            tipo,
                            situacaoLote
                            ) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getQntAmostrasDesejadas());
            $arrayBind[] = array('i',$objLote->getQntAmostrasAdquiridas());
            $arrayBind[] = array('s',$objLote->getTipo());
            $arrayBind[] = array('s',$objLote->getSituacaoLote());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLote->setIdLote($objBanco->obterUltimoID());
            return $objLote;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o lote no BD.",$ex);
        }

    }

    public function alterar(Lote $objLote, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_lote SET '
                . ' qntAmostrasDesejadas = ?,'
                . ' qntAmostrasAdquiridas = ?,'
                . ' tipo = ?,'
                . ' situacaoLote = ?'
                . '  where idLote = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getQntAmostrasDesejadas());
            $arrayBind[] = array('i',$objLote->getQntAmostrasAdquiridas());
            $arrayBind[] = array('s',$objLote->getTipo());
            $arrayBind[] = array('s',$objLote->getSituacaoLote());

            $arrayBind[] = array('i',$objLote->getIdLote());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando o lote no BD.",$ex);
        }

    }

    public function listar(Lote $objLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_lote";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objLote->getSituacaoLote() != null) {
                $WHERE .= $AND . " situacaoLote = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getSituacaoLote());
            }

            if ($objLote->getQntAmostrasDesejadas()!= null) {
                $WHERE .= $AND . " qntAmostrasDesejadas = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getQntAmostrasDesejadas());
            }

            if ($objLote->getQntAmostrasAdquiridas()!= null) {
                $WHERE .= $AND . " qntAmostrasAdquiridas = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getQntAmostrasAdquiridas());
            }

            if ($objLote->getTipo()!= null) {
                $WHERE .= $AND . " tipo = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objLote->getTipo());
            }



            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objLote = new Lote();
                $objLote->setIdLote($reg['idLote']);
                $objLote->setQntAmostrasDesejadas($reg['qntAmostrasDesejadas']);
                $objLote->setQntAmostrasAdquiridas($reg['qntAmostrasAdquiridas']);
                $objLote->setSituacaoLote($reg['situacaoLote']);
                $objLote->setTipo($reg['tipo']);

                $array[] = $objLote;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando o lote no BD.",$ex);
        }

    }

    public function consultar(Lote $objLote, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_lote WHERE idLote = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getIdLote());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $lote = new Lote();
            $lote->setIdLote($arr[0]['idLote']);
            $lote->setQntAmostrasDesejadas($arr[0]['qntAmostrasDesejadas']);
            $lote->setQntAmostrasAdquiridas($arr[0]['qntAmostrasAdquiridas']);
            $lote->setSituacaoLote($arr[0]['situacaoLote']);
            $lote->setTipo($arr[0]['tipo']);

            return $lote;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando o lote no BD.",$ex);
        }

    }



    public function remover(Lote $objLote, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_lote WHERE idLote = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objLote->getIdLote());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o lote no BD.",$ex);
        }
    }


    public function consultar_perfis(Lote $objLote, Banco $objBanco) {
        try{

            $SELECT = "SELECT DISTINCT tb_perfilpaciente.idPerfilPaciente 
                        from tb_rel_perfil_preparolote, tb_perfilpaciente, tb_preparo_lote, tb_lote 
                        where tb_lote.idLote = ? 
                        AND tb_preparo_lote.idLote_fk = tb_lote.idLote 
                        and tb_rel_perfil_preparolote.idPreparoLote_fk = tb_preparo_lote.idPreparoLote 
                        AND tb_rel_perfil_preparolote.idPerfilPaciente_fk = tb_perfilpaciente.idPerfilPaciente";

            $arrayBind = array();
            $arrayBind[] = array('i', $objLote->getIdLote());
            $arr = $objBanco->consultarSQL($SELECT , $arrayBind);
            $arr_perfis = array();

            foreach ($arr as $reg){
                $objPerfilPaciente = new PerfilPaciente();
                $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                $arr_perfis[] = $objPerfilPaciente;
            }

            return $arr_perfis;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando os perfis do lote no BD.",$ex);
        }

    }



}
