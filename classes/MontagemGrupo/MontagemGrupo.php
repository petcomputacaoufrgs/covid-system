<?php



class MontagemGrupo
{
    private $amostra;
    private $perfilPaciente;

    private $arr_IdsPerfis;
    private $qntAmostras;

    /**
     * @return mixed
     */
    public function getAmostra()
    {
        return $this->amostra;
    }

    /**
     * @param mixed $amostra
     */
    public function setAmostra($amostra)
    {
        $this->amostra = $amostra;
    }

    /**
     * @return mixed
     */
    public function getPerfilPaciente()
    {
        return $this->perfilPaciente;
    }

    /**
     * @param mixed $perfilPaciente
     */
    public function setPerfilPaciente($perfilPaciente)
    {
        $this->perfilPaciente = $perfilPaciente;
    }

    /**
     * @return mixed
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * @param mixed $posicao
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
    }

    /**
     * @return mixed
     */
    public function getArrIdsPerfis()
    {
        return $this->arr_IdsPerfis;
    }

    /**
     * @param mixed $arr_IdsPerfis
     */
    public function setArrIdsPerfis($arr_IdsPerfis)
    {
        $this->arr_IdsPerfis = $arr_IdsPerfis;
    }

    /**
     * @return mixed
     */
    public function getQntAmostras()
    {
        return $this->qntAmostras;
    }

    /**
     * @param mixed $qntAmostras
     */
    public function setQntAmostras($qntAmostras)
    {
        $this->qntAmostras = $qntAmostras;
    }


}