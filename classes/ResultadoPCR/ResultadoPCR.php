<?php

class ResultadoPCR {
    private $well;
    private $sampleName;
    private $targetName;
    private $task;
    private $reporter;
    private $quencher;
    private $ctMean;

    /**
     * Resultado constructor.
     */
    public function __construct()
    {

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
    public function getQuencher()
    {
        return $this->quencher;
    }

    /**
     * @param mixed $quencher
     */
    public function setQuencher($quencher)
    {
        $this->quencher = $quencher;
    }

    /**
     * @return mixed
     */
    public function getCtMean()
    {
        return $this->ctMean;
    }

    /**
     * @param mixed $ctMean
     */
    public function setCtMean($ctMean)
    {
        $this->ctMean = $ctMean;
    }


}