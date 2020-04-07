<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Modelo/Modelo.php';
require_once 'classes/Modelo/ModeloRN.php';

$objPagina = new Pagina();
$objModelo = new Modelo();
$objModeloRN = new ModeloRN();
$html = '';

try{
    
    $arrModelos = $objModeloRN->listar($objModelo);
    foreach ($arrModelos as $m){   
        $html.='<tr>
                    <th scope="row">'.$m->getIdModelo().'</th>
                        <td>'.$m->getModelo().'</td>
                        <td><a href="controlador.php?action=editar_modelo&idModelo='.$m->getIdModelo().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_modelo&idModelo='.$m->getIdModelo().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Modelos"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">modelo</th>
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

