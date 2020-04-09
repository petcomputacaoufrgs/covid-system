<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Amostra/Amostra.php';
require_once 'classes/Amostra/AmostraRN.php';

$objPagina = new Pagina();
$objAmostra = new Amostra();
$objAmostraRN = new AmostraRN();
$html = '';

try{
    
    $arrAmostras = $objAmostraRN->listar($objAmostra);
    foreach ($arrAmostras as $r){   
        if($r->getAceita_recusa() == 'r'){
            $result = 'Recusada';
            $style  = ' style="background-color:rgba(255, 0, 0, 0.2);" ';
        }else if($r->getAceita_recusa() == 'a'){
            $result = 'Aceita';
            $style  = ' style="background-color:rgba(0, 255, 0, 0.2);" ';
        }
        $html.='<tr'.$style .'>
                    <th scope="row">'.$r->getIdAmostra().'</th>
                            <td>'.$result.'</td>
                            <td>'.$r->getStatusAmostra().'</td>
                            <td>'.$r->getDataHoraColeta() .'</td>
                        <td><a href="controlador.php?action=editar_amostra&idAmostra='.$r->getIdAmostra().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_amostra&idAmostra='.$r->getIdAmostra().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Amostras"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">CÓDIGO</th>
      <th scope="col">ACEITA OU RECUSADA</th>
      <th scope="col">STATUS DA AMOSTRA</th>
      <th scope="col">DATA E HORA DA COLETA</th>
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

