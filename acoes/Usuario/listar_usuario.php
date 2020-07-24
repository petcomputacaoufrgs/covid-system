<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try {
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../classes/Usuario/Usuario.php';
    require_once __DIR__.'/../../classes/Usuario/UsuarioRN.php';

    require_once __DIR__.'/../../classes/Pesquisa/PesquisaINT.php';

    Sessao::getInstance()->validar();

    $objUsuario = new Usuario();
    $objUsuarioRN = new UsuarioRN();

    switch ($_GET['action']){
        case 'remover_usuario':
            try{
                $objUsuario->setIdUsuario($_GET['idUsuario']);
                $objUsuarioRN->remover($objUsuario);
                header('Location:'. Sessao::getInstance()->assinar_link('controlador.php?action=listar_usuario'));
            }catch (Throwable $ex){
                Pagina::getInstance()->processar_excecao($ex);
            }
    }

    $alert = '';
    $html = '';


    $array_colunas = array('CÓDIGO', 'MATRÍCULA','CPF');
    $array_tipos_colunas = array('text', 'text','text');//,'text');
    $valorPesquisa = '';
    $select_pesquisa = '';
    PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');

    if (isset($_POST['bt_resetar'])) {
        $select_pesquisa = '';
        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, null,null,' onchange="this.form.submit()" ');
    }

    //$html .= $options;

    if(isset($_POST['sel_pesquisa_coluna'])){
        PesquisaINT::montar_select_pesquisa($select_pesquisa,$array_colunas, $_POST['sel_pesquisa_coluna'],null,' onchange="this.form.submit()" ');
        $input = '<input type="' . $array_tipos_colunas[$_POST['sel_pesquisa_coluna']] . '" value="' . $_POST['valorPesquisa'] .
            '" placeholder="'.$array_colunas[$_POST['sel_pesquisa_coluna']].'" name="valorPesquisa" aria-label="Search" class="form-control">';
    }else{
            $input = '<input type="text" disabled value="" id="pesquisaDisabled" placeholder="" name="valorPesquisa" aria-label="Search" class="form-control">';
        }

        if(!isset($_POST['hdnPagina'])){
            $objUsuario->setNumPagina(1);
        } else {
            $objUsuario->setNumPagina($_POST['hdnPagina']);
        }


    if(isset($_POST['valorPesquisa'])){
        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'MATRÍCULA'){
            $objUsuario->setMatricula($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CÓDIGO'){
            $objUsuario->setIdUsuario($_POST['valorPesquisa']);
        }

        if($array_colunas[$_POST['sel_pesquisa_coluna']] == 'CPF'){
            $objUsuario->setCPF($_POST['valorPesquisa']);
        }

    }

    $arrUsuarios = $objUsuarioRN->paginacao($objUsuario);
    $alert .= Alert::alert_info("Foram encontrados ".$objUsuario->getTotalRegistros()." usuários");


    /*
    * PAGINAÇÃO
    */
    $paginacao = '
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">';
    $paginacao .= '<li class="page-item"><input type="button" onclick="paginar(1)" class="page-link" name="btn_paginacao" value="Primeiro"/></li>';
    for($i=0; $i<($objUsuario->getTotalRegistros()/20); $i++){
        $color = '';
        if($objUsuario->getNumPagina() == $i ){
            $color = ' style="background-color: #d2d2d2;" ';
        }
        $paginacao .= '<li '.$color.' class="page-item"><input type="button" onclick="paginar('.($i+1).')" class="page-link" name="btn_paginacao" value="'.($i+1).'"/></li>';
    }
    //$paginacao .= '<li class="page-item"><input type="button" onclick="paginar('.($objAmostra->getTotalRegistros()-1).')" class="page-link" name="btn_paginacao" value="Último"/></li>';
    $paginacao .= '  </ul>
                    </nav>';


    /* FIM PAGINAÇÃO */



    foreach ($arrUsuarios as $u) {
        $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($u->getIdUsuario()) . '</th>
                    <td>' . Pagina::formatar_html($u->getMatricula()) . '</td>';

        //editar usuário
        if (Sessao::getInstance()->verificar_permissao('editar_usuario')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '"><i class="fas fa-edit" style="color: black;"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        if (Sessao::getInstance()->verificar_permissao('remover_usuario')) {
            $html .= '<td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_usuario&idUsuario=' . Pagina::formatar_html($u->getIdUsuario())) . '"><i class="fas fa-trash-alt"></i></a></td>';
        }else{
            $html .= '<td ></td>';
        }

        $html .= '</tr>';
    }
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Listar Usuários");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("pesquisa_pg");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('LISTAR USUÁRIOS', null, null, 'cadastrar_usuario', 'NOVO USUÁRIO');
Pagina::getInstance()->mostrar_excecoes();
echo $alert;
Pagina::montar_topo_pesquisar($select_pesquisa, $input, null,null);

echo '
    
    <form method="post" style="height:40px;margin-left: 1%;width: 98%;">
         <div class="form-row">
            <div class="col-md-12" >
                '.$paginacao.'
             </div>
         </div>
     </form>
       
    <div class="conteudo_grande" style="margin-top: -5px;">
         <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">matrícula</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>'
                . $html .
             '</tbody>
         </table>
    </div>';



Pagina::getInstance()->fechar_corpo();


