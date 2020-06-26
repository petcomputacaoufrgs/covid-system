<?php


class Pesquisa
{
    private $colunaSelecionada;
    private $valorInserido;

    /**
     * @return mixed
     */
    public function getColunaSelecionada()
    {
        return $this->colunaSelecionada;
    }

    /**
     * @param mixed $colunaSelecionada
     */
    public function setColunaSelecionada($colunaSelecionada)
    {
        $this->colunaSelecionada = $colunaSelecionada;
    }


}