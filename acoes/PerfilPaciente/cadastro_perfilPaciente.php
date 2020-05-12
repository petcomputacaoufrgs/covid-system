<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */
session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';
    require_once __DIR__ . '/../../utils/Utils.php';
    require_once __DIR__ . '/../../utils/Alert.php';

    Sessao::getInstance()->validar();

    $utils = new Utils();
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    $cadastrado_sucesso = '';
    $alert ='';

    switch($_GET['action']){
        case 'cadastrar_perfilPaciente':
            if(isset($_POST['salvar_perfilPaciente'])){
                $objPerfilPaciente->setPerfil($_POST['txtPerfilPaciente']);
                
                $objPerfilPaciente->setCaractere(strtoupper($utils->tirarAcentos($_POST['txtCaractere'])));  
                $objPerfilPaciente->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilPaciente'])));  

                $objPerfilPacienteRN->cadastrar($objPerfilPaciente);
                $alert .= Alert::alert_success("O perfil foi CADASTRADO com sucesso");

            }
        break;
        
        case 'editar_perfilPaciente':
            if(!isset($_POST['salvar_perfilPaciente'])){ //enquanto não enviou o formulário com as alterações
                $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
                $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
            }
            
             if(isset($_POST['salvar_perfilPaciente'])){ //se enviou o formulário com as alterações
                $objPerfilPaciente->setIdPerfilPaciente($_GET['idPerfilPaciente']);
                $objPerfilPaciente->setPerfil($_POST['txtPerfilPaciente']);
                $objPerfilPaciente->setCaractere(strtoupper($utils->tirarAcentos($_POST['txtCaractere'])));
                $objPerfilPaciente->setIndex_perfil(strtoupper($utils->tirarAcentos($_POST['txtPerfilPaciente'])));

                 $objPerfilPacienteRN->alterar($objPerfilPaciente);
                 $alert .= Alert::alert_success("O perfil foi ALTERADO com sucesso");

                
            }
            
            
            break;
        default : die('Ação ['.$_GET['action'].'] não reconhecida pelo controlador em cadastro_perfilPaciente.php');  
    }
   
} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Cadastrar Perfil Paciente");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->adicionar_javascript("perfilPaciente");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar('CADASTRAR PERFIL PACIENTE',null,null, 'listar_perfilPaciente', 'LISTAR PERFIL PACIENTE');
echo Alert::alert_warning("Ao realizar o cadastro deve-se criar uma variável estática em PerfilPacienteRN com o respectivo caractere. NÃO REPETIR CARACTERES!!");
Pagina::getInstance()->mostrar_excecoes();

echo $alert.
        '<div class="conteudo" style="margin-top: -50px;">
             <div class="formulario">
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="label_perfilPaciente">Digite o perfil do paciente:</label>
                            <input type="text" class="form-control" id="idPerfilPaciente" placeholder="Perfil do paciente" 
                                   onblur="validaPerfilPaciente()" name="txtPerfilPaciente" 
                                   required value="'. Pagina::formatar_html($objPerfilPaciente->getPerfil()).'">
                            <div id ="feedback_perfilPaciente"></div>
    
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="label_perfilPaciente">Digite o caractere:</label>
                            <input type="text" class="form-control" id="idCaracterePerfilPaciente" placeholder="Caractere" 
                                   onblur="validaCaractere()" name="txtCaractere" 
                                   required value="'. Pagina::formatar_html($objPerfilPaciente->getCaractere()).'">
                            <div id ="feedback_caracterePerfilPaciente"></div>
    
                        </div>
                    </div>  
                    <button class="btn btn-primary" type="submit" name="salvar_perfilPaciente">Salvar</button>
                </form>
            </div>
        </DIV>';


Pagina::getInstance()->fechar_corpo(); 



