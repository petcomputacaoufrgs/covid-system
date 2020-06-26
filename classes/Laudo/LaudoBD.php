<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class LaudoBD
{
    public function cadastrar(Laudo $objLaudo, Banco $objBanco) {
        try{

            $INSERT = 'INSERT INTO tb_laudo (idAmostra_fk, idUsuario_fk, observacoes, resultado, situacao,dataHoraGeracao, dataHoraLiberacao) 
                        VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
            $arrayBind[] = array('i',$objLaudo->getIdUsuarioFk());
            $arrayBind[] = array('s',$objLaudo->getObservacoes());
            $arrayBind[] = array('s',$objLaudo->getResultado());
            $arrayBind[] = array('s',$objLaudo->getSituacao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraGeracao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraLiberacao());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLaudo->setIdLaudo($objBanco->obterUltimoID());
            return $objLaudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando laudo  no BD.",$ex);
        }

    }

    public function alterar(Laudo $objLaudo, Banco $objBanco) {
        try{
            //print_r($objLaudo);
            $UPDATE = 'UPDATE tb_laudo SET '
                . ' idAmostra_fk = ?,'
                . ' idUsuario_fk = ?,'
                . ' observacoes = ?,'
                . ' resultado = ?,'
                . ' situacao = ?,'
                . ' dataHoraGeracao = ?,'
                . ' dataHoraLiberacao = ?'
                . '  where idLaudo = ?';


            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());
            $arrayBind[] = array('i',$objLaudo->getIdUsuarioFk());
            $arrayBind[] = array('s',$objLaudo->getObservacoes());
            $arrayBind[] = array('s',$objLaudo->getResultado());
            $arrayBind[] = array('s',$objLaudo->getSituacao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraGeracao());
            $arrayBind[] = array('s',$objLaudo->getDataHoraLiberacao());

            $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objLaudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando laudo no BD.",$ex);
        }

    }

    public function listar(Laudo $objLaudo, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_laudo";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objLaudo->getSituacao() != null){
                $WHERE .= $AND." situacao = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getSituacao());
            }

            if($objLaudo->getResultado() != null){
                $WHERE .= $AND." resultado = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objLaudo->getResultado());
            }
            if($objLaudo->getIdAmostraFk() != null){
                $WHERE .= $AND." idAmostra_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i',$objLaudo->getIdAmostraFk());

            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);


            $array_laudo = array();
            foreach ($arr as $reg){
                $objLaudo = new Laudo();
                $objLaudo->setIdLaudo($reg['idLaudo']);
                $objLaudo->setIdAmostraFk($reg['idAmostra_fk']);
                $objLaudo->setIdUsuarioFk($reg['idUsuario_fk']);
                $objLaudo->setSituacao($reg['situacao']);
                $objLaudo->setResultado($reg['resultado']);
                $objLaudo->setObservacoes($reg['observacoes']);
                $objLaudo->setDataHoraGeracao($reg['dataHoraGeracao']);
                $objLaudo->setDataHoraLiberacao($reg['dataHoraLiberacao']);


                $select_amostra = "select * from tb_amostra where idAmostra = ?";
                $arrayBind2 = array();
                $arrayBind2[] = array('i',$reg['idAmostra_fk']);
                $objAmostra = $objBanco->consultarSQL($select_amostra,$arrayBind2);

                $objLaudo->setObjAmostra($objAmostra);

                $array_laudo[] = $objLaudo;
            }
            return $array_laudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando laudo no BD.",$ex);
        }

    }

    public function consultar(Laudo $objLaudo, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_laudo WHERE idLaudo = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $laudo = new Laudo();
            $laudo->setIdLaudo($arr[0]['idLaudo']);
            $laudo->setIdAmostraFk($arr[0]['idAmostra_fk']);
            $laudo->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $laudo->setSituacao($arr[0]['situacao']);
            $laudo->setResultado($arr[0]['resultado']);
            $laudo->setObservacoes($arr[0]['observacoes']);
            $laudo->setDataHoraGeracao($arr[0]['dataHoraGeracao']);
            $laudo->setDataHoraLiberacao($arr[0]['dataHoraLiberacao']);

            return $laudo;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultando laudo no BD.",$ex);
        }

    }

    public function remover(Laudo $objLaudo, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_laudo WHERE idLaudo = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdLaudo());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo laudo no BD.",$ex);
        }
    }


    public function laudo_completo(Laudo $objLaudo, Banco $objBanco) {
        try{

            $SELECT = "SELECT tb_amostra.idAmostra,tb_amostra.nickname, tb_paciente.nome,tb_amostra.dataColeta, tb_perfilpaciente.perfil, 
                    tb_laudo.situacao,tb_laudo.dataHoraGeracao, 
                    tb_laudo.dataHoraLiberacao, tb_laudo.idUsuario_fk, tb_laudo.resultado 
                    FROM tb_laudo, tb_amostra, tb_paciente, tb_perfilpaciente
                    where tb_laudo.idLaudo = ?
                    and tb_amostra.idPaciente_fk = tb_paciente.idPaciente
                    and tb_laudo.idAmostra_fk = tb_amostra.idAmostra
                    and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk";

            $arrayBind = array();
            $arrayBind[] = array('i',$objLaudo->getIdLaudo());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
            //print_r($arr);


            $objLaudo->setIdAmostraFk($arr[0]['idAmostra_fk']);
            $objLaudo->setIdUsuarioFk($arr[0]['idUsuario_fk']);
            $objLaudo->setSituacao($arr[0]['situacao']);
            $objLaudo->setResultado($arr[0]['resultado']);
            $objLaudo->setObservacoes($arr[0]['observacoes']);
            $objLaudo->setDataHoraGeracao($arr[0]['dataHoraGeracao']);
            $objLaudo->setDataHoraLiberacao($arr[0]['dataHoraLiberacao']);

            $objAmostra = new Amostra();
            $objAmostraRN = new AmostraRN();
            $objAmostra->setIdAmostra($objLaudo->getIdAmostraFk());
            $arrAmostra = $objAmostraRN->listar_completo($objAmostra);
            $objAmostra = $arrAmostra[0];


            /*
            $objPaciente = new Paciente();
            $objPaciente->setNome($arr[0]['nome']);
            $objAmostra->setObjPerfil($arr[0]['perfil']);


            $SELECT2 = "select tb_codgal.codigo from tb_codgal, tb_paciente,tb_amostra where
                        tb_paciente.nome = ? 
                        and tb_paciente.idPaciente = tb_codgal.idPaciente_fk
                        and tb_amostra.idCodGAL_fk = tb_codgal.idCodGAL";

            $arrayBind = array();
            $arrayBind[] = array('s',$arr[0]['nome']);

            $arr2 = $objBanco->consultarSQL($SELECT2,$arrayBind);

            $objPaciente->setObjCodGAL($arr2[0]['codigo']);
            $objAmostra->setObjPaciente($objPaciente);
            */
            $objLaudo->setObjAmostra($objAmostra);

            return $objLaudo;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando laudo no BD.",$ex);
        }

    }
}