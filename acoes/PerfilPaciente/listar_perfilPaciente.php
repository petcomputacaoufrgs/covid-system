<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/PerfilPaciente/PerfilPaciente.php';
require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';

$objPagina = new Pagina();
$objPerfilPaciente = new PerfilPaciente();
$objPerfilPacienteRN = new PerfilPacienteRN();
$html = '';

try{
    
    $arrPerfisPacientes = $objPerfilPacienteRN->listar($objPerfilPaciente);
    foreach ($arrPerfisPacientes as $pp){   
        $html.='<tr>
                    <th scope="row">'.$pp->getIdPerfilPaciente().'</th>
                    <td>'.$pp->getPerfil().'</td>
                    <td><a href="controlador.php?action=editar_perfilPaciente&idPerfilPaciente='.$pp->getIdPerfilPaciente().'">Editar</a></td>
                    <td><a href="controlador.php?action=remover_perfilPaciente&idPerfilPaciente='.$pp->getIdPerfilPaciente().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Perfis Pacientes"); ?>
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

