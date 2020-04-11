<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../classes/Banco/Banco.php';
require_once __DIR__ . '/../classes/Sexo/Sexo.php';
require_once __DIR__ . '/../classes/Sexo/SexoBD.php';
require_once __DIR__ . '/../classes/Sexo/SexoRN.php';

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
        $rn = new SexoRN();

        $sexo = new Sexo();
        $sexo->setIdSexo(95737496725);
        $this->expectException(Excecao::class);

        $rn->consultar($sexo);
    }

    public function testCadastroConsulta() {
        $rn = new SexoRN();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $rn->cadastrar($masc);
        $this->assertNotNull($masc->getIdSexo());
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $rn->consultar($masc2);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo('    Feminino  ');
        $fem->setIndex_sexo('FEMININO');
        $rn->cadastrar($fem);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $rn->consultar($fem2);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('FEMININO', $fem2->getIndex_sexo());
        
        $masc = new Sexo();
        $masc->setSexo('Masculino  ');
        $masc->setIndex_sexo('MASCULINO');
        $rn->cadastrar($masc);
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $rn->consultar($masc2);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem = new Sexo();
        $fem->setSexo(' Feminino');
        $fem->setIndex_sexo('FEMININO');
        $rn->cadastrar($fem);
        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $fem2 = $rn->consultar($fem2);
        $this->assertEquals('Feminino', $fem2->getSexo());
        $this->assertEquals('FEMININO', $fem2->getIndex_sexo());

        $erro = new Sexo();
        $erro->setSexo("Este sexo é propositadamente e extremamente longo!!!!");
        $this->expectException(Excecao::class);
        $rn->cadastrar($erro);

        $erro = new Sexo();
        $erro->setSexo("");
        $this->expectException(Excecao::class);
        $rn->cadastrar($erro);
    }

    public function testAlteracaoConsulta() {
        $rn = new SexoRN();

        $sempre_fem = new Sexo();
        $sempre_fem->setSexo('Feminino');
        $sempre_fem->setIndex_sexo('FEMININO');
        $rn->cadastrar($sempre_fem);

        $sexo = new Sexo();
        $sexo->setSexo('Masculino');
        $sexo->setIndex_sexo('MASCULINO');
        $rn->cadastrar($sexo);

        $sexo->setSexo('Fêmînìnō');
        $sexo->setIndex_sexo('FEMININO');

        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $rn->consultar($sexo2);
        $this->assertEquals('Masculino', $sexo2->getSexo());

        $rn->alterar($sexo);
        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $rn->consultar($sexo2);
        $this->assertEquals('Fêmînìnō', $sexo2->getSexo());
        $this->assertEquals('FEMININO', $sexo2->getIndex_sexo());

        $sexo->setSexo('Mäßkülinö');
        $sexo->setIndex_sexo('MASCULINO');
        $rn->alterar($sexo);
        $sexo2 = new Sexo();
        $sexo2->setIdSexo($sexo->getIdSexo());
        $sexo2 = $rn->consultar($sexo2);
        $this->assertEquals('Mäßkülinö', $sexo2->getSexo());
        $this->assertEquals('MASCULINO', $sexo2->getIndex_sexo());

        $sempre_fem2 = new Sexo();
        $sempre_fem2->setIdSexo($sempre_fem->getIdSexo());
        $sempre_fem2 = $rn->consultar($sempre_fem2);
        $this->assertEquals('Feminino', $sempre_fem2->getSexo());
        $this->assertEquals('FEMININO', $sempre_fem2->getIndex_sexo());

        $erro = new Sexo();
        $erro->setSexo("Este sexo é propositadamente e extremamente longo!!!!");
        $this->expectException(Excecao::class);
        $rn->alterar($erro);

        $erro = new Sexo();
        $erro->setSexo("");
        $this->expectException(Excecao::class);
        $rn->alterar($erro);
    }

    public function testListar() {
        $rn = new SexoRN();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $rn->cadastrar($masc);

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $rn->cadastrar($fem);

        $arr = $rn->listar(new Sexo());

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
        $rn = new SexoRN();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $rn->cadastrar($masc);

        $fem = new Sexo();
        $fem->setSexo('Feminino');
        $fem->setIndex_sexo('FEMININO');
        $rn->cadastrar($fem);

        $rn->remover($fem);

        $this->assertNotNull($masc->getIdSexo());
        $masc2 = new Sexo();
        $masc2->setIdSexo($masc->getIdSexo());
        $masc2 = $rn->consultar($masc2);
        $this->assertEquals('Masculino', $masc2->getSexo());
        $this->assertEquals('MASCULINO', $masc2->getIndex_sexo());

        $fem2 = new Sexo();
        $fem2->setIdSexo($fem->getIdSexo());
        $this->expectException(Excecao::class);
        $fem2 = $rn->consultar($fem2);
    }

    public function testPesquisarIndex() {
        $rn = new SexoRN();

        $masc = new Sexo();
        $masc->setSexo('Masculino');
        $masc->setIndex_sexo('MASCULINO');
        $rn->cadastrar($masc);

        $masc2 = new Sexo();
        $masc2->setIndex_sexo('MASCULINO');
        $arr = $rn->pesquisar_index($masc2);

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
        $rn = new SexoRN();

        $nao_existe = new Sexo();
        $nao_existe ->setIndex_sexo('Nûnca Será Cadastrádo');
        $arr = $rn->pesquisar_index($nao_existe);

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
