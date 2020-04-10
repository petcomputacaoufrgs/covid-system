<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Detentor/Detentor.php';
require_once 'classes/Detentor/DetentorRN.php';

$objPagina = new Pagina();
$objDetentor = new Detentor();
$objDetentorRN = new DetentorRN();
$html = '';

try{
    
    $arrDetentors = $objDetentorRN->listar($objDetentor);
    foreach ($arrDetentors as $r){   
        $html.='<tr>
                    <th scope="row">'.$r->getIdDetentor().'</th>
                        <td>'.$r->getDetentor().'</td>
                        <td><a href="controlador.php?action=editar_detentor&idDetentor='.$r->getIdDetentor().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_detentor&idDetentor='.$r->getIdDetentor().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Detentores"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">detentor</th>
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

