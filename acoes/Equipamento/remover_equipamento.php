<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */
    require_once 'classes/Pagina/Pagina.php';
    require_once 'classes/Excecao/Excecao.php';
    require_once 'classes/Equipamento/Equipamento.php';
    require_once 'classes/Equipamento/EquipamentoRN.php';
    
    $objPagina = new Pagina();
    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();
    try{
        
        $objEquipamento->setIdEquipamento($_GET['idEquipamento']);
        $objEquipamentoRN->remover($objEquipamento);

        header('Location: controlador.php?action=listar_equipamento');
    } catch (Exception $ex) {
        $objPagina->processar_excecao($ex);
    }

?>
