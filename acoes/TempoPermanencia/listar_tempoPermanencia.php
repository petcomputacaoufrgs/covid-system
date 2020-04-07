<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TempoPermanencia/TempoPermanencia.php';
require_once 'classes/TempoPermanencia/TempoPermanenciaRN.php';

$objPagina = new Pagina();
$objTempoPermanencia = new TempoPermanencia();
$objTempoPermanenciaRN = new TempoPermanenciaRN();
$html = '';

try{
    
    $arrTempoPermanencias = $objTempoPermanenciaRN->listar($objTempoPermanencia);
    foreach ($arrTempoPermanencias as $tp){   
        $html.='<tr>
                    <th scope="row">'.$tp->getIdTempoPermanencia().'</th>
                        <td>'.$tp->getTempoPermanencia().'</td>
                        <td><a href="controlador.php?action=editar_tempoPermanencia&idTempoPermanencia='.$tp->getIdTempoPermanencia().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_tempoPermanencia&idTempoPermanencia='.$tp->getIdTempoPermanencia().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Tempos de Permanências"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">tempo de permanência</th>
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

