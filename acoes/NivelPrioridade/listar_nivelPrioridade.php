<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/NivelPrioridade/NivelPrioridade.php';
require_once 'classes/NivelPrioridade/NivelPrioridadeRN.php';

$objPagina = new Pagina();
$objNivelPrioridade = new NivelPrioridade();
$objNivelPrioridadeRN = new NivelPrioridadeRN();
$html = '';

try{
    
    $arrNivelPrioridades = $objNivelPrioridadeRN->listar($objNivelPrioridade);
    foreach ($arrNivelPrioridades as $d){   
        $html.='<tr>
                    <th scope="row">'.$d->getIdNivelPrioridade().'</th>
                    <td>'.$d->getNivel().'</td>
                    <td><a href="controlador.php?action=editar_nivelPrioridade&idNivelPrioridade='.$d->getIdNivelPrioridade().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_nivelPrioridade&idNivelPrioridade='.$d->getIdNivelPrioridade().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Níveis de Prioridade"); ?>
<link rel="stylesheet" type="text/css" href="css/precadastros.css">
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>

<div class="conteudo_tabela">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">NÍVEL DE PRIORIDADE</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?=$html?>    
  </tbody>
</table>
    </div>


<?php 
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo(); 
?>

