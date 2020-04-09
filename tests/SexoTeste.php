<?php

use PHPUnit\Framework\TestCase;
use InfUfrgs\Banco\Banco;
use InfUfrgs\Sexo\Sexo;
use InfUfrgs\Sexo\SexoBD;

final class SexoTeste extends TestCase {
    public function testObjeto() {
        $sexo = new Sexo();
        $sexo->setSexo('Masculino');
        $sexo->setSexoId(1);
        $this->assertEquals($sexo->getSexoId(), 1);
        $this->assertEquals($sexo->getSexo(), 'Masculino');
    }

    public function testCadastroConsulta() {
        $banco = new Banco();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setSexoId($masc->getSexoId());
        $bd->consultar($masc2, $banco);
        $this->assertEquals($masc->getSexo(), $masc2->getSexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setSexoId($fem->getSexoId());
        $bd->consultar($fem2, $banco);
        $this->assertEquals($fem->getSexo(), $fem2->getSexo());
        
        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setSexoId($masc->getSexoId());
        $bd->consultar($masc2, $banco);
        $this->assertEquals($masc->getSexo(), $masc2->getSexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setSexoId($fem->getSexoId());
        $bd->consultar($fem2, $banco);
        $this->assertEquals($fem->getSexo(), $fem2->getSexo());
    }
}
