<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Recurso/Recurso.php';
require_once 'classes/Recurso/RecursoRN.php';

$objPagina = new Pagina();
$objRecurso = new Recurso();
$objRecursoRN = new RecursoRN();
$html = '';

try{
    
    $arrRecursos = $objRecursoRN->listar($objRecurso);
    foreach ($arrRecursos as $r){   
        $html.='<tr>
                    <th scope="row">'.$r->getIdRecurso().'</th>
                        <td>'.$r->getNome().'</td>
                        <td>'.$r->get_s_n_menu().'</td>
                        <td><a href="controlador.php?action=editar_recurso&idRecurso='.$r->getIdRecurso().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_recurso&idRecurso='.$r->getIdRecurso().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Recursos"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">nome</th>
      <th scope="col">S/N</th>
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

