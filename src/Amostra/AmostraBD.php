<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

namespace InfUfrgs\Amostra;

use Banco\Banco;

class AmostraBD
{
    public function cadastrar(Amostra $objAmostra, Banco $objBanco)
    {
        try {
            //echo $objAmostra->getAmostra();
            $INSERT = 'INSERT INTO tb_amostra (idPaciente_fk,cod_estado_fk,cod_municipio_fk,quantidadeTubos,observacoes,dataHoraColeta,a_r)'
                    . 'VALUES (?,?,?,?,?,?,?)';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getQuantidadeTubos());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getAceita_recusa());
                        

            $objBanco->executarSQL($INSERT, $arrayBind);
            $objAmostra->setIdAmostra($objBanco->obterUltimoID());
        } catch (\Exeception $ex) {
            throw new Excecao("Erro cadastrando paciente no BD.", $ex);
        }
    }
    
    public function alterar(Amostra $objAmostra, Banco $objBanco)
    {
        try {
            $UPDATE = 'UPDATE tb_amostra SET '
                    . ' idPaciente_fk = ?,'
                    . ' cod_estado_fk = ?,'
                    . ' cod_municipio_fk = ?,'
                    . ' quantidadeTubos = ?,'
                    . ' observacoes = ?,'
                    . ' dataHoraColeta = ?,'
                    . ' a_r = ?'
                . '  where idAmostra = ?';
        
                
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdPaciente_fk());
            $arrayBind[] = array('i',$objAmostra->getIdEstado_fk());
            $arrayBind[] = array('i',$objAmostra->getIdLugarOrigem_fk());
            $arrayBind[] = array('i',$objAmostra->getQuantidadeTubos());
            $arrayBind[] = array('s',$objAmostra->getObservacoes());
            $arrayBind[] = array('s',$objAmostra->getDataHoraColeta());
            $arrayBind[] = array('s',$objAmostra->getAceita_recusa());
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());

            $objBanco->executarSQL($UPDATE, $arrayBind);
        } catch (\Exeception $ex) {
            throw new Excecao("Erro alterando paciente no BD.", $ex);
        }
    }
    
    public function listar(Amostra $objAmostra, Banco $objBanco)
    {
        try {
            $SELECT = "SELECT * FROM tb_amostra";


            $arr = $objBanco->consultarSQL($SELECT);
 
            $array_paciente = array();
            foreach ($arr as $reg) {
                $objAmostra = new Amostra();
                $objAmostra->setIdAmostra($reg['idAmostra']);
                $objAmostra->setIdPaciente_fk($reg['idPaciente_fk']);
                $objAmostra->setIdEstado_fk($reg['cod_estado_fk']);
                $objAmostra->setIdLugarOrigem_fk($reg['cod_municipio_fk']);
                $objAmostra->setQuantidadeTubos($reg['quantidadeTubos']);
                $objAmostra->setObservacoes($reg['observacoes']);
                $objAmostra->setDataHoraColeta($reg['dataHoraColeta']);
                $objAmostra->setAceita_recusa($reg['a_r']);
                

                $array_paciente[] = $objAmostra;
            }
            return $array_paciente;
        } catch (\Exeception $ex) {
            throw new Excecao("Erro listando paciente no BD.", $ex);
        }
    }
    
    public function consultar(Amostra $objAmostra, Banco $objBanco)
    {
        try {
            $SELECT = 'SELECT idAmostra,idPaciente_fk,cod_estado_fk,cod_municipio_fk,quantidadeTubos,observacoes,dataHoraColeta,a_r'
                    . ' FROM tb_amostra WHERE idAmostra = ?';

            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());

            $arr = $objBanco->consultarSQL($SELECT, $arrayBind);

            $objAmostra = new Amostra();
            $objAmostra->setIdAmostra($arr[0]['idAmostra']);
            $objAmostra->setIdPaciente_fk($arr[0]['idPaciente_fk']);
            $objAmostra->setIdEstado_fk($arr[0]['cod_estado_fk']);
            $objAmostra->setIdLugarOrigem_fk($arr[0]['idLugarOrigem_fk']);
            $objAmostra->setQuantidadeTubos($arr[0]['quantidadeTubos']);
            $objAmostra->setObservacoes($arr[0]['observacoes']);
            $objAmostra->setDataHoraColeta($arr[0]['dataHoraColeta']);
            $objAmostra->setAceita_recusa($arr[0]['a_r']);

            return $paciente;
        } catch (\Exeception $ex) {
            throw new Excecao("Erro consultando paciente no BD.", $ex);
        }
    }
    
    public function remover(Amostra $objAmostra, Banco $objBanco)
    {
        try {
            $DELETE = 'DELETE FROM tb_amostra WHERE idAmostra = ? ';
            $arrayBind = array();
            $arrayBind[] = array('i',$objAmostra->getIdAmostra());
            $objBanco->executarSQL($DELETE, $arrayBind);
        } catch (\Exeception $ex) {
            throw new Excecao("Erro removendo paciente no BD.", $ex);
        }
    }
}
