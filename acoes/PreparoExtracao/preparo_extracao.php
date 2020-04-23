<?php

session_start();
require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
require_once __DIR__ . '/../../classes/Capela/Capela.php';
require_once __DIR__ . '/../../classes/Capela/CapelaRN.php';
require_once '../classes/Pagina/Interf.php';

require_once __DIR__ . '/../../classes/Amostra/Amostra.php';
require_once __DIR__ . '/../../classes/Amostra/AmostraRN.php';

require_once __DIR__ . '/../../classes/Tubo/Tubo.php';
require_once __DIR__ . '/../../classes/Tubo/TuboRN.php';

require_once __DIR__ . '/../../classes/InfosTubo/InfosTubo.php';
require_once __DIR__ . '/../../classes/InfosTubo/InfosTuboRN.php';

require_once __DIR__ . '/../../utils/Utils.php';
require_once __DIR__ . '/../../utils/Alert.php';

require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

try {
    Sessao::getInstance()->validar();
    $utils = new Utils();

    /*
     * Objeto Capela
     */
    $objCapela = new Capela();
    $objCapelaRN = new CapelaRN();

    /*
     * Objeto Capela
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * Objeto Amostra
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * Objeto Tubo
     */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /*
     * Objeto Infos Tubo
     */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();

    $arr_infosTubo = array();
    $arr_tubos = array();
    $arr_amostras_resultado = array();
    $arr_amostras_selecionadas = array();
    $perfis_nome = array();
    $alert = '';
    $perfisSelecionados = '';
    $capela_liberada = 'n';
    $liberar_prioridade = 'n';
    $select_perfis = '';
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $objPerfilPaciente = new PerfilPaciente();
    $arrPerfis = $objPerfilPacienteRN->listar($objPerfilPaciente);

    if (isset($_POST['lock_capela'])) {
        $arr = $objCapelaRN->listar($objCapela);
        $arr_capelas_livres = $objCapelaRN->bloquear_registro($objCapela);

        if (empty($arr_capelas_livres)) {
            $capela_liberada = 'n';
            $alert = Alert::alert_error_semCapelaDisponivel();
        } else {
            header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idCapela=' . $arr_capelas_livres[0]->getIdCapela()));
            die();
        }
    }

    /*
     * SÓ CHEGA AQUI QUANDO UMA CAPELA ESTÁ LIVRE
     */
    if (isset($_GET['idCapela']) && $_GET['idCapela'] != null) {
        $capela_liberada = 's';
        $alert .= Alert::alert_success("Há capelas disponíveis");
        $alert .= Alert::alert_primary("Você alocou uma capela");

        Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');

        if (isset($_POST['enviar_perfil'])) { //se enviou o perfil e a prioridade
            if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {

                //$perfisSelecionados = '';
                $idQnt = '&idQnt='.count($_POST['sel_perfis']);
                $paciente_sus = 'n';
                for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                    $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                    $url.= '&idP'.($i+1).'='.$_POST['sel_perfis'][$i];
                    $objPerfilPacienteAux = new PerfilPaciente();
                    $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                    $perfil = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                    $perfis_nome[] = $perfil->getPerfil();
                    if($perfil->getIndex_perfil() == 'PACIENTES SUS'){
                        $paciente_sus = 's';
                    }
                }

                if($paciente_sus == 's'){
                    $perfis_nome = array();
                    $perfis_nome[] = 'PACIENTES SUS';
                    $perfisSelecionados = 'Pacientes SUS;';
                    $objPerfilPaciente->setIndex_perfil('PACIENTES SUS');
                    $perfil = $objPerfilPacienteRN->listar($objPerfilPacienteAux);
                    $perfisSelecionados = $perfil[0]->getPerfil().";";
                    $objPerfilPaciente = new PerfilPaciente();
                    $alert .= Alert::alert_danger('Você selecionou o perfil Paciente SUS, nenhum outro perfil pode ser selecionado junto');
                    $idQnt = 1;
                }
                Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');
                print_r($perfis_nome);
                die();
                //$liberar_prioridade = 's';
                //header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idCapela='. $_GET['idCapela'].$idQnt.$url));
                //die();
            }
        }

        if(isset($_GET['idQnt'])){
            Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, " disabled ", '');
            $liberar_prioridade = 's';
            for ($i=1; $i<=$_GET['idQnt']; $i++){
                $perfisSelecionados .= $_GET['idP'.$i.'']. ';';
                $objPerfilPacienteAux = new PerfilPaciente();
                $objPerfilPacienteAux->setIdPerfilPaciente($_GET['idP'.$i.'']);
                $arr_perfis_selecionados[] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
            }
            //echo $perfisSelecionados;
            Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '');
        }


        print_r($arr_perfis_selecionados);

        if(isset($_POST['sel_prioridade'])){
            $selected_data = '';$selected_perfil =''; $selected_reteste = '';
            if($_POST['sel_prioridade'] == 'dcol') $selected_data = ' selected ';
            if($_POST['sel_prioridade'] == 'p') $selected_perfil = ' selected ';
            if($_POST['sel_prioridade'] == 'r') $selected_reteste = ' selected ';

            if($_POST['sel_prioridade'] == 'p') {

                $prioridade = '<small style="color: red;">Quanto menor o número maior a sua prioridade </small>';
                foreach ($arr_perfis_selecionados as $perfil){
                    $prioridade .= '
                <div class="form-row" >
                    <div class="col-md-3">
                       <label for="label">Prioridade do perfil ' . $perfil->getPerfil() . '</label>
                    </div>
                    <div class="col-md-1">
                       <input type="number" class="form-control" max='. count($arr_perfis_selecionados).' min=1 id="idCPF" placeholder="" 
                              name="prioridade_'.$perfil->getIdPerfilPaciente().'"  value="">
                    </div>
                </div>';
                }
            }else{
                $prioridade = '';
            }
            

        }


        if (isset($_POST['enviar_prioridade'])) { //se enviou o perfil e a prioridade
            if($_POST['sel_prioridade'] != '') {
                $selected_data = '';$selected_perfil =''; $selected_reteste = '';
                if($_POST['sel_prioridade'] == 'dcol') $selected_data = ' selected ';
                if($_POST['sel_prioridade'] == 'r') $selected_reteste = ' selected ';

                if($_POST['sel_prioridade'] == 'p'){
                    foreach ($arrPerfis as $perfil){
                        echo $perfil->getIdPerfilPaciente().': '.$_POST['prioridade_'.$perfil->getIdPerfilPaciente().''];
                    }

                } //$selected_perfil = ' selected ';


                if ($_POST['sel_prioridade'] == 'dcol') { // filtra pela menor data dentre todas as amostras dos perfis selecionados
                    $arr_amostras = $objAmostraRN->filtro_menor_data($objAmostra, $_POST['sel_perfis']);
                }
                //print_r($arr_amostras);

                if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                    $perfisSelecionados = '';
                    for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                        $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';

                        if ($_POST['sel_prioridade'] == 'dcol') { // procura na ordem já
                            foreach ($arr_amostras as $amostra) {
                                if ($amostra->get_a_r_g() == 'a') {
                                    $amostras[$amostra->getIdAmostra()] = $amostra;
                                }
                            }
                        } else {
                            $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfis'][$i]);
                            $objAmostra->set_a_r_g('a');
                            $arr_amostras_selecionadas[$_POST['sel_perfis'][$i]] = $objAmostraRN->listar($objAmostra); //todas as amostras de um perfil X
                        }
                    }
                    echo $perfisSelecionados;

                    if ($_POST['sel_prioridade'] != 'dcol') {
                        foreach ($arr_amostras_selecionadas as $amostra) {
                            foreach ($amostra as $a) {
                                $amostras[$a->getIdAmostra()] = $a;
                            }
                        }
                    }
                    print_r($amostras);
                    if (count($amostras) > 0) {
                        foreach ($amostras as $a) {
                            $objTubo->setIdAmostra_fk($a->getIdAmostra());
                            if (count($objTuboRN->listar($objTubo)) > 0) {
                                $arr_tubos[$a->getIdAmostra()] = $objTuboRN->listar($objTubo);
                            }
                        }

                        foreach ($arr_tubos as $tubo) {
                            foreach ($tubo as $t) {
                                if ($_POST['sel_prioridade'] == 'r') {
                                    $objInfosTubo->setReteste('s');
                                }
                                $objInfosTubo->setIdTubo_fk($t->getIdTubo());
                                $objInfosTubo->setStatusTubo("Aguardando preparação");
                                if (count($objInfosTuboRN->listar($objInfosTubo)) > 0) {
                                    $arr_infosTubo[$t->getIdTubo()] = $objInfosTuboRN->listar($objInfosTubo); //todos os infos tubo em que o status é "Aguardando preparação"
                                    //$idtubos[] = $t->getIdTubo();
                                }

                            }
                        }

                        $qnt = 0;
                        foreach ($arr_infosTubo as $info) {
                            foreach ($info as $i) {

                                $objInfosTubo = $i;
                                //echo $objInfosTubo->getIdTubo_fk();
                                $objTubo->setIdTubo($objInfosTubo->getIdTubo_fk());
                                $objTubo = $objTuboRN->consultar($objTubo);

                                $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                                $objAmostra = $objAmostraRN->consultar($objAmostra);


                                $html .= '
                           
                                    <div class="input-group mb-3 " >
                                          <div class="input-group-prepend">
                                            <div class="input-group-text" >
                                              <input type="checkbox" checked name="checkbox_' . $objAmostra->getIdAmostra() . '" aria-label="Checkbox for following text input">
                                            </div>
                                          </div>
                                          <input type="text" disabled class="form-control" value="Amostra ' . $objAmostra->getCodigoAmostra() . '">
                                    </div>';
                                $qnt++;
                            }
                        }

                        if($qnt > 0) {
                            $titulo = '<div class="conteudo_grande preparo" style="margin-top: -10px;margin-bottom: 0px;">
                                <h4 style="margin-left: 40px;">Quantidade de amostras: ' . $qnt . '</h4>
                                <form method="post">';
                            $html = $titulo . $html . '</form></div>';
                        }


                    }

                    //if(count($arr_infosTubo) == 0  && $_POST['sel_prioridade'] == 'r'){ $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: RETESTE"); }
                    if ($qnt == 0 &&  $_POST['sel_prioridade'] == 'dcol') {
                        $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: DATA DE COLETA");
                    }


                }

                Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', 'this.form.submit()');

                if (isset($_POST['unlock_capela'])) {
                    $objCapela->setIdCapela($_GET['idCapela']);
                    $objCapela = $objCapelaRN->consultar($objCapela);
                    $objCapela->setStatusCapela('LIBERADA');
                    print_r($objCapela);
                    $objCapelaRN->alterar($objCapela);
                    $alert = Alert::alert_success("A capela foi liberada");
                }
            }
        }
    }


} catch (Throwable $ex) {
    die($ex);
}


