<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

use InfUfrgs\Pagina\Pagina;
use InfUfrgs\Excecao\Excecao;
use InfUfrgs\Sexo\Sexo;
use InfUfrgs\Sexo\SexoRN;

$objPagina = new Pagina();
$objSexo = new Sexo();
$objSexoRN = new SexoRN();
$html = '';

try{
    
    $arrSexos = $objSexoRN->listar($objSexo);
    foreach ($arrSexos as $s){   
        $html.='<tr>
                    <th scope="row">'.$s->getIdSexo().'</th>
                    <td>'.$s->getSexo().'</td>
                    <td><a href="controlador.php?action=editar_sexoPaciente&idSexoPaciente='.$s->getIdSexo().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_sexoPaciente&idSexoPaciente='.$s->getIdSexo().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Sexo dos Pacientes"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">sexo</th>
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

