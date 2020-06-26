<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';

class KitExtracaoBD
{
    public function cadastrar(KitExtracao $objKitExtracao, Banco $objBanco) {
        try{
            //echo $objDetentor->getDetentor();
            //die("die");
            $INSERT = 'INSERT INTO tb_kits_extracao (nome,index_nome) VALUES (?,?)';

            $arrayBind = array();
            $arrayBind[] = array('s',$objKitExtracao->getNome());
            $arrayBind[] = array('s',$objKitExtracao->getIndexNome());


            $objBanco->executarSQL($INSERT,$arrayBind);
            $objKitExtracao->setIdKitExtracao($objBanco->obterUltimoID());
            return $objKitExtracao;
        } catch (Throwable $ex) {
            throw new Excecao("Erro cadastrandos kits de extração  no BD.",$ex);
        }

    }

    public function alterar(KitExtracao $objKitExtracao, Banco $objBanco) {
        try{
            //print_r($objDetentor);
            $UPDATE = 'UPDATE tb_kits_extracao SET '
                . ' nome = ?,'
                . ' index_nome = ?'
                . '  where idDetentor = ?';


            $arrayBind = array();
            $arrayBind[] = array('s',$objKitExtracao->getNome());
            $arrayBind[] = array('s',$objKitExtracao->getIndexNome());
            $arrayBind[] = array('i',$objKitExtracao->getIdKitExtracao());

            $objBanco->executarSQL($UPDATE,$arrayBind);
            return $objKitExtracao;
        } catch (Throwable $ex) {
            throw new Excecao("Erro alterandos kits de extração no BD.",$ex);
        }

    }

    public function listar(KitExtracao $objKitExtracao, Banco $objBanco) {
        try{

            $SELECT = "SELECT * FROM tb_kits_extracao";


            $WHERE = '';
            $AND = '';
            $arrayBind = array();
            if($objKitExtracao->getIndexNome() != null){
                $WHERE .= $AND." index_nome = ?";
                $AND = ' and ';
                $arrayBind[] = array('s',$objKitExtracao->getIndexNome());
            }


            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            }

            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);


            $array_kits_extracao = array();
            foreach ($arr as $reg){
                $kitExtracao = new KitExtracao();
                $kitExtracao->setIndexNome($reg['index_nome']);
                $kitExtracao->setIdKitExtracao($reg['idKitExtracao']);
                $kitExtracao->setNome($reg['nome']);

                $array_kits_extracao[] = $kitExtracao;
            }
            return $array_kits_extracao;
        } catch (Throwable $ex) {
            throw new Excecao("Erro listandos kits de extração no BD.",$ex);
        }

    }

    public function consultar(KitExtracao $objKitExtracao, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_kits_extracao WHERE idKitExtracao = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objKitExtracao->getIdKitExtracao());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $kitExtracao = new KitExtracao();
            $kitExtracao->setIdKitExtracao($arr[0]['idKitExtracao']);
            $kitExtracao->setIndexNome($arr[0]['index_nome']);
            $kitExtracao->setNome($arr[0]['nome']);

            return $kitExtracao;
        } catch (Throwable $ex) {

            throw new Excecao("Erro consultandos kits de extração no BD.",$ex);
        }

    }

    public function remover(KitExtracao $objKitExtracao, Banco $objBanco) {

        try{

            $DELETE = 'DELETE FROM tb_kits_extracao WHERE idKitExtracao = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objKitExtracao->getIdKitExtracao());
            $objBanco->executarSQL($DELETE, $arrayBind);

        } catch (Throwable $ex) {
            die($ex);
            throw new Excecao("Erro removendo os kits de extração no BD.",$ex);
        }
    }

    public function pesquisar_index(KitExtracao $objKitExtracao, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * from tb_kits_extracao WHERE index_detentor = ?';

            $arrayBind = array();
            $arrayBind[] = array('s',$objKitExtracao->getIndexNome());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(empty($arr)){
                return $arr;
            }
            $arr_kits_extracao = array();

            foreach ($arr as $reg){
                $kitExtracao = new KitExtracao();
                $kitExtracao->setIndexNome($reg['index_nome']);
                $kitExtracao->setIdKitExtracao($reg['idKitExtracao']);
                $kitExtracao->setNome($reg['nome']);
                $arr_kits_extracao[] = $kitExtracao;
            }
            return $arr_kits_extracao;

        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando os kits de extração no BD.",$ex);
        }
    }


    public function validar_cadastro(KitExtracao $objKitExtracao, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * from tb_kits_extracao WHERE index_nome = ? LIMIT 1';

            $arrayBind = array();
            $arrayBind[] = array('s',$objKitExtracao->getIndexNome());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            if(empty($arr)){
                return null;
            }
            $arr_kits_extracao = array();

            foreach ($arr as $reg){
                $kitExtracao = new KitExtracao();
                $kitExtracao->setIndexNome($reg['index_nome']);
                $kitExtracao->setIdKitExtracao($reg['idKitExtracao']);
                $kitExtracao->setNome($reg['nome']);
                $arr_kits_extracao[] = $kitExtracao;
            }
            return $arr_kits_extracao;

        } catch (Throwable $ex) {
            throw new Excecao("Erro pesquisando os kits de extração no BD.",$ex);
        }
    }
}