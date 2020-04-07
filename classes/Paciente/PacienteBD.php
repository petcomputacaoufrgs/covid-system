<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Banco/Banco.php';
class PacienteBD{

    public function cadastrar(Paciente $objPaciente, Banco $objBanco) {
        try{
            //echo $objPaciente->getPaciente();
            $INSERT = 'INSERT INTO tb_paciente (idSexo_fk,idPerfilPaciente_fk,nome,nomeMae,CPF,RG,obsCPF,'
                    . 'obsRG,obsSexo,codGAL,dataNascimento,obsNomeMae) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsCPF());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsSexo());
            $arrayBind[] = array('s',$objPaciente->getCodGAL());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            
            

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPaciente->setIdPaciente($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando marca  no BD.",$ex);
        }
        
    }
    
    public function alterar(Paciente $objPaciente, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_paciente SET '
                    . ' idSexo_fk = ?,'
                    . ' idPerfilPaciente_fk = ?,'
                    . ' nome = ?,'
                    . ' nomeMae = ?,'
                    . ' CPF = ?,'
                    . ' RG = ?,'
                    . ' obsCPF = ?,'
                    . ' obsRG = ?,'
                    . ' obsSexo = ?,'
                    . ' codGAL = ?,'
                    . ' dataNascimento = ?,'
                    . ' obsNomeMae = ?'
                . '  where idPaciente = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsCPF());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsSexo());
            $arrayBind[] = array('s',$objPaciente->getCodGAL());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando marca no BD.",$ex);
        }
       
    }
    
     public function listar(Paciente $objPaciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_paciente";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_marca = array();
            foreach ($arr as $reg){
                $objPaciente = new Paciente();
                $objPaciente->setIdPaciente($reg['idPaciente']);
                $objPaciente->setNome($reg['nome']);
                $objPaciente->setIdSexo_fk($reg['idSexo_fk']);
                $objPaciente->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objPaciente->setNomeMae($reg['nomeMae']);
                $objPaciente->setCPF($reg['CPF']);
                $objPaciente->setRG($reg['RG']);
                $objPaciente->setObsCPF($reg['obsCPF']);
                $objPaciente->setObsRG($reg['obsRG']);
                $objPaciente->setObsSexo($reg['obsSexo']);
                $objPaciente->setCodGAL($reg['codGAL']);
                $objPaciente->setDataNascimento($reg['dataNascimento']);
                $objPaciente->setObsNomeMae($reg['obsNomeMae']);
                

                $array_marca[] = $objPaciente;
                
            }
            return $array_marca;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando marca no BD.",$ex);
        }
       
    }
    
    public function consultar(Paciente $objPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPaciente,idSexo_fk,idPerfilPaciente_fk,nome,nomeMae,CPF,RG,obsCPF,'
                    . 'obsRG,obsSexo,codGAL,dataNascimento,obsNomeMae FROM tb_paciente WHERE idPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new Paciente();
            $paciente->setIdPaciente($arr[0]['idPaciente']);
            $paciente->setNome($arr[0]['nome']);
            $paciente->setIdSexo_fk($arr[0]['idSexo_fk']);
            $paciente->setIdPerfilPaciente_fk($arr[0]['idPerfilPaciente_fk']); 
            $paciente->setNomeMae($arr[0]['nomeMae']);
            $paciente->setCPF($arr[0]['CPF']);
            $paciente->setRG($arr[0]['RG']);
            $paciente->setObsCPF($arr[0]['obsCPF']);
            $paciente->setObsRG($arr[0]['obsRG']);
            $paciente->setObsSexo($arr[0]['obsSexo']);
            $paciente->setCodGAL($arr[0]['codGAL']);
            $paciente->setDataNascimento($arr[0]['dataNascimento']);
            $paciente->setObsNomeMae($arr[0]['obsNomeMae']);

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando marca no BD.",$ex);
        }

    }
    
    public function remover(Paciente $objPaciente, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_paciente WHERE idPaciente = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo marca no BD.",$ex);
        }
    }
    
    

    
}
