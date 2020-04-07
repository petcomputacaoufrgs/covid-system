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
$html = '';

try{
    
    $arrEquipamentos = $objEquipamentoRN->listar($objEquipamento);
    foreach ($arrEquipamentos as $e){   
        $html.='<tr>
                    <th scope="row">'.$e->getIdEquipamento().'</th>
                        <td>'.$e->getIdDetentor_fk().'</td>
                        <td>'.$e->getIdMarca_fk().'</td>
                        <td>'.$e->getIdModelo_fk().'</td>
                        <td>'.$e->getDataUltimaCalibragem().'</td>
                        <td>'.$e->getDataChegada().'</td>
                        <td><a href="controlador.php?action=editar_equipamento&idEquipamento='.$e->getIdEquipamento().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_equipamento&idEquipamento='.$e->getIdEquipamento().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Equipamentoes"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">detentor</th>
      <th scope="col">marca</th>
      <th scope="col">modelo</th>
      <th scope="col">data da última calibragem</th>
      <th scope="col">data chegada</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?=$html?>    
  </tbody>
</table>


<?php 
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo(); 
?>

