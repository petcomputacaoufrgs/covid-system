<?php

require_once __DIR__ . '/../Banco/Banco.php';
class MontagemGrupoBD
{

    public function listar_completo(MontagemGrupo $montagemGrupo, Banco $objBanco) {
        try{

            $SELECT ="select max(idInfosTubo), idTubo_fk from tb_infostubo GROUP by idTubo_fk"; //maior infotubo q vai ter a informacao mais recente
            $arr = $objBanco->consultarSQL($SELECT);
            //print_r($arr);


            $interrogacoes_infos = '';
            $strInfos = '';
            foreach ($arr as $a){
                $strInfos .= $a['max(idInfosTubo)'] .",";
                $interrogacoes_infos .= "?,";
            }

            $strInfos = substr($strInfos, 0, -1);
            $interrogacoes_infos = substr($interrogacoes_infos, 0, -1);


            $tam = count($montagemGrupo->getArrIdsPerfis());
            $interrogacoes = '';
            for($i=0; $i<$tam; $i++){
                $interrogacoes .= '?';
                if($tam > 1){
                    $interrogacoes.= ',';
                }
            }
            if($tam > 1) {
                $interrogacoes = substr($interrogacoes, 0, -1);
            }

            $SELECT = 'select DISTINCT tb_tubo.idTubo 
                    from tb_amostra,tb_tubo,tb_infostubo,tb_perfilpaciente 
                    where tb_infostubo.idTubo_fk = tb_tubo.idTubo
            and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
            and tb_infostubo.idInfosTubo in ('.$interrogacoes_infos.')
            and tb_infostubo.etapa = ?
            and tb_infostubo.situacaoEtapa = ?
            and tb_infostubo.situacaoTubo = ?
            and tb_perfilpaciente.idPerfilPaciente in ('.$interrogacoes.')
            and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk 
                    order by tb_amostra.dataColeta LIMIT ?';
            $arrayBind = array();
            foreach($arr as $a){
                $arrayBind[] = array('i', $a['max(idInfosTubo)']);
            }

            $arrayBind[] = array('s', InfosTuboRN::$TP_MONTAGEM_GRUPOS_AMOSTRAS);
            $arrayBind[] = array('s', InfosTuboRN::$TSP_AGUARDANDO);
            $arrayBind[] = array('s', InfosTuboRN::$TST_SEM_UTILIZACAO);

            $tam = count($montagemGrupo->getArrIdsPerfis());
            for($i=0; $i<$tam; $i++){
                $arrayBind[] = array('i', $montagemGrupo->getArrIdsPerfis()[$i]);
            }
            $arrayBind[] = array('i', $montagemGrupo->getQntAmostras());
            $arr_idsTubos = $objBanco->consultarSQL($SELECT, $arrayBind);


            $strIds = '';
            $interrogacoes = '';
            foreach ($arr_idsTubos as $id){
                $strIds .= $id['idTubo'].",";
                $interrogacoes .= '?,';
            }

            $strIdsResultado = substr($strIds, 0,-1);

            $interrogacoes = substr($interrogacoes, 0, -1);
            if(count($arr_idsTubos) > 0) {
                $SELECT = 'select DISTINCT
                        tb_amostra.idAmostra,
                        tb_amostra.codigoAmostra,
                        tb_amostra.dataColeta,
                        tb_amostra.nickname,
                        tb_tubo.idTubo,
                        tb_tubo.tuboOriginal,
                        tb_tubo.tipo as tipoTubo,
                        tb_perfilpaciente.idPerfilPaciente,
                        tb_perfilpaciente.caractere
                    from tb_amostra,tb_tubo,tb_infostubo,tb_perfilpaciente
                    where tb_infostubo.idTubo_fk  = tb_tubo.idTubo
                    and tb_tubo.idAmostra_fk = tb_amostra.idAmostra
                    and tb_perfilpaciente.idPerfilPaciente = tb_amostra.idPerfilPaciente_fk
                    and tb_tubo.idTubo = tb_infostubo.idTubo_fk
                    and tb_tubo.idTubo in (' . $interrogacoes . ')
                    order by tb_amostra.dataColeta
                     ';

                $arrayBind = array();
                foreach ($arr_idsTubos as $id) {
                    $arrayBind[] = array('i', $id['idTubo']);

                }
                $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

                if (count($arr) > 0) {
                    $array_montagem = array();
                    foreach ($arr as $reg) {
                        $montagemGrupo = new MontagemGrupo();

                        $objAmostra = new Amostra();
                        $objAmostra->setIdAmostra($reg['idAmostra']);
                        $objAmostra->setCodigoAmostra($reg['codigoAmostra']);
                        $objAmostra->setDataColeta($reg['dataColeta']);
                        $objAmostra->setNickname($reg['nickname']);


                        $objPerfilPaciente = new PerfilPaciente();
                        $objPerfilPaciente->setIdPerfilPaciente($reg['idPerfilPaciente']);
                        $objPerfilPaciente->setCaractere($reg['caractere']);
                        $montagemGrupo->setPerfilPaciente($objPerfilPaciente);

                        $objTubo = new Tubo();
                        $objTubo->setIdTubo($reg['idTubo']);
                        $objTubo->setIdAmostra_fk($reg['idAmostra']);
                        $objTubo->setTuboOriginal($reg['tuboOriginal']);
                        $objTubo->setTipo($reg['tipoTubo']);


                        $objAmostra->setObjTubo($objTubo);
                        $montagemGrupo->setAmostra($objAmostra);

                        $objAmostra->setCodigoAmostra($reg['codigoAmostra']);

                        $montagemGrupo->setAmostra($objAmostra);

                        $array_montagem[] = $montagemGrupo;
                    }
                    return $array_montagem;
                }
            }
            return null;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando a amostra no BD.",$ex);
        }

    }
}