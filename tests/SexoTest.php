<?php

use PHPUnit\Framework\TestCase;
use InfUfrgs\Banco\Banco;
use InfUfrgs\Sexo\Sexo;
use InfUfrgs\Sexo\SexoBD;

final class SexoTest extends TestCase {
    public function testObjeto() {
        $sexo = new Sexo();
        $sexo->setSexo('Masculino');
        $sexo->setIdSexo(1);
        $this->assertEquals($sexo->getIdSexo(), 1);
        $this->assertEquals($sexo->getSexo(), 'Masculino');
    }

    public function testCadastroConsulta() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
        
        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
    }
}
