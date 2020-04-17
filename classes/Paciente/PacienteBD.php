<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once __DIR__ . '/../Banco/Banco.php';
class PacienteBD{

    public function cadastrar(Paciente $objPaciente, Banco $objBanco) {
        try{
            //print_r($objPaciente);
            $INSERT = 'INSERT INTO tb_paciente (idSexo_fk,idEtnia_fk,nome,nomeMae,dataNascimento,CPF,RG,'
                    . 'obsRG,obsNomeMae,CEP,endereco,obsEndereco,obsCEP,obsCPF,passaporte,obsPassaporte,cadastroPendente) '
                    . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdEtnia_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            $arrayBind[] = array('s',$objPaciente->getCEP());
            $arrayBind[] = array('s',$objPaciente->getEndereco());
            $arrayBind[] = array('s',$objPaciente->getObsEndereco());
            $arrayBind[] = array('s',$objPaciente->getObsCEP());
            $arrayBind[] = array('s',$objPaciente->getObsCPF());
            $arrayBind[] = array('s',$objPaciente->getPassaporte());
            $arrayBind[] = array('s',$objPaciente->getObsPassaporte());
            $arrayBind[] = array('s',$objPaciente->getCadastroPendente());
            

            $objBanco->executarSQL($INSERT,$arrayBind);
            $objPaciente->setIdPaciente($objBanco->obterUltimoID());
           
        } catch (Exception $ex) {
            throw new Excecao("Erro cadastrando o paciente  no BD.",$ex);
        }
        
    }
    
