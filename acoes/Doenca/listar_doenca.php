<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Doenca/Doenca.php';
require_once 'classes/Doenca/DoencaRN.php';

$objPagina = new Pagina();
$objDoenca = new Doenca();
$objDoencaRN = new DoencaRN();
$html = '';

try{
    
    $arrDoencas = $objDoencaRN->listar($objDoenca);
    foreach ($arrDoencas as $d){   
        $html.='<tr>
                    <th scope="row">'.$d->getIdDoenca().'</th>
                    <td>'.$d->getDoenca().'</td>
                    <td><a href="controlador.php?action=editar_doenca&idDoenca='.$d->getIdDoenca().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_doenca&idDoenca='.$d->getIdDoenca().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Doenças"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">doença</th>
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

