<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilUsuario/PerfilUsuario.php';
require_once 'classes/PerfilUsuario/PerfilUsuarioRN.php';

$objPagina = new Pagina();
$objPerfilUsuario = new PerfilUsuario();
$objPerfilUsuarioRN = new PerfilUsuarioRN();
$html = '';

try{
    
    $arrPerfisUsuarios = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    foreach ($arrPerfisUsuarios as $pu){   
        $html.='<tr>
                    <th scope="row">'.$pu->getIdPerfilUsuario().'</th>
                    <td>'.$pu->getPerfil().'</td>
                    <td><a href="controlador.php?action=editar_perfilUsuario&idPerfilUsuario='.$pu->getIdPerfilUsuario().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_perfilUsuario&idPerfilUsuario='.$pu->getIdPerfilUsuario().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Perfis Usuários"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">perfil</th>
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