    public function alterar(Paciente $objPaciente, Banco $objBanco) {
        try{    
            $UPDATE = 'UPDATE tb_paciente SET idSexo_fk = ?,idEtnia_fk = ?, nome = ?, nomeMae = ?,dataNascimento = ?, CPF = ?,'
                    . ' RG = ?, obsRG = ?, obsNomeMae = ?, CEP = ?, endereco = ?, obsEndereco = ?, obsCEP = ?, obsCPF = ?,'
                    . ' passaporte = ?,obsPassaporte = ?,cadastroPendente = ?  where idPaciente = ?';         
            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdSexo_fk());
            $arrayBind[] = array('i',$objPaciente->getIdEtnia_fk());
            $arrayBind[] = array('s',$objPaciente->getNome());
            $arrayBind[] = array('s',$objPaciente->getNomeMae());
            $arrayBind[] = array('s',$objPaciente->getDataNascimento());
            $arrayBind[] = array('s',$objPaciente->getCPF());
            $arrayBind[] = array('s',$objPaciente->getRG());
            $arrayBind[] = array('s',$objPaciente->getObsRG());
            $arrayBind[] = array('s',$objPaciente->getObsNomeMae());
            $arrayBind[] = array('s',$objPaciente->getCEP());
            $arrayBind[] = array('s',$objPaciente->getEndereco());
            $arrayBind[] = array('s',$objPaciente->getObsEndereco());
            $arrayBind[] = array('s',$objPaciente->getObsCEP());
            $arrayBind[] = array('s',$objPaciente->getObsCPF());
            $arrayBind[] = array('s',$objPaciente->getPassaporte());
            $arrayBind[] = array('s',$objPaciente->getObsPassaporte());
            $arrayBind[] = array('s',$objPaciente->getCadastroPendente());
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());
            $objBanco->executarSQL($UPDATE,$arrayBind);
        } catch (Exception $ex) { throw new Excecao("Erro alterando o paciente no BD.",$ex);  }
       
    }
    
     public function listar(Paciente $objPaciente, Banco $objBanco) {
         try{
      
            $SELECT = "SELECT * FROM tb_paciente";


            $arr = $objBanco->consultarSQL($SELECT);

            $array_paciente = array();
            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);

                $array_paciente[] = $paciente;
                
            }
            return $array_paciente;
        } catch (Exception $ex) {
            throw new Excecao("Erro listando o paciente no BD.",$ex);
        }
       
    }
    
    public function consultar(Paciente $objPaciente, Banco $objBanco) {

        try{

            $SELECT = 'SELECT * FROM tb_paciente WHERE idPaciente = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objPaciente->getIdPaciente());

            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);

            $paciente = new Paciente();
            $paciente->setIdPaciente($arr[0]['idPaciente']);
            $paciente->setNome($arr[0]['nome']);
            $paciente->setNomeMae($arr[0]['nomeMae']);
            $paciente->setIdSexo_fk($arr[0]['idSexo_fk']);
            $paciente->setIdEtnia_fk($arr[0]['idEtnia_fk']);
            $paciente->setCPF($arr[0]['CPF']);
            $paciente->setObsCPF($arr[0]['obsCPF']);
            $paciente->setRG($arr[0]['RG']);
            $paciente->setObsRG($arr[0]['obsRG']);
            $paciente->setDataNascimento($arr[0]['dataNascimento']);
            $paciente->setObsNomeMae($arr[0]['obsNomeMae']);
            $paciente->setEndereco($arr[0]['endereco']);
            $paciente->setCEP($arr[0]['CEP']);
            $paciente->setPassaporte($arr[0]['passaporte']);
            $paciente->setObsPassaporte($arr[0]['obsPassaporte']);
            $paciente->setObsCEP($arr[0]['obsCEP']);
            $paciente->setObsEndereco($arr[0]['obsEndereco']);
            $paciente->setCadastroPendente($arr[0]['cadastroPendente']);

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
    
     public function procurar(Paciente $objPaciente, Banco $objBanco){
        
         try{
            
            // print_r($objPaciente);
            $SELECT = 'SELECT * from tb_paciente ';
            $WHERE = '';
            $AND = '';
            $arrayBind = array();
           
            if($objPaciente->getNome() != null){
                $WHERE .= $AND." nome = ?";
                $AND = ' and '; 
                $arrayBind[] = array('s',$objPaciente->getNome());
            }
            
            if($objPaciente->getCPF() != null){
                //echo $objPaciente->getCPF();
                $WHERE .= $AND." CPF = ?";
                $AND = ' and '; 
                $arrayBind[] = array('s',$objPaciente->getCPF());
            }
            
            if($objPaciente->getRG() != null){
                $WHERE .= $AND." RG = ?";
                $AND = ' and '; 
                $arrayBind[] = array('s',$objPaciente->getRG());
            }
            
            if($objPaciente->getPassaporte() != null){
                $WHERE .= $AND." passaporte = ?";
                $AND = ' and '; 
                $arrayBind[] = array('s',$objPaciente->getPassaporte());
            }
            

            if($WHERE != ''){
                $WHERE = ' where '.$WHERE;
            } 
        
            //echo $SELECT.$WHERE;$WHERE

            $arr = $objBanco->consultarSQL($SELECT.$WHERE,$arrayBind);
                      
            if(empty($arr)){
                return $arr;
            }
            $arr_pacientes = array();
             
            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                

                $arr_pacientes[] = $paciente;
                
            }
             return $arr_pacientes;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando o detentor no BD.",$ex);
        }
        
        
    }
    
    
     public function procurarCPF(Paciente $objPaciente, Banco $objBanco){
        
         try{
            
             
            $SELECT = 'SELECT * from tb_paciente where CPF = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objPaciente->getCPF());
       
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
                      
            if(empty($arr)){
                return $arr;
            }
            $arr_pacientes = array();
             
            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                

                $arr_pacientes[] = $paciente;
                
            }
             return $arr_pacientes;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando o detentor no BD.",$ex);
        }
        
        
    }
    
    
     public function procurarRG(Paciente $objPaciente, Banco $objBanco){
        
         try{
            
             
            $SELECT = 'SELECT * from tb_paciente where RG = ?';
            
            $arrayBind = array();
            $arrayBind[] = array('s',$objPaciente->getRG());
       
            $arr = $objBanco->consultarSQL($SELECT,$arrayBind);
                      
            if(empty($arr)){
                return $arr;
            }
            $arr_pacientes = array();
             
            foreach ($arr as $reg){
                $paciente = new Paciente();
                $paciente->setIdPaciente($reg['idPaciente']);
                $paciente->setNome($reg['nome']);
                $paciente->setIdSexo_fk($reg['idSexo_fk']);
                $paciente->setIdEtnia_fk($reg['idEtnia_fk']);
                $paciente->setNomeMae($reg['nomeMae']);
                $paciente->setCPF($reg['CPF']);
                $paciente->setObsCPF($reg['CPF']);
                $paciente->setRG($reg['RG']);
                $paciente->setObsRG($reg['obsRG']);
                $paciente->setDataNascimento($reg['dataNascimento']);
                $paciente->setObsNomeMae($reg['obsNomeMae']);
                $paciente->setEndereco($reg['endereco']);
                $paciente->setCEP($reg['CEP']);
                $paciente->setPassaporte($reg['passaporte']);
                $paciente->setObsPassaporte($reg['obsPassaporte']);
                $paciente->setObsCEP($reg['obsCEP']);
                $paciente->setObsEndereco($reg['obsEndereco']);
                $paciente->setCadastroPendente($reg['cadastroPendente']);
                

                $arr_pacientes[] = $paciente;
                
            }
             return $arr_pacientes;
            
        } catch (Exception $ex) {
            throw new Excecao("Erro pesquisando o detentor no BD.",$ex);
        }
        
        
    }
    
}
