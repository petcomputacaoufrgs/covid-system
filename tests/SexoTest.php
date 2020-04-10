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

    public function testConsultaNaoExiste() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $sexo = new Sexo();
        $sexo->setIdSexo(95737496725);
        $this->expectException(Excecao::class);

        $bd->consultar($sexo, $banco);
    }

    public function testCadastroConsulta() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $bd->cadastrar($masc, $banco);
        $this->assertNotNull($masc->getIdSexo());
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('FEMININO', $fem2->getIndex_sexo());
        
        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $bd->cadastrar($masc, $banco);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $bd->cadastrar($fem, $banco);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $bd->consultar($fem2, $banco);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('FEMININO', $fem2->getIndex_sexo());
    }

    public function testAlteracaoConsulta() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $sempre_fem = new Sexo();
        $sempre_fem->setSexo('Feminino');
        $sempre_fem->setIndex_sexo('FEMININO');
        $bd->cadastrar($sempre_fem, $banco);

        $sexo = new Sexo();
        $sexo->setSexo('Masculino');
        $sexo->setIndex_sexo('MASCULINO');
        $bd->cadastrar($sexo, $banco);

        $sexo->setSexo('Fêmînìnō');
        $sexo->setIndex_sexo('FEMININO');

        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $bd->consultar($sexo2, $banco);
        $this->assertEquals('Masculino', $sexo2->getSexo());

        $bd->alterar($sexo, $banco);
        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $bd->consultar($sexo2, $banco);
        $this->assertEquals('Fêmînìnō', $sexo2->getSexo());
        $this->assertEquals('FEMININO', $sexo2->getIndex_sexo());

        $sexo->setSexo('Mäßkülinö');
        $sexo->setIndex_sexo('MASCULINO');
        $bd->alterar($sexo, $banco);
        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $bd->consultar($sexo2, $banco);
        $this->assertEquals('Mäßkülinö', $sexo2->getSexo());
        $this->assertEquals('MASCULINO', $sexo2->getIndex_sexo());

        $sempre_fem2 = new Sexo();
        $sempre_fem2->setIdSexo($sempre_fem->getIdSexo());
        $sempre_fem2 = $bd->consultar($sempre_fem2, $banco);
        $this->assertEquals('Feminino', $sempre_fem2->getSexo());
        $this->assertEquals('FEMININO', $sempre_fem2->getIndex_sexo());
    }

    public function testListar() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $bd->cadastrar($masc, $banco);

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $bd->cadastrar($fem, $banco);

        $arr = $bd->listar(new Sexo(), $banco);

        $has_masc = false;
        $has_fem = false;

        foreach ($arr as $elem) {
            if ($elem->getIdSexo() == $masc->getIdSexo()) {
                $this->assertNotTrue($has_masc);
                $has_masc = true;
                $this->assertEquals('Masculino', $elem->getSexo());
                $this->assertEquals('MASCULINO', $elem->getIndex_sexo());
            } elseif ($elem->getIdSexo() == $fem->getIdSexo()) {
                $this->assertNotTrue($has_fem);
                $has_fem= true;
                $this->assertEquals('Feminino', $elem->getSexo());
                $this->assertEquals('FEMININO', $elem->getIndex_sexo());
            }
        }

        $this->assertTrue($has_masc);
        $this->assertTrue($has_fem);
    }

    public function testRemover() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $bd->cadastrar($masc, $banco);

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $bd->cadastrar($fem, $banco);

        $bd->remover($fem, $banco);

        $this->assertNotNull($masc->getIdSexo());
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $bd->consultar($masc2, $banco);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $this->expectException(Excecao::class);
        $fem2 = $bd->consultar($fem2, $banco);
    }

    public function testPesquisarIndex() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $bd->cadastrar($masc, $banco);

        $masc2 = new Sexo();
        $masc2->setIndex_sexo('MASCULINO');
        $arr = $bd->pesquisar_index($masc2, $banco);

        $has_masc = false;

        foreach ($arr as $elem) {
            if ($elem->getIdSexo() == $masc->getIdSexo()) {
                $this->assertNotTrue($has_masc);
                $has_masc = true;
                $this->assertEquals('Masculino', $elem->getSexo());
                $this->assertEquals('MASCULINO', $elem->getIndex_sexo());
            }
        }

        $this->assertTrue($has_masc);
    }

    public function testPesquisarIndexNaoAcha() {
        $banco = new Banco();
        $banco->abrirConexao();
        $bd = new SexoBD();

        $nao_existe = new Sexo();
        $nao_existe ->setIndex_sexo('Nûnca Será Cadastrádo');
        $arr = $bd->pesquisar_index($nao_existe, $banco);

        $has = false;

        foreach ($arr as $elem) {
            if ($elem->getIndex_sexo() == $nao_existe->getIndex_sexo()) {
                $has = true;
                break;
            }
        }

        $this->assertNotTrue($has);
    }
}
