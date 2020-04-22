<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
require_once '../classes/Sessao/Sessao.php';

require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';

require_once '../classes/Recurso/Recurso.php';
require_once '../classes/Recurso/RecursoRN.php';

require_once '../classes/PerfilUsuario/PerfilUsuario.php';
require_once '../classes/PerfilUsuario/PerfilUsuarioRN.php';

require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso.php';
require_once '../classes/Rel_perfilUsuario_recurso/Rel_perfilUsuario_recurso_RN.php';

$html = '';

try{
    Sessao::getInstance()->validar();
    /* RECURSO */
    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    
    /* PERFIL USUÁRIO + RECURSO */
    $objRel_perfilUsuario_recurso = new Rel_perfilUsuario_recurso();
    $objRel_perfilUsuario_recurso_RN = new Rel_perfilUsuario_recurso_RN();

    /* PERFIL DO USUÁRIO */
    $objPerfilUsuario = new PerfilUsuario();
    $objPerfilUsuarioRN = new PerfilUsuarioRN();
    
    $arr_perfis = $objPerfilUsuarioRN->listar($objPerfilUsuario);
    
    $arrPR = $objRel_perfilUsuario_recurso_RN->listar($objRel_perfilUsuario_recurso);

    $recursos = '';$indices_recursos='';$arr_perfisPercorridos = array();
    foreach ($arr_perfis as $p){
        $recursos ='';$indices_recursos='';
        foreach ($arrPR as $PERFIL_RECURSO){ 
           if( $PERFIL_RECURSO->getIdPerfilUsuario_fk() == $p->getIdPerfilUsuario()){

               $objPerfilUsuario->setIdPerfilUsuario($PERFIL_RECURSO->getIdPerfilUsuario_fk());
               $objPerfilUsuario = $objPerfilUsuarioRN->consultar($objPerfilUsuario);               


               $objRecurso->setIdRecurso($PERFIL_RECURSO->getIdRecurso_fk());
               $objRecurso = $objRecursoRN->consultar($objRecurso);

               
                $recursos .= $objRecurso->getNome().' - '.$objRecurso->getS_n_menu() .";  ";
                $indices_recursos .=$objRecurso->getIdRecurso().";";
               
               
           }
        }
        
        if(!in_array($objPerfilUsuario->getIdPerfilUsuario(),$arr_perfisPercorridos)){ // se o array de perfis que já foram percorridos  não contiver um perfil, o adiciona
         $arr_perfisPercorridos[] = $objPerfilUsuario->getIdPerfilUsuario();
        
         $indices_recursos = substr($indices_recursos, 0, -1);
            $html.='<tr>
                <th scope="row">'.Pagina::formatar_html($objPerfilUsuario->getPerfil()).'</th> 
                    <td>'.Pagina::formatar_html($recursos).'</td>
                    <td>';
                            
            if(Sessao::getInstance()->verificar_permissao('editar_rel_perfilUsuario_recurso')){      
                $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_rel_perfilUsuario_recurso&idRecurso='.Pagina::formatar_html($indices_recursos).
                            '&idPerfilUsuario='.Pagina::formatar_html($objPerfilUsuario->getIdPerfilUsuario())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_rel_perfilUsuario_recurso')){
                   $html.= '<a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_rel_perfilUsuario_recurso&idRecurso='.Pagina::formatar_html($indices_recursos).
                            '&idPerfilUsuario='.Pagina::formatar_html($objPerfilUsuario->getIdPerfilUsuario())).'">Remover</a>';
                }
            $html .='</td></tr>';
        }

           
        
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Relacionamento do Perfil com os Recursos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo '
    <div class="conteudo_listar">'.
       Pagina::montar_topo_listar('LISTAR RELACIONAMENTO PERFIL USUÁRIO COM OS RECURSOS', null,null,'cadastrar_rel_perfilUsuario_recurso', 'NOVO PERFIL USUÁRIO + RECURSO').
   '<div class="conteudo_tabela">
    <table class="table table-hover">
      <thead>
        <tr>
            <th scope="col">PERFIL</th>
            <th scope="col">RECURSOS</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
      </thead>
      <tbody>'
            .$html.
      '</tbody>
    </table>
    </div>
</div>';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
