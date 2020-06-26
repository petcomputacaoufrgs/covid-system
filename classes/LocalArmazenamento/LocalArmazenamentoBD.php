<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class LocalArmazenamentoBD{

    public function cadastrar(LocalArmazenamentoTexto $objLocalArmazenamento, Banco $objBanco) {
        try{
            //echo $objLocalArmazenamento->getLocalArmazenamento();
            //die("die");
            $INSERT = 'INSERT INTO tb_local_armazenamento (idTipoLocalArmazenamento_fk,nome) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocal());
            $arrayBind[] = array('s',$objLocalArmazenamento->getNome());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objLocalArmazenamento->setIdLocalArmazenamento($objBanco->obterUltimoID());
            return $objLocalArmazenamento;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrando armazenamento  no BD.",$ex);
        }
        
    }
    
    public function alterar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
        try{
            $UPDATE = 'UPDATE tb_local_armazenamento SET '
                    . ' nome = ? ,'
                    . 'idTipoLocalArmazenamento_fk =?'
                . '  where idLocalArmazenamento = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('s',$objLocalArmazenamento->getNome());
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento_fk());


            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Throwable $ex) {
            throw new Excecao("Erro alterando armazenamento no BD.",$ex);
        }
       
    }
    
     public function listar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_local_armazenamento";

             $WHERE = '';
             $AND = '';
             $arrayBind = array();

             if ($objLocalArmazenamento->getIdTipoLocalArmazenamento_fk() != null) {
                 $WHERE .= $AND . " idTipoLocalArmazenamento_fk = ?";
                 $AND = ' and ';
                 $arrayBind[] = array('i', $objLocalArmazenamento->getIdTipoLocalArmazenamento_fk());
             }

             if ($objLocalArmazenamento->getNome() != null) {
                 $WHERE .= $AND . " nome LIKE ? ";
                 $AND = ' and ';
                 $arrayBind[] = array('s', "%".$objLocalArmazenamento->getNome()."%");
             }

             if ($WHERE != '') {
                 $WHERE = ' where ' . $WHERE;
             }

             $arr = $objBanco->consultarSQL($SELECT . $WHERE, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objLocalArmazenamento = new LocalArmazenamento();
                $objLocalArmazenamento->setIdLocalArmazenamento($reg['idLocalArmazenamento']);
                $objLocalArmazenamento->setIdTipoLocalArmazenamento_fk($reg['idTipoLocalArmazenamento_fk']);
                $objLocalArmazenamento->setNome($reg['nome']);

                $array[] = $objLocalArmazenamento;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando armazenamento no BD.",$ex);
        }
       
    }
    
    public function consultar(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_local_armazenamento WHERE idLocalArmazenamento = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);


            $localArmazenamento = new LocalArmazenamento();
            $localArmazenamento->setIdLocalArmazenamento($arr[0]['idLocalArmazenamento']);
            $localArmazenamento->setIdTipoLocalArmazenamento_fk($arr[0]['idTipoLocalArmazenamento_fk']);
            $localArmazenamento->setNome($arr[0]['nome']);
            return  $localArmazenamento ;

        } catch (Throwable $ex) {
       
            throw new Excecao("Erro consultando armazenamento no BD.",$ex);
        }

    }
    
    public function remover(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_local_armazenamento WHERE idLocalArmazenamento = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objLocalArmazenamento->getIdLocalArmazenamento());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Throwable $ex) {
            throw new Excecao("Erro removendo armazenamento no BD.",$ex);
        }
    }

    public function existe(LocalArmazenamento $objLocalArmazenamento, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_local_armazenamento ";

            $WHERE = '';
            $AND = '';
            $arrayBind = array();

            if ($objLocalArmazenamento->getIdTipoLocalArmazenamento_fk() != null) {
                $WHERE .= $AND . " idTipoLocalArmazenamento_fk = ?";
                $AND = ' and ';
                $arrayBind[] = array('i', $objLocalArmazenamento->getIdTipoLocalArmazenamento_fk());
            }

            if ($WHERE != '') {
                $WHERE = ' where ' . $WHERE;
            }

            //echo $SELECT . $WHERE." LIMIT 1 ";
            //die();
            $arr = $objBanco->consultarSQL($SELECT . $WHERE." LIMIT 1 ", $arrayBind);



            $array = array();
            foreach ($arr as $reg){
                $objLocalArmazenamento = new LocalArmazenamento();
                $objLocalArmazenamento->setIdLocalArmazenamento($reg['idLocalArmazenamento']);
                $objLocalArmazenamento->setIdTipoLocalArmazenamento_fk($reg['idTipoLocalArmazenamento_fk']);
                $objLocalArmazenamento->setNome($reg['nome']);

                $array[] = $objLocalArmazenamento;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando armazenamento no BD.",$ex);
        }

    }


    public function pegar_valores(LocalArmazenamento $objLocalArmazenamento,$qntLugares, Banco $objBanco) {
        try{

            $SELECT = "select DISTINCT tb_local_armazenamento.idLocalArmazenamento,
                                    tb_local_armazenamento.nome, 
                                    tb_caixa.idCaixa, 
                                    tb_posicao_caixa.idPosicaoCaixa,
                                    tb_posicao_caixa.linha, 
                                    tb_posicao_caixa.coluna 
                    from tb_local_armazenamento, tb_tipo_localarmazenamento,tb_porta,tb_prateleira,tb_coluna,tb_caixa,tb_posicao_caixa
                    where tb_local_armazenamento.idTipoLocalArmazenamento_fk = tb_tipo_localarmazenamento.idTipoLocalArmazenamento 
                    and tb_tipo_localarmazenamento.caractereTipo = ?
                    and tb_local_armazenamento.idLocalArmazenamento = tb_porta.idLocalArmazenamento_fk 
                    and tb_porta.idPorta = tb_prateleira.idPorta_fk 
                    and tb_prateleira.idPrateleira = tb_coluna.idPrateleira_fk 
                    and tb_coluna.idColuna = tb_caixa.idColuna_fk 
                    and tb_posicao_caixa.idCaixa_fk = tb_caixa.idCaixa 
                    and tb_posicao_caixa.situacaoPosicao = ? 
                    LIMIT ".$qntLugares."
                    for update 
                    ";


            $arrayBind = array();
            $arrayBind[] = array('s', TipoLocalArmazenamentoRN::$TL_BANCO_AMOSTRAS);
            $arrayBind[] = array('s', PosicaoRN::$TSP_LIBERADA);

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $array = array();
            foreach ($arr as $reg){
                $objLocalArmazenamento = new LocalArmazenamento();
                $objLocalArmazenamento->setIdLocalArmazenamento($reg['idLocalArmazenamento']);
                $objLocalArmazenamento->setNome($reg['nome']);

                $objPosicao = new Posicao();
                $objPosicaoRN = new PosicaoRN();
                $objPosicao->setIdPosicaoCaixa($reg['idPosicaoCaixa']);
                $objPosicao->setLinha($reg['linha']);
                $objPosicao->setColuna($reg['coluna']);
                $objPosicao->setSituacaoPosicao(PosicaoRN::$TSP_OCUPADA);
                $objPosicao->setIdCaixa_fk($reg['idCaixa']);
                $objPosicaoRN->alterar($objPosicao);

                $objCaixa = new Caixa();
                $objCaixa->setIdCaixa($reg['idCaixa']);
                $objPosicao->setObjCaixa($objCaixa);

                $objLocalArmazenamento->setObj($objPosicao);

                $array[] = $objLocalArmazenamento;
            }
            return $array;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listando armazenamento no BD.",$ex);
        }

    }
      
    

    
}
