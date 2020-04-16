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
        $objResultado->setCtMean($arrayLinha[6]);
    }

    public function printObjeto(ResultadoPCR $obj) {
        echo "Well ->" . $obj->getWell() . "\n";
        echo "Sample Name ->" . $obj->getSampleName() . "\n";
        echo "Target Name ->" . $obj->getTargetName() . "\n";
        echo "Task ->" . $obj->getTask() . "\n";
        echo "Reporter ->" . $obj->getReporter() . "\n";
        echo "Quencer ->" . $obj->getQuencher() . "\n";
        echo "Ct Mean ->" . $obj->getCtMean() . "\n";
    }
}