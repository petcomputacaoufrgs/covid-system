<?php

class ResultadoPCR {
    private $idResultado;
    private $well;
    private $sampleName;
    private $targetName;
    private $task;
    private $reporter;
    private $ct;
    private $nomePlanilha;
    private $idRTqPCR_fk;

    /**
     * Resultado constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIdRTqPCRFk()
    {
        return $this->idRTqPCR_fk;
    }

    /**
     * @param mixed $idRTqPCR_fk
     */
    public function setIdRTqPCRFk($idRTqPCR_fk)
    {
        $this->idRTqPCR_fk = $idRTqPCR_fk;
    }



    /**
     * @return mixed
     */
    public function getNomePlanilha()
    {
        return $this->nomePlanilha;
    }

    /**
     * @param mixed $nomePlanilha
     */
    public function setNomePlanilha($nomePlanilha)
    {
        $this->nomePlanilha = $nomePlanilha;
    }



    /**
     * @return mixed
     */
    public function getIdResultado()
    {
        return $this->idResultado;
    }

    /**
     * @param mixed $idResultado
     */
    public function setIdResultado($idResultado)
    {
        $this->idResultado = $idResultado;
    }


    /**
     * @return mixed
     */
    public function getWell()
    {
        return $this->well;
    }

    /**
     * @param mixed $well
     */
    public function setWell($well)
    {
        $this->well = $well;
    }

    /**
     * @return mixed
     */
    public function getSampleName()
    {
        return $this->sampleName;
    }

    /**
     * @param mixed $sampleName
     */
    public function setSampleName($sampleName)
    {
        $this->sampleName = $sampleName;
    }

    /**
     * @return mixed
     */
    public function getTargetName()
    {
        return $this->targetName;
    }

    /**
     * @param mixed $targetName
     */
    public function setTargetName($targetName)
    {
        $this->targetName = $targetName;
    }

    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param mixed $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * @return mixed
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param mixed $reporter
     */
    public function setReporter($reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * @return mixed
     */
    public function getCt()
    {
        return $this->ct;
    }

    /**
     * @param mixed $ct
     */
    public function setCt($ct)
    {
        $this->ct = $ct;
    }


}