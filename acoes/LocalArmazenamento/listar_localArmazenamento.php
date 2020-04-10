<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Usuario/Usuario.php';
require_once 'classes/Usuario/UsuarioRN.php';

$objPagina = new Pagina();
$objUsuario = new Usuario();
$objUsuarioRN = new UsuarioRN();
$html = '';

try{
    
    $arrUsuarios = $objUsuarioRN->listar($objUsuario);
    foreach ($arrUsuarios as $u){   
        $html.='<tr>
                    <th scope="row">'.$u->getIdUsuario().'</th>
                    <td>'.$u->getMatricula().'</td>
                    <td><a href="controlador.php?action=editar_usuario&idUsuario='.$u->getIdUsuario().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_usuario&idUsuario='.$u->getIdUsuario().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Usuários"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">matrícula</th>
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

