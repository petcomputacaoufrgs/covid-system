<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/TipoAmostra/TipoAmostra.php';
require_once 'classes/TipoAmostra/TipoAmostraRN.php';

$objPagina = new Pagina();
$objTipoAmostra = new TipoAmostra();
$objTipoAmostraRN = new TipoAmostraRN();
$html = '';

try{
    
    $arrTiposAmostras = $objTipoAmostraRN->listar($objTipoAmostra);
    foreach ($arrTiposAmostras as $ta){   
        $html.='<tr>
                    <th scope="row">'.$ta->getIdTipoAmostra().'</th>
                    <td>'.$ta->getTipo().'</td>
                    <td><a href="controlador.php?action=editar_tipoAmostra&idTipoAmostra='.$ta->getIdTipoAmostra().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_tipoAmostra&idTipoAmostra='.$ta->getIdTipoAmostra().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Tipos de Amostras"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">tipo</th>
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