Pagina::abrir_head("LOCK capela");
Pagina::getInstance()->adicionar_css("precadastros");
if(count($perfis_nome) > 0) {
    Pagina::getInstance()->adicionar_javascript("popUp");
}
Pagina::getInstance()->fechar_head();
?>

<?php


Pagina::getInstance()->montar_menu_topo();
echo $alert;
if ($capela_liberada == 'n') {
    echo
    '<div class="conteudo_grande">
            <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="lock_capela">VERIFICAR DISPONIBILIDADE DA CAPELA</button>
                    </div>
                </div>
            </form>
        </div>';
}

if ($capela_liberada == 's') {
    echo '
        <div class="conteudo_grande">
            <form method="POST" name="inicio">
            <div class="form-row" >';
                    if(isset($_GET['idQnt'])){
                        $col_md = 'col-md-12';
                        $button_selecionar = 'n';
                    }else{
                        $col_md = 'col-md-10';
                        $button_selecionar = 's';
                    }
                   echo '<div class="'.$col_md.'">
                        <label for="label_perfisAmostras">Selecione um perfil de amostra</label>'
                    . $select_perfis .
                    '</div>';
                    if($button_selecionar == 's'){
                     echo '<div class="col-md-2" >
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit" data-target="#exampleModalCenter2" name="enviar_perfil">SELECIONAR</button>
                      </div>';
                      }
                echo '</div>
                </form>';
    echo '<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tem certeza que dejesa deseja selecionar os perfis abaixo? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">';
                    foreach ($perfis_nome as $nome){
                        echo "#".$nome."<br>";
                    }
                echo'</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                    <button type="button"  class="btn btn-primary">
                    <a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=montar_preparo_extracao&idCapela='. $_GET['idCapela'].$idQnt.$url).'">Tenho certeza</a></button>
                </div>
            </div>
        </div>
    </div>';


    if($liberar_prioridade == 's') {
        echo '<form method="POST">
                <div class="form-row" >
                     <div class="col-md-12">
                     
                        <label for="label_prioridade">Selecione uma prioridade </label>
                        <select id="idPrioridade"  class="form-control" name="sel_prioridade" 
                                onchange="this.form.submit()" onblur="">
                            <option  value="0">Selecione</option>
                            <option ' . $selected_reteste . ' value="r">Reteste</option>
                            <option ' . $selected_data . ' value="dcol">Data de coleta</option>
                            <option ' . $selected_perfil . ' value="p">Perfil de amostra</option>
                        </select>
                    </div>
                </div>'
            . $prioridade .

            '
                <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" style="margin-top: 31px;" type="submit" name="enviar_perfil">SELECIONAR</button>
                    </div>
                </div>
            </form>
        </div>';

        echo $html;
    }

    echo
    '<div class="conteudo_grande">
            <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="unlock_capela">LIBERAR CAPELA</button>
                    </div>
                </div>
            </form>
        </div>';
    echo
    '<div class="conteudo_grande">
             <form method="POST">
                <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit" name="lock_capela">infos</button>
                    </div>
                </div>
            </form>
        </div>';





}


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();