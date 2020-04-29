<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class Rel_perfil_preparoLote
{
    private $idRel_Perfil_PreparoLote;
    private $idPreparoLote_fk;
    private $idPerfilPaciente_fk;
    private $objPerfilPaciente;
    private $objPreparoLote;

    /**
     * @return mixed
     */
    public function getObjPreparoLote()
    {
        return $this->objPreparoLote;
    }

    /**
     * @param mixed $objPreparoLote
     */
    public function setObjPreparoLote($objPreparoLote)
    {
        $this->objPreparoLote = $objPreparoLote;
    }




    /**
     * @return mixed
     */
    public function getObjPerfilPaciente()
    {
        return $this->objPerfilPaciente;
    }

    /**
     * @param mixed $objPerfilPaciente
     */
    public function setObjPerfilPaciente($objPerfilPaciente)
    {
        $this->objPerfilPaciente = $objPerfilPaciente;
    }



    /**
     * @return mixed
     */
    public function getIdRelPerfilPreparoLote()
    {
        return $this->idRel_Perfil_PreparoLote;
    }

    /**
     * @param mixed $idRel_Perfil_PreparoLote
     */
    public function setIdRelPerfilPreparoLote($idRel_Perfil_PreparoLote)
    {
        $this->idRel_Perfil_PreparoLote = $idRel_Perfil_PreparoLote;
    }

    /**
     * @return mixed
     */
    public function getIdPreparoLoteFk()
    {
        return $this->idPreparoLote_fk;
    }

    /**
     * @param mixed $idPreparoLote_fk
     */
    public function setIdPreparoLoteFk($idPreparoLote_fk)
    {
        $this->idPreparoLote_fk = $idPreparoLote_fk;
    }

    /**
     * @return mixed
     */
    public function getIdPerfilPacienteFk()
    {
        return $this->idPerfilPaciente_fk;
    }

    /**
     * @param mixed $idPerfilPaciente_fk
     */
    public function setIdPerfilPacienteFk($idPerfilPaciente_fk)
    {
        $this->idPerfilPaciente_fk = $idPerfilPaciente_fk;
    }


}