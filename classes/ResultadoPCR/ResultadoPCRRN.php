<?php


class ResultadoPCRRN
{
    public function configuraObjeto(ResultadoPCR $objResultado, $arrayLinha) {
        $objResultado->setWell($arrayLinha[0]);
        $objResultado->setSampleName($arrayLinha[1]);
        $objResultado->setTargetName($arrayLinha[2]);
        $objResultado->setTask($arrayLinha[3]);
        $objResultado->setReporter($arrayLinha[4]);
        $objResultado->setQuencher($arrayLinha[5]);
        $objResultado->setCt($arrayLinha[6]);
    }

    public function printObjeto(ResultadoPCR $obj) {
        echo "<br>";
        echo "Well ->" . $obj->getWell() . "<br>";
        echo "Sample Name ->" . $obj->getSampleName() . "<br>";
        echo "Target Name ->" . $obj->getTargetName() . "<br>";
        echo "Task ->" . $obj->getTask() . "<br>";
        echo "Reporter ->" . $obj->getReporter() . "<br>";
        echo "Quencer ->" . $obj->getQuencher() . "<br>";
        echo "Ct ->" . $obj->getCt() . "<br>";
    }
}