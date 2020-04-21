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
    $alert = '';
    $perfisSelecionados = '';
    $capela_liberada = 'n';
    $select_perfis = '';
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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

        Interf::getInstance()->montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', 'this.form.submit()');
        $alert .= Alert::alert_primary('Em caso de prioridade por perfil, selecione os perfis na ordem da prioridade (o primeiro selecionado terá a MAIOR prioridade)');

        if (isset($_POST['enviar_perfil'])) { //se enviou o perfil e a prioridade

            if ($_POST['sel_prioridade'] == 'dcol') {
                $arr_amostras = $objAmostraRN->filtro_menor_data($objAmostra);
            }

            if (isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
                $perfisSelecionados = '';
                for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                    $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';

                    if ($_POST['sel_prioridade'] == 'dcol') {
                        foreach ($arr_amostras as $amostra) {
                            if ($amostra->getIdPerfilPaciente_fk() == $_POST['sel_perfis'][$i] &&
                                $amostra->get_a_r_g() == 'a') {
                                $arr_amostras_selecionadas[] = $amostra;
                            }
                        }
                    } else {
                        $objAmostra->setIdPerfilPaciente_fk($_POST['sel_perfis'][$i]);
                        $objAmostra->set_a_r_g('a');
                        $arr_amostras_selecionadas[] = $objAmostraRN->listar($objAmostra); //todas as amostras de um perfil X
                    }


                }

                if (count($arr_amostras_selecionadas) > 0) {

                    foreach ($arr_amostras_selecionadas as $a) { //todas as amostras com perfil X
                        foreach ($a as $item) {
                            $objTubo->setIdAmostra_fk($item->getIdAmostra());
                            $arr_tubos[] = $objTuboRN->listar($objTubo);
                        }
                    }

                    foreach ($arr_tubos as $tubo) {
                        foreach ($tubo as $t) {
                            if ($_POST['sel_prioridade'] == 'r') {
                                $objInfosTubo->setReteste('s');
                            }
                            $objInfosTubo->setIdTubo_fk($t->getIdTubo());
                            $objInfosTubo->setStatusTubo("Aguardando preparação");
                            $arr_infosTubo[] = $objInfosTuboRN->listar($objInfosTubo); //todos os infos tubo em que o status é "Aguardando preparação"

                        }
                    }


                    foreach ($arr_infosTubo as $info) {
                        if ($info != null) {
                            foreach ($info as $i) {
                                if ($i != null){
                                    print_r($i);
                                    echo $i->getIdTubo_fk();
                                    $objTubo->setObjInfosTubo($info);

                                    $objTubo->setIdTubo_fk($i->getIdTubo_fk());
                                    //$objTubo = $objTuboRN->listar($objTubo);
                                    //print_r($objTubo);
                                    /*
                                    $objAmostra->setIdAmostra($objTubo->getIdAmostra_fk());
                                    $objAmostra = $objAmostraRN->consultar($objAmostra);
                                    print_r($objAmostra);
                                    die("1");
                                    /*$html .= '
                                        <div class="conteudo_grande preparo" style="margin-top: -5px;">
                                        <form method="post">
                                            <div class="input-group mb-3 ">
                                                  <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                      <input type="checkbox" name="checkbox" aria-label="Checkbox for following text input">
                                                    </div>
                                                  </div>
                                                  <input type="text" disabled class="form-control" value="Amostra ' . $objAmostra->getCodigoAmostra() . '">
                                                </div>
                                          </form>
                                          </div>';*/
                                }
                            }
                        }
                    }
                }

                //if(count($arr_infosTubo) == 0  && $_POST['sel_prioridade'] == 'r'){ $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: RETESTE"); }
                if (count($arr_infosTubo) == 0 && $_POST['sel_prioridade'] == 'dcol') {
                    $alert .= Alert::alert_warning("Nenhuma amostra encontrada com o filtro: DATA DE COLETA");
                }


                //print_r($arr_amostras_resultado);
                //print_r($arr_infosTubo);


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


} catch (Throwable $ex) {
    die($ex);
}


Pagina::abrir_head("LOCK capela");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
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
            <form method="POST">
                <div class="form-row" >
                   <div class="col-md-12">
                        <label for="label_perfisAmostras">Selecione um perfil de amostra</label>'
                        . $select_perfis .
                    '</div>
                </div>
                <div class="form-row" >
                     <div class="col-md-12">
                        <label for="label_prioridade">Selecione uma prioridade </label>
                        <select id="idPrioridade"  class="form-control" name="sel_prioridade" onblur="">
                            <option value="0">Selecione</option>
                            <option value="r">Reteste</option>
                            <option value="dcol">Data de coleta</option>
                            <option value="p">Perfil de amostra</option>
                        </select>
                    </div>
                </div>
                <div class="form-row" >
                    <div class="col-md-12">
                        <button class="btn btn-primary" style="margin-top: 31px;" type="submit" name="enviar_perfil">SELECIONAR</button>
                    </div>
                </div>
            </form>
        </div>';


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

    echo $html;



}

Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();