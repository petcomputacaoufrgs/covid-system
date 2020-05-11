<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once __DIR__ . '/../Excecao/Excecao.php';
require_once __DIR__ . '/MontagemGrupoBD.php';

class MontagemGrupoRN
{
    public function listar_completo(MontagemGrupo $montagemGrupo) {
        $objBanco = new Banco();
        try {
            $objExcecao = new Excecao();
            $objBanco->abrirConexao();
            $objBanco->abrirTransacao();


            $objExcecao->lancar_validacoes();
            $montagemGrupoBD = new MontagemGrupoBD();
            $montagemGrupo = $montagemGrupoBD->listar_completo($montagemGrupo,$objBanco);


            $objBanco->confirmarTransacao();
            $objBanco->fecharConexao();
            return $montagemGrupo;

        } catch (Throwable $e) {
            $objBanco->cancelarTransacao();
            throw new Excecao('Erro cadastrando a montagem do grupo.', $e);
        }
    }
}