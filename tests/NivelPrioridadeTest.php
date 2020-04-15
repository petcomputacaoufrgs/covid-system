<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../classes/NivelPrioridade/NivelPrioridade.php';
require_once __DIR__ . '/../classes/NivelPrioridade/NivelPrioridadeRN.php';

final class NivelPrioridadeTest extends TestCase {
    public function testObjeto() {
        $nivel = new NivelPrioridade();
        $nivel->setNivel(3);
        $nivel->setIdNivelPrioridade(1);
        $this->assertEquals($nivel->getIdNivelPrioridade(), 1);
        $this->assertEquals($nivel->getNivel(), 3);
    }

    public function testConsultaNaoExiste() {
        $rn = new NivelPrioridadeRN();

        $nivel = new NivelPrioridade();
        $nivel->setIdNivelPrioridade(95737496725);
        $this->expectException(Excecao::class);

        $rn->consultar($nivel);
    }

    public function testCadastroConsulta() {
        $rn = new NivelPrioridadeRN();

        $baixo = new NivelPrioridade();
        $baixo->setNivel('1');
        $rn->cadastrar($baixo);
        $this->assertNotNull($baixo->getIdNivelPrioridade());
        $baixo2 = new NivelPrioridade();
        $baixo2->setIdNivelPrioridade($baixo->getIdNivelPrioridade());
        $baixo2 = $rn->consultar($baixo2);
        $this->assertEquals('1', $baixo2->getNivel());

        $alto = new NivelPrioridade();
        $alto->setNivel('    4 ');
        $rn->cadastrar($alto);
        $alto2 = new NivelPrioridade();
        $alto2->setIdNivelPrioridade($alto->getIdNivelPrioridade());
        $alto2 = $rn->consultar($alto2);
        $this->assertEquals('4', $alto2->getNivel());
        
        $erro = new NivelPrioridade();
        $erro->setNivel('');
        $this->expectException(Excecao::class);
        $rn->cadastrar($erro);
    }

    public function testAlteracaoConsulta() {
        $rn = new NivelPrioridadeRN();

        $sempre_alto = new NivelPrioridade();
        $sempre_alto->setNivel('5');
        $rn->cadastrar($sempre_alto);

        $nivel = new NivelPrioridade();
        $nivel->setNivel('2');
        $rn->cadastrar($nivel);

        $nivel->setNivel(' 5');

        $nivel2 = new NivelPrioridade();
        $nivel2->setIdNivelPrioridade($nivel->getIdNivelPrioridade());
        $nivel2 = $rn->consultar($nivel2);
        $this->assertEquals('2', $nivel2->getNivel());

        $rn->alterar($nivel);
        $nivel2 = new NivelPrioridade();
        $nivel2->setIdNivelPrioridade($nivel->getIdNivelPrioridade());
        $nivel2 = $rn->consultar($nivel2);
        $this->assertEquals('5', $nivel2->getNivel());

        $nivel->setNivel('2');
        $rn->alterar($nivel);
        $nivel2 = new NivelPrioridade();
        $nivel2->setIdNivelPrioridade($nivel->getIdNivelPrioridade());
        $nivel2 = $rn->consultar($nivel2);
        $this->assertEquals('2', $nivel2->getNivel());

        $sempre_alto2 = new NivelPrioridade();
        $sempre_alto2->setIdNivelPrioridade(
            $sempre_alto->getIdNivelPrioridade()
        );
        $sempre_alto2 = $rn->consultar($sempre_alto2);
        $this->assertEquals('5', $sempre_alto2->getNivel());

        $erro = new NivelPrioridade();
        $erro->setNivel('');
        $this->expectException(Excecao::class);
        $rn->alterar($erro);
    }

    public function testListar() {
        $rn = new NivelPrioridadeRN();

        $baixo = new NivelPrioridade();
        $baixo->setNivel(' 1');
        $rn->cadastrar($baixo);

        $alto = new NivelPrioridade();
        $alto->setNivel(' 5   ');
        $rn->cadastrar($alto);

        $arr = $rn->listar(new NivelPrioridade());

        $tem_baixo = false;
        $tem_alto = false;

        foreach ($arr as $elem) {
            $nivel = $elem->getIdNivelPrioridade();
            if ($nivel == $baixo->getIdNivelPrioridade()) {
                $this->assertNotTrue($tem_baixo);
                $tem_baixo = true;
                $this->assertEquals('1', $elem->getNivel());
            } elseif ($nivel == $alto->getIdNivelPrioridade()) {
                $this->assertNotTrue($tem_alto);
                $tem_alto= true;
                $this->assertEquals('5', $elem->getNivel());
            }
        }

        $this->assertTrue($tem_baixo);
        $this->assertTrue($tem_alto);
    }

    public function testRemover() {
        $rn = new NivelPrioridadeRN();

        $baixo = new NivelPrioridade();
        $baixo->setNivel('1');
        $rn->cadastrar($baixo);

        $alto = new NivelPrioridade();
        $alto->setNivel('3');
        $rn->cadastrar($alto);

        $rn->remover($alto);

        $this->assertNotNull($baixo->getIdNivelPrioridade());
        $baixo2 = new NivelPrioridade();
        $baixo2->setIdNivelPrioridade($baixo->getIdNivelPrioridade());
        $baixo2 = $rn->consultar($baixo2);
        $this->assertEquals('1', $baixo2->getNivel());

        $alto2 = new NivelPrioridade();
        $alto2->setIdNivelPrioridade($alto->getIdNivelPrioridade());
        $this->expectException(Excecao::class);
        $alto2 = $rn->consultar($alto2);
    }

    /*
    public function testPesquisar() {
        $rn = new NivelPrioridadeRN();

        $nivel = new NivelPrioridade();
        $nivel->setNivel('2');
        $rn->cadastrar($nivel);

        $nivel2 = new NivelPrioridade();
        $nivel2->setNivel('2');
        $arr = $rn->pesquisar('nivel', $nivel2);

        $tem_nivel = false;

        foreach ($arr as $elem) {
            if ($elem->getIdNivelPrioridade() == $nivel->getIdNivelPrioridade()) {
                $this->assertNotTrue($tem_nivel);
                $tem_nivel = true;
                $this->assertEquals('2', $elem->getNivel());
            }
        }

        $this->assertTrue($tem_nivel);
    }

    public function testPesquisarNaoAcha() {
        $rn = new NivelPrioridadeRN();

        $nao_existe = new NivelPrioridade();
        $nao_existe ->setNivel('8346858232');
        $arr = $rn->pesquisar('nivel', $nao_existe);

        $tem = false;
        foreach ($arr as $elem) {
            if ($elem->getNivel() == $nao_existe->getNivel()) {
                $tem = true;
                break;
            }
        }

        $this->assertNotTrue($tem);
    }
    */
}
