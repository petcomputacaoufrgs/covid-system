<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

require_once __DIR__ . '/../Protocolo/ProtocoloRN.php';
require_once __DIR__ . '/../Protocolo/Protocolo.php';

class PlacaBD
{
    public function cadastrar(Placa $objPlaca, Banco $objBanco) {
        try{

            //die("die");
            $INSERT = 'INSERT INTO tb_placa (placa, index_placa,situacaoPlaca,idProtocolo_fk) VALUES (?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getPlaca());
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arrayBind[] = array('s',$objPlaca->getSituacaoPlaca());
            $arrayBind[] = array('i',$objPlaca->getIdProtocoloFk());

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPlaca->setIdPlaca($objBanco->obterUltimoID());
            return $objPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando o placa no BD.",$ex);
        }

    }

    public function alterar(Placa $objPlaca, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_placa SET '
                . ' placa = ?,'
                . ' index_placa = ?,'
                . ' situacaoPlaca = ?,'
                . ' idProtocolo_fk = ?'
                . '  where idPlaca = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getPlaca());
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arrayBind[] = array('s',$objPlaca->getSituacaoPlaca());
            $arrayBind[] = array('i',$objPlaca->getIdProtocoloFk());

            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objPlaca;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando a placa no BD.",$ex);
        }

    }

    public function listar(Placa $objPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPlaca->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPlaca->getIdProtocoloFk());
            }

            if ($objPlaca->getIndexPlaca() != null) {
                $WHERE .= $AND . " index_placa = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPlaca->getIndexPlaca());
            }

            if ($objPlaca->getSituacaoPlaca() != null) {
                $WHERE .= $AND . " situacaoPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPlaca->getSituacaoPlaca());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array_placa = array();
            foreach ($arr as $reg){
                $placa = new Placa();
                $placa->setIdPlaca($reg['idPlaca']);
                $placa->setPlaca($reg['placa']);
                $placa->setIdProtocoloFk($reg['idProtocolo_fk']);
                $placa->setIndexPlaca($reg['index_placa']);
                $placa->setSituacaoPlaca($reg['situacaoPlaca']);

                $select_protocolo = 'select * from tb_protocolo where idProtocolo = ?';
                $arrayBind2 = array();
                $arrayBind2[] = array('i', $reg['idProtocolo_fk']);
                $protocolo = $objBanco->consultarSQL($select_protocolo, $arrayBind2);

                $placa->setObjProtocolo($protocolo);

                $array_placa[] = $placa;
            }
            return $array_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as placas no BD.",$ex);
        }

    }

    public function listar_completo(Placa $objPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objPlaca->getIdProtocoloFk() != null) {
                $WHERE .= $AND . " idProtocolo_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPlaca->getIdProtocoloFk());
            }

            if ($objPlaca->getIdPlaca() != null) {
                $WHERE .= $AND . " idPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objPlaca->getIdPlaca());
            }

            if ($objPlaca->getIndexPlaca() != null) {
                $WHERE .= $AND . " index_placa = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPlaca->getIndexPlaca());
            }

            if ($objPlaca->getSituacaoPlaca() != null) {
                $WHERE .= $AND . " situacaoPlaca = ?";
                $AND = ' and ';
                $arrayBind[] = array('s', $objPlaca->getSituacaoPlaca());
            }


            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }


            $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);


            $array_placa = array();
            foreach ($arr as $reg){
                $placa = new Placa();
                $placa->setIdPlaca($reg['idPlaca']);
                $placa->setPlaca($reg['placa']);
                $placa->setIdProtocoloFk($reg['idProtocolo_fk']);
                $placa->setIndexPlaca($reg['index_placa']);
                $placa->setSituacaoPlaca($reg['situacaoPlaca']);

                $objProtocolo = new Protocolo();
                $objProtocoloRN = new ProtocoloRN();
                $objProtocolo->setIdProtocolo($placa->getIdProtocoloFk());
                $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
                $placa->setObjProtocolo($objProtocolo);

                $objRelTuboPlaca = new RelTuboPlaca();
                $objRelTuboPlacaRN = new RelTuboPlacaRN();
                $objRelTuboPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arr_tubos = $objRelTuboPlacaRN->listar_completo($objRelTuboPlaca);
                $placa->setObjsTubos($arr_tubos);

                $objRelPerfilPlaca = new RelPerfilPlaca();
                $objRelPerfilPlacaRN = new RelPerfilPlacaRN();
                $objRelPerfilPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arr_perfis = $objRelPerfilPlacaRN->listar($objRelPerfilPlaca);
                $placa->setObjRelPerfilPlaca($arr_perfis);

                $objPocoPlaca = new PocoPlaca();
                $objPocoPlacaRN = new PocoPlacaRN();
                $objPocoPlaca->setIdPlacaFk($placa->getIdPlaca());
                $arrPocosPlaca = $objPocoPlacaRN->listar_completo($objPocoPlaca);
                $placa->setObjsPocosPlacas($arrPocosPlaca);



                $array_placa[] = $placa;
            }
            return $array_placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando as placas completas no BD.",$ex);
        }

    }

    public function consultar(Placa $objPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_placa WHERE idPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            if(count($arr) >0 ) {
                $placa = new Placa();
                $placa->setIdPlaca($arr[0]['idPlaca']);
                $placa->setPlaca($arr[0]['placa']);
                $placa->setIndexPlaca($arr[0]['index_placa']);
                $placa->setSituacaoPlaca($arr[0]['situacaoPlaca']);
                $placa->setIdProtocoloFk($arr[0]['idProtocolo_fk']);
                return $placa;
            }


        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a placa no BD.",$ex);
        }

    }

    public function consultar_completo(Placa $objPlaca, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_placa WHERE idPlaca = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $placa = new Placa();
            $placa->setIdPlaca($arr[0]['idPlaca']);
            $placa->setPlaca($arr[0]['placa']);
            $placa->setIndexPlaca($arr[0]['index_placa']);
            $placa->setSituacaoPlaca($arr[0]['situacaoPlaca']);
            $placa->setIdProtocoloFk($arr[0]['idProtocolo_fk']);

            $SELECT_PROTOCOLO = 'SELECT * FROM tb_protocolo WHERE idProtocolo = ?';

            $arrayBindProtocolo = array();
            $arrayBindProtocolo[] = array('i',$arr[0]['idProtocolo_fk']);

            $arr = $objBanco->consultarSQL($SELECT_PROTOCOLO,$arrayBindProtocolo);

            $protocolo = new Protocolo();
            $protocolo->setIdProtocolo($arr[0]['idProtocolo']);
            $protocolo->setProtocolo($arr[0]['protocolo']);
            $protocolo->setIndexProtocolo($arr[0]['index_protocolo']);
            $protocolo->setNumMaxAmostras($arr[0]['numMax_amostras']);
            $protocolo->setCaractere($arr[0]['caractere']);
            $protocolo->setNumDivisoes($arr[0]['numDivisoes']);

            $SELECT_DIVISOES = 'SELECT * FROM tb_divisao_protocolo WHERE idProtocolo_fk = ?';

            $arrayBindDivisoes = array();
            $arrayBindDivisoes[] = array('i', $arr[0]['idProtocolo']);

            $arr = $objBanco->consultarSQL($SELECT_DIVISOES, $arrayBindDivisoes);

            $arr_divs = array();
            foreach ($arr as $reg){
                $divisaoProtocolo = new DivisaoProtocolo();
                $divisaoProtocolo->setIdDivisaoProtocolo($reg['idDivisaoProtocolo']);
                $divisaoProtocolo->setIdProtocoloFk($reg['idProtocolo_fk']);
                $divisaoProtocolo->setNomeDivisao($reg['nomeDivisao']);
                $arr_divs[] = $divisaoProtocolo;
            }
            $protocolo->setObjDivisao($arr_divs);


            $SELECT = 'SELECT * FROM tb_rel_tubo_placa WHERE idPlaca_fk = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $arr_tubos = array();
            $array_amostras = array();
            foreach ($arr as $reg) {
                $tuboPlaca = new RelTuboPlaca();
                $tuboPlaca->setIdRelTuboPlaca($reg['idRelTuboPlaca']);
                $tuboPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $tuboPlaca->setIdTuboFk($reg['idTubo_fk']);
                $arr_tubos[] = $tuboPlaca;

                $SELECT_AMOSTRA = 'SELECT *  FROM tb_amostra,tb_tubo WHERE tb_amostra.idAmostra = tb_tubo.idAmostra_fk
                and tb_tubo.idTubo = ?';

                $arrayBind = array();
                $arrayBind[] = array('i',$reg['idTubo_fk']);

                $arr_amostra = $objBanco->consultarSQL($SELECT_AMOSTRA,$arrayBind);

                if(count($arr_amostra) > 0){
                    $objTuboaux = new Tubo();
                    $objTuboaux->setIdTubo($arr_amostra[0]['idTubo']);
                    $objTuboaux->setIdTubo_fk($arr_amostra[0]['idTubo_fk']);
                    $objTuboaux->setIdAmostra_fk($arr_amostra[0]['idAmostra_fk']);
                    $objTuboaux->setTuboOriginal($arr_amostra[0]['tuboOriginal']);
                    $objTuboaux->setTipo($arr_amostra[0]['tipo']);


                    $objAmostra = new Amostra();
                    $objAmostra->setIdAmostra($arr_amostra[0]['idAmostra']);
                    $objAmostra->setIdPaciente_fk($arr_amostra[0]['idPaciente_fk']);
                    $objAmostra->setIdCodGAL_fk($arr_amostra[0]['idCodGAL_fk']);
                    $objAmostra->setIdNivelPrioridade_fk($arr_amostra[0]['idNivelPrioridade_fk']);
                    $objAmostra->setIdPerfilPaciente_fk($arr_amostra[0]['idPerfilPaciente_fk']);
                    $objAmostra->setIdEstado_fk($arr_amostra[0]['cod_estado_fk']);
                    $objAmostra->setIdLugarOrigem_fk($arr_amostra[0]['cod_municipio_fk']);
                    $objAmostra->setObservacoes($arr_amostra[0]['observacoes']);
                    $objAmostra->setDataColeta($arr_amostra[0]['dataColeta']);
                    $objAmostra->set_a_r_g($arr_amostra[0]['a_r_g']);
                    $objAmostra->setHoraColeta($arr_amostra[0]['horaColeta']);
                    $objAmostra->setMotivoExame($arr_amostra[0]['motivo']);
                    $objAmostra->setCEP($arr_amostra[0]['CEP']);
                    $objAmostra->setCodigoAmostra($arr_amostra[0]['codigoAmostra']);
                    $objAmostra->setObsCEP($arr_amostra[0]['obsCEPAmostra']);
                    $objAmostra->setObsHoraColeta($arr_amostra[0]['obsHoraColeta']);
                    $objAmostra->setObsLugarOrigem($arr_amostra[0]['obsLugarOrigem']);
                    $objAmostra->setObsMotivo($arr_amostra[0]['obsMotivo']);
                    $objAmostra->setNickname($arr_amostra[0]['nickname']);
                    $objAmostra->setObjTubo($objTuboaux);
                    $array_amostras[] = $objAmostra;

                }

            }
            $placa->setObjsAmostras($array_amostras);
            $placa->setObjsTubos($arr_tubos);

            $SELECT_POCOS = "SELECT * FROM tb_pocos_placa where idPlaca_fk = ?";
            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSQL($SELECT_POCOS,$arrayBind);

            $array_poco_placa = array();
            foreach ($arr as $reg){
                $pocoPlaca = new PocoPlaca();
                $pocoPlaca->setIdPocosPlaca($reg['idPocosPlaca']);
                $pocoPlaca->setIdPlacaFk($reg['idPlaca_fk']);
                $pocoPlaca->setIdPocoFk($reg['idPoco_fk']);

                $SELECT_POCO = "SELECT * FROM tb_poco where idPoco = ?";
                $arrayBind2 = array();
                $arrayBind2[] = array('i',$reg['idPoco_fk']);

                $p = $objBanco->consultarSQL($SELECT_POCO,$arrayBind2);

                $poco = new Poco();
                $poco->setIdPoco($p[0]['idPoco']);
                $poco->setIdTuboFk($p[0]['idTubo_fk']);
                $poco->setColuna($p[0]['coluna']);
                $poco->setLinha($p[0]['linha']);
                $poco->setSituacao($p[0]['situacao']);
                $poco->setConteudo($p[0]['conteudo']);
                $pocoPlaca->setObjPoco($poco);

                $array_poco_placa[] = $pocoPlaca;
            }
            $placa->setObjsPocosPlacas($array_poco_placa);

            $placa->setObjProtocolo($protocolo);

            return $placa;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a placa no BD.",$ex);
        }

    }

    public function remover(Placa $objPlaca, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_placa WHERE idPlaca = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo a placa no BD.",$ex);
        }
    }

    public function solicitar_quantidade(Placa $objPlaca,$colunaMin=null, $colunaMax=null,$info_completa=null, Banco $objBanco) {

        try{
            $add_select = '';
            if($colunaMin != null && $colunaMax != null){
                $add_select = ' and tb_poco.coluna >= ?
                                and tb_poco.coluna <= ?';
            }

            $select_quantidades = 'select distinct count(*), tb_poco.conteudo from tb_placa, tb_poco, tb_pocos_placa 
                        where tb_placa.idPlaca = ? 
                        and tb_pocos_placa.idPlaca_fk = tb_placa.idPlaca 
                        and tb_poco.idPoco = tb_pocos_placa.idPoco_fk  
                        and tb_poco.situacao = ? 
                        and tb_poco.conteudo != ? 
                        and tb_poco.conteudo != ? 
                        and tb_poco.conteudo != ? '.
                        $add_select.'
                        group by tb_poco.conteudo having count(*) >=1  ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $arrayBind[] = array('s',PocoRN::$STA_OCUPADO);
            $arrayBind[] = array('s','C-');
            $arrayBind[] = array('s','C+');
            $arrayBind[] = array('s','BR');
            if($colunaMin != null && $colunaMax != null){
                $arrayBind[] = array('i',$colunaMin);
                $arrayBind[] = array('i',$colunaMax);
            }
            $arr = $objBanco->consultarSql($select_quantidades, $arrayBind);


            if(!$info_completa){
                return $arr;
            }


            if($info_completa){
                $select_info = 'select distinct tb_poco.conteudo,tb_poco.linha, tb_poco.coluna 
                from tb_placa, tb_poco, tb_pocos_placa 
                where tb_placa.idPlaca = ? 
                and tb_pocos_placa.idPlaca_fk = tb_placa.idPlaca 
                and tb_poco.idPoco = tb_pocos_placa.idPoco_fk 
                and tb_poco.situacao = ? 
                and tb_poco.conteudo != ? 
                and tb_poco.conteudo != ? 
                and tb_poco.conteudo != ? 
                and tb_poco.coluna >= ? 
                and tb_poco.coluna <= ? ';
                $arr_complementar = $objBanco->consultarSql($select_info, $arrayBind);


                $arr_retorno = array();
                $arr_retorno[0] = $arr;
                foreach ($arr as $a){
                    if($a['count(*)'] > 1){
                        foreach ($arr_complementar as $info){
                            if($info['conteudo'] == $a['conteudo']){
                                $arrinfos[] = array("conteudo" => $a['conteudo'],"linha" =>$info['linha'],"coluna" => $info['coluna']);
                            }
                        }

                    }

                }
                $arr_retorno[1] = $arrinfos;

            }




            return $arr_retorno;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a quantidade de cada amostra na placa de poços no BD.",$ex);
        }
    }


    public function ja_existe_placa(Placa $objPlaca, Banco $objBanco) {

        try{

            $SELECT = "SELECT idPlaca from tb_placa WHERE index_placa = ? and index_placa != '' LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('s',$objPlaca->getIndexPlaca());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }

            return false;

        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se já existe uma placa no BD.",$ex);
        }
    }


    public function existe_placa_com_o_placa(Placa $objPlaca, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_placa,tb_placa  
                        where tb_placa.idPlaca_fk = tb_placa.idPlaca 
                        and tb_placa.idPlaca = ?
                        LIMIT 1";

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(count($arr) > 0){
                return true;
            }
            return false;
        } catch (Throwable $ex) {
            throw new Excecao("Erro verificando se existe uma placa com o placa no BD.",$ex);
        }

    }


    public function consultar_tubos_inexistentes(Placa $objPlaca,$colunaMin=null, $colunaMax=null, Banco $objBanco) {

        try{
            $nicknames = array();

            $select_quantidades = 'select tb_rel_tubo_placa.idTubo_fk from tb_rel_tubo_placa 
            where tb_rel_tubo_placa.idTubo_fk not in 
                ( select tb_rel_tubo_placa.idTubo_fk 
                from tb_pocos_placa,tb_rel_tubo_placa ,tb_poco, tb_amostra,tb_placa,tb_tubo 
                where tb_pocos_placa.idPoco_fk = tb_poco.idPoco 
                and tb_amostra.nickname = tb_poco.conteudo 
                and tb_pocos_placa.idPlaca_fk = tb_placa.idPlaca 
                and tb_placa.idPlaca = ? 
                and tb_amostra.idAmostra = tb_tubo.idAmostra_fk 
                and tb_tubo.idTubo = tb_rel_tubo_placa.idTubo_fk 
                and tb_rel_tubo_placa.idPlaca_fk = ? 
                and tb_poco.coluna >= ? and tb_poco.coluna <= ?) 
            and tb_rel_tubo_placa.idPlaca_fk = ?  ';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());
            $arrayBind[] = array('i',$colunaMin);
            $arrayBind[] = array('i',$colunaMax);
            $arrayBind[] = array('i',$objPlaca->getIdPlaca());

            $arr = $objBanco->consultarSql($select_quantidades, $arrayBind);

            foreach ($arr as $t){
                $select_amostra = 'select tb_amostra.nickname from tb_amostra,tb_tubo where tb_tubo.idTubo = ?
                and tb_amostra.idAmostra = tb_tubo.idAmostra_fk';
                $arrayBind = array();
                $arrayBind[] = array('i',$t['idTubo_fk']);
                $amostra = $objBanco->consultarSql($select_amostra, $arrayBind);

                $nicknames[] = $amostra[0];
            }

            return $nicknames;
        } catch (Throwable $ex) {
            throw new Excecao("Erro consultando a quantidade de cada amostra na placa de poços no BD.",$ex);
        }
    }


    public function remover_amostras(Placa $objPlaca, Banco $objBanco) {

        try{
            foreach ($objPlaca->getObjsAmostras() as $amostra) {
                $select = 'SELECT * FROM tb_poco,tb_placa,tb_pocos_placa 
                        where tb_poco.conteudo = ? 
                        and tb_pocos_placa.idPoco_fk = tb_poco.idPoco 
                        and tb_pocos_placa.idPlaca_fk = tb_placa.idPlaca 
                        and tb_placa.idPlaca = ? ';

                $arrayBind = array();
                $arrayBind[] = array('s', $amostra->getNickname());
                $arrayBind[] = array('i', $objPlaca->getIdPlaca());
                $arr = $objBanco->consultarSql($select, $arrayBind);

                foreach ($arr as $reg){
                    $update = 'update tb_poco set conteudo = null where idPoco = ?';
                    $arrayBindPoco = array();
                    $arrayBindPoco[] = array('i',$reg['idPoco']);
                    $objBanco->executarSql($update, $arrayBindPoco);

                }
            }

        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo o poço no BD.",$ex);
        }
    }




}