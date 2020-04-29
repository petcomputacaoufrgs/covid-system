<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


class TipoLocalArmazenamento{
    private $idTipoLocalArmazenamento;
    private $tipo;
    private $index_tipo;
    private $caractereTipo;

    
    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getCaractereTipo()
    {
        return $this->caractereTipo;
    }

    /**
     * @param mixed $caractereTipo
     */
    public function setCaractereTipo($caractereTipo)
    {
        $this->caractereTipo = $caractereTipo;
    }



    /**
     * @return mixed
     */
    public function getIndexTipo()
    {
        return $this->index_tipo;
    }

    /**
     * @param mixed $index_tipo
     */
    public function setIndexTipo($index_tipo)
    {
        $this->index_tipo = $index_tipo;
    }



    /**
     * @return mixed
     */
    public function getIdTipoLocalArmazenamento()
    {
        return $this->idTipoLocalArmazenamento;
    }

    /**
     * @param mixed $idTipoLocalArmazenamento
     */
    public function setIdTipoLocalArmazenamento($idTipoLocalArmazenamento)
    {
        $this->idTipoLocalArmazenamento = $idTipoLocalArmazenamento;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    

    
}