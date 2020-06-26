<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/Recurso/Recurso.php';
    require_once __DIR__ . '/../../classes/Recurso/RecursoRN.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    $objRecurso = new Recurso();
    $objRecursoRN = new RecursoRN();
    $alert = '';


    Sessao::getInstance()->validar();
    switch($_GET['action']){
        case 'cadastrar_recurso':
            if(isset($_POST['salvar_recurso'])){
                $objRecurso->setNome($_POST['txtNome']);
                $objRecurso->setS_n_menu( mb_strtolower($_POST['txtSN'],'utf-8'));
                $objRecurso->setEtapa(mb_strtoupper($_POST['txtEtapa'],'utf-8'));

                $objRecurso  = $objRecursoRN->cadastrar($objRecurso);
                $alert.= Alert::alert_success("O recurso -".$objRecurso->getNome()."- foi cadastrado");

                
            }else{
                $objRecurso->setIdRecurso('');
                $objRecurso->setNome('');
                $objRecurso->setS_n_menu('');
                $objRecurso->setEtapa('');
            }
        break;
        
        case 'editar_recurso':
            if(!isset($_POST['salvar_recurso'])){ //enquanto não enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso = $objRecursoRN->consultar($objRecurso);
            }
            
             if(isset($_POST['salvar_recurso'])){ //se enviou o formulário com as alterações
                $objRecurso->setIdRecurso($_GET['idRecurso']);
                $objRecurso->setNome($_POST['txtNome']);
                $objRecurso->setS_n_menu( strtolower($_POST['txtSN']));
                $objRecurso->setEtapa(mb_strtoupper($_POST['txtEtapa'],'utf-8'));
                $objRecursoRN->alterar($objRecurso);
                $alert .= Alert::alert_success("O recurso foi alterado");

             
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_recurso.php');  
    }
   
} catch (Throwable $ex) {
      Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Cadastrar Recurso");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("recurso");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("CADASTRAR RECURSO",null,null,"listar_recurso","LISTAR RECURSOS");
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'

<DIV class="conteudo">
<form method="POST">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="label_nome">Digite o nome:</label>
            <input type="text" class="form-control" id="idNomeRecurso" placeholder="Nome" 
                   onblur="validaNome()" name="txtNome"  value="'.Pagina::formatar_html($objRecurso->getNome()).'">
            <div id ="feedback_nome"></div>

        </div>
        <div class="col-md-4 mb-3">
            <label for="label_etapa">Digite o nome da etapa:</label>
            <input type="text" class="form-control" id="idEtapa" placeholder="Etapa" 
                   onblur="validaEtapa()" name="txtEtapa"  value="'.Pagina::formatar_html($objRecurso->getEtapa()).'">
            <div id ="feedback_etapa"></div>

        </div>
        <div class="col-md-4 mb-3">
            <label for="label_s_n_menu">Digite S/N para o menu:</label>
            <input type="text" class="form-control" id="idSNRecurso" placeholder="S/N" 
                   onblur="validaSNmenu()" name="txtSN"  value="'.Pagina::formatar_html($objRecurso->getS_n_menu()).'">
            <div id ="feedback_s_n_menu"></div>

        </div>
    </div>  
    <button class="btn btn-primary" type="submit" name="salvar_recurso">Salvar</button>
</form>
</DIV>';



Pagina::getInstance()->fechar_corpo();

