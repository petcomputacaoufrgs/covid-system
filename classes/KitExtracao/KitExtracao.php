<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

class KitExtracao
{
    private $idKitExtracao;
    private $nome;
    private $index_nome;

    function __construct() {

    }

    /**
     * @return mixed
     */
    public function getIdKitExtracao()
    {
        return $this->idKitExtracao;
    }

    /**
     * @param mixed $idKitExtracao
     */
    public function setIdKitExtracao($idKitExtracao)
    {
        $this->idKitExtracao = $idKitExtracao;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getIndexNome()
    {
        return $this->index_nome;
    }

    /**
     * @param mixed $index_nome
     */
    public function setIndexNome($index_nome)
    {
        $this->index_nome = $index_nome;
    }


}