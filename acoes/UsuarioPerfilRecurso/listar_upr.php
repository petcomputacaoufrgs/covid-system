<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Usuario/Usuario.php';
require_once '../classes/Usuario/UsuarioRN.php';

require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once '../classes/Recurso/Recurso.php';
require_once '../classes/Recurso/RecursoRN.php';

/* Relacionamentos */
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario.php';
require_once '../classes/Rel_usuario_perfilUsuario/Rel_usuario_perfilUsuario_RN.php';

require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

/* UTILIDADES */
require_once '../utils/Utils.php';

$utils = new Utils();
$objPagina = new Pagina();
$html = '';

try {

    /* USUÁRIO */
    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();

    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();

    /* USUÁRIO + PERFIL DO USUÁRIO */
    $objRel_usuario_perfilUsuario = new Rel_usuario_perfilUsuario();
    $objRel_usuario_perfilUsuario_RN = new Rel_usuario_perfilUsuario_RN();

    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();
    
    $arrPR = $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);
    $arrUP = $objRel_usuario_perfilUsuario_RN->listar($objRel_usuario_perfilUsuario);
    
    foreach ($arrUP as $USUARIO_PERFIL){ 
    
        $recursos = '';$indices_recursos='';
        foreach ($arrPR as $PERFIL_RECURSO){ 
           if($USUARIO_PERFIL->getIdPerfilUsuario_fk() == $PERFIL_RECURSO->getIdPerfilUsuario_fk()){
               $objUsuario->setIdUsuario($USUARIO_PERFIL->getIdUsuario_fk());
               $objUsuario = $objUsuarioRN->consultar($objUsuario);
               
               $objPerfilUsuario->setIdPerfilUsuario($USUARIO_PERFIL->getIdPerfilUsuario_fk());
               $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);               
               
               
               $objRecurso->setIdRecurso($PERFIL_RECURSO->getIdRecurso_fk());
               $objRecurso = $objRecursoRN->consultar($objRecurso);
               
               $recursos .= $objRecurso->getNome().";  ";
               $indices_recursos .=$objRecurso->getIdRecurso().",";
               
           }
        }
        $indices_recursos = substr($indices_recursos, 0, -1);
        $html.='<tr>
            <th scope="row">'.$objUsuario->getMatricula().'</th>
                <td>'.$objPerfilUsuario->getPerfil().'</td> 
                <td>'.$recursos.'</td>
                <td><a href="controlador.php?action=editar_rel_usuario_perfil_recurso&idRecurso='.$indices_recursos.'&idPerfilUsuario='.$objPerfilUsuario->getIdPerfilUsuario().'&idUsuario='.$objUsuario->getIdUsuario().'">Editar</a></td>
                <td><a href="controlador.php?action=remover_rel_usuario_perfil_recurso&idRecurso='.$indices_recursos.'&idPerfilUsuario='.$objPerfilUsuario->getIdPerfilUsuario().'&idUsuario='.$objUsuario->getIdUsuario().'">Remover</a></td>
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
      <th scope="col">USUÁRIO</th>
      <th scope="col">PERFIL</th>
      <th scope="col">RECURSOS</th>
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

