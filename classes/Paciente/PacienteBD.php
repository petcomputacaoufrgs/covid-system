<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class PacienteBD{

    public function cadastrar(Paciente $objPaciente, Banco $objBanco) {
        try{
            //echo $objPaciente->getPaciente();
            $INSERT = 'INSERT INTO tb_paciente (idSexo_fk,idPerfilPaciente_fk,nome,nomeMae,dataNascimento,CPF,RG,'
                    . 'obsRG,obsSexo,obsNomeMae) VALUES (?,?,?,?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsSexo());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            
            

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPaciente->setIdPaciente($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o paciente  no BD.",$ex);
        }
        
    }
    
    public function alterar(Paciente $objPaciente, Banco $objBanco) {
        try{
                      
            $UPDATE = 'UPDATE tb_paciente SET '
                    . ' idSexo_fk = ?,'
                    . ' idPerfilPaciente_fk = ?,'
                    . ' nome = ?,'
                    . ' nomeMae = ?,'
                    . ' dataNascimento = ?,'
                    . ' CPF = ?,'
                    . ' RG = ?,'
                    . ' obsRG = ?,'
                    . ' obsSexo = ?,'
                    . ' obsNomeMae = ?'
                . '  where idPaciente = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdPerfilPaciente_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsSexo());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());

            $objBanco->executarSQL($UPDATE,$arrayBind);

        } catch (Exception $ex) {
            throw new Excecao("Erro alterando o paciente no BD.",$ex);
        }
       
    }
    
     public function listar(Paciente $objPaciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_paciente";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_paciente = array();
            foreach ($arr as $reg){
                $objPaciente = new Paciente();
                $objPaciente->setIdPaciente($reg['idPaciente']);
                $objPaciente->setNome($reg['nome']);
                $objPaciente->setIdSexo_fk($reg['idSexo_fk']);
                $objPaciente->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $objPaciente->setNomeMae($reg['nomeMae']);
                $objPaciente->setCPF($reg['CPF']);
                $objPaciente->setRG($reg['RG']);
                $objPaciente->setObsRG($reg['obsRG']);
                $objPaciente->setObsSexo($reg['obsSexo']);
                $objPaciente->setDataNascimento($reg['dataNascimento']);
                $objPaciente->setObsNomeMae($reg['obsNomeMae']);
                

                $array_paciente[] = $objPaciente;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(Paciente $objPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT idPaciente,idSexo_fk,idPerfilPaciente_fk,nome,nomeMae,dataNascimento,CPF,RG,'
                    . 'obsRG,obsSexo,obsNomeMae FROM tb_paciente WHERE idPaciente = ?';

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
            $paciente->setObsRG($arr[0]['obsRG']);
            $paciente->setObsSexo($arr[0]['obsSexo']);
            $paciente->setDataNascimento($arr[0]['dataNascimento']);
            $paciente->setObsNomeMae($arr[0]['obsNomeMae']);

            return $paciente;
        } catch (Exception $ex) {
       
            throw new Excecao("Erro consultando o paciente no BD.",$ex);
        }

    }
    
    public function remover(Paciente $objPaciente, Banco $objBanco) {

        try{
            
            $DELETE = 'DELETE FROM tb_paciente WHERE idPaciente = ? ';  
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());
            $objBanco->executarSQL($DELETE, $arrayBind);
            
        } catch (Exception $ex) {
            throw new Excecao("Erro removendo o paciente no BD.",$ex);
        }
    }
    
    
    public function validarCadastro(Paciente $objPaciente, Banco $objBanco){
        
         try{
            
            $SELECT = 'SELECT * from tb_paciente WHERE nome = (?) AND CPF = (?) ';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);
            
            if(empty($arr)){
                return $arr;
            }
            $arr_pacientes = array();
             
            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdPerfilPaciente_fk($reg['idPerfilPaciente_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setObsSexo($reg['obsSexo']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                

                $arr_pacientes[] = $paciente;
                
            }
             return $arr_pacientes;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando o detentor no BD.",$ex);
        }
        
        
    }
    
}
