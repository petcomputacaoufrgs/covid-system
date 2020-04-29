<?php


class Posicao
{
    private $idPosicaoCaixa;
    private $idCaixa_fk;
    private $idTubo_fk;
    private $coluna;
    private $linha;
    private $situacaoPosicao;

    /**
     * @return mixed
     */
    public function getIdTuboFk()
    {
        return $this->idTubo_fk;
    }

    /**
     * @param mixed $idTubo_fk
     */
    public function setIdTuboFk($idTubo_fk)
    {
        $this->idTubo_fk = $idTubo_fk;
    }




    /**
     * @return mixed
     */
    public function getIdPosicaoCaixa()
    {
        return $this->idPosicaoCaixa;
    }

    /**
     * @param mixed $idPosicaoCaixa
     */
    public function setIdPosicaoCaixa($idPosicaoCaixa)
    {
        $this->idPosicaoCaixa = $idPosicaoCaixa;
    }

    /**
     * @return mixed
     */
    public function getIdCaixa_fk()
    {
        return $this->idCaixa_fk;
    }

    /**
     * @param mixed $idCaixa_fk
     */
    public function setIdCaixa_fk($idCaixa_fk)
    {
        $this->idCaixa_fk = $idCaixa_fk;
    }

    /**
     * @return mixed
     */
    public function getColuna()
    {
        return $this->coluna;
    }

    /**
     * @param mixed $coluna
     */
    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
    }

    /**
     * @return mixed
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * @param mixed $linha
     */
    public function setLinha($linha)
    {
        $this->linha = $linha;
    }

    /**
     * @return mixed
     */
    public function getSituacaoPosicao()
    {
        return $this->situacaoPosicao;
    }

    /**
     * @param mixed $situacaoPosicao
     */
    public function setSituacaoPosicao($situacaoPosicao)
    {
        $this->situacaoPosicao = $situacaoPosicao;
    }




}