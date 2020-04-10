<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Marca/Marca.php';
require_once 'classes/Marca/MarcaRN.php';

$objPagina = new Pagina();
$objMarca = new Marca();
$objMarcaRN = new MarcaRN();
$html = '';

try{
    
    $arrMarcas = $objMarcaRN->listar($objMarca);
    foreach ($arrMarcas as $m){   
        $html.='<tr>
                    <th scope="row">'.$m->getIdMarca().'</th>
                        <td>'.$m->getMarca().'</td>
                        <td><a href="controlador.php?action=editar_marca&idMarca='.$m->getIdMarca().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_marca&idMarca='.$m->getIdMarca().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Marcas"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">marca</th>
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

