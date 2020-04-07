<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamento.php';
require_once 'classes/TipoLocalArmazenamento/TipoLocalArmazenamentoRN.php';

$objPagina = new Pagina();
$objTipoLocalArm = new TipoLocalArmazenamento();
$objTipoLocalArmRN = new TipoLocalArmazenamentoRN();
$html = '';

try{
    
    $arrTipoLocais = $objTipoLocalArmRN->listar($objTipoLocalArm);
    foreach ($arrTipoLocais as $tl){   
        $html.='<tr>
                    <th scope="row">'.$tl->getIdTipoLocalArmazenamento().'</th>
                    <td>'.$tl->getNomeLocal().'</td>
                    <td><a href="controlador.php?action=editar_tipoLocalArmazenamento&idTipoLocalArmazenamento='.$tl->getIdTipoLocalArmazenamento().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_tipoLocalArmazenamento&idTipoLocalArmazenamento='.$tl->getIdTipoLocalArmazenamento().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Tipos de Locais de Armazenamento"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">nome do local</th>
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

