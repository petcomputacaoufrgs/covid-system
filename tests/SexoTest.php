<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../classes/Banco/Banco.php';
require_once __DIR__ . '/../classes/Sexo/Sexo.php';
require_once __DIR__ . '/../classes/Sexo/SexoBD.php';

final class SexoTest extends TestCase {
    public function testObjeto() {
        $sexo = new Sexo();
        $sexo->setSexo('Masculíno');
        $sexo->setIdSexo(1);
        $this->assertEquals($sexo->getIdSexo(), 1);
        $this->assertEquals($sexo->getSexo(), 'Masculíno');
        $sexo->setIndex_sexo('Masculino');
        $this->assertEquals($sexo->getIndex_sexo(), 'Masculino');
    }

    public function testCadastroConsulta() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('Masculino', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('Feminino', $fem2->getIndex_sexo());
        
        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('Masculino');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('Masculino', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('Feminino');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('Feminino', $fem2->getIndex_sexo());
    }
}
