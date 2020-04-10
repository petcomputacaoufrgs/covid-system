<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */




class NaoEncontrado extends Exception {
    public function __construct() {
        parent::__construct("O objeto não foi encontrado");
    }
}
