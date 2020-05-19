<?php
/*
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{
    require_once __DIR__ . '/../../classes/Sessao/Sessao.php';
    require_once __DIR__ . '/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__ . '/../../classes/Excecao/Excecao.php';
    require_once __DIR__ . '/../../utils/Alert.php';
    require_once __DIR__ . '/../../utils/Utils.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__ . '/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';

    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlaca.php';
    require_once __DIR__ . '/../../classes/SolicitacaoMontarPlaca/SolicitacaoMontarPlacaRN.php';

    Sessao::getInstance()->validar();

    $objUtils = new Utils();

    /*
     * AMOSTRA
     */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /*
     * PLACA
     */
    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    /*
     * PROTOCOLO
     */
    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    /*
     * PERFIL PACIENTE
     */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /*
     * RELACIONAMENTO DOS TUBOS COM A PLACA
     */
    $objRelTuboPlaca = new RelTuboPlaca();
    $objRelTuboPlacaRN = new RelTuboPlacaRN();

    /*
    * RELACIONAMENTO DOS PERFIS COM A PLACA
    */
    $objRelPerfilPlaca = new RelPerfilPlaca();
    $objRelPerfilPlacaRN = new RelPerfilPlacaRN();

    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();


    /*
     * SOLICITAÇÃO DE MONTAGEM DA PLACA RTqPCR
     */
    $objSolMontarPlaca = new SolicitacaoMontarPlaca();
    $objSolMontarPlacaRN = new SolicitacaoMontarPlacaRN();


    $alert = '';

    $select_protocolos  = '';
    $select_perfis  = '';
    $perfisSelecionados = '';
    $adicionar_qntMaxAmostras = 'n';
    $btn_selecionar_sumir = 'n';
    $sumir_btn_salvar = 'n';



    InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, $disabled, 'onchange="this.form.submit()"');
    InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', null);

    if(isset($_POST['sel_protocolos'])){
        header('Location: '. Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR&idProtocolo='.$_POST['sel_protocolos']));
        die();
    }


    if(isset($_GET['idProtocolo']) && !isset($_POST['enviar_perfil'])) {
        $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
        $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
        InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, ' disabled ', '');
        $adicionar_qntMaxAmostras = 's';

        if ($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP) {
            $objPerfilPaciente->setCaractere(PerfilPacienteRN::$TP_PACIENTES_SUS);
            $objPerfilPaciente = $objPerfilPacienteRN->listar($objPerfilPaciente);
            $perfisSelecionados = $objPerfilPaciente[0]->getIdPerfilPaciente() . ';';
            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente[0], $objPerfilPacienteRN, 'readonly="readonly"', '', null);
        } else {
            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, '', '', 's');
        }
    }

    if( isset($_GET['idProtocolo']) && isset($_POST['enviar_perfil'])){// isset($_POST['salvar_placa']) )){ //se salvou o perfil
        $objProtocolo->setIdProtocolo($_GET['idProtocolo']);
        $objProtocolo = $objProtocoloRN->consultar($objProtocolo);
        InterfacePagina::montar_select_protocolos($select_protocolos, $objProtocolo, $objProtocoloRN, ' disabled ', '');
        $adicionar_qntMaxAmostras = 's';

        if(isset($_POST['sel_perfis']) && $_POST['sel_perfis'] != null) {
            $paciente_sus = 'n';
            for ($i = 0; $i < count($_POST['sel_perfis']); $i++) {
                $perfisSelecionados .= $_POST['sel_perfis'][$i] . ';';
                $arr_idsPerfis[] = $_POST['sel_perfis'][$i];
                $objPerfilPacienteAux = new PerfilPaciente();
                $objPerfilPacienteAux->setIdPerfilPaciente($_POST['sel_perfis'][$i]);
                $perfil[$i] = $objPerfilPacienteRN->consultar($objPerfilPacienteAux);
                if ($perfil[$i]->getCaractere() == PerfilPacienteRN::$TP_PACIENTES_SUS) {
                    $paciente_sus = 's';
                }
            }
        }





        else{
            $perfisSelecionados = $_POST['hdnPerfisSel'];
            //echo $perfisSelecionados;
            $arr_idsPerfis= explode(";",$perfisSelecionados);
            array_pop($arr_idsPerfis);

        }
        //if($perfisSelecionados = ''){
        //     $perfisSelecionados = $_POST['hdnPerfisSel'];
        //}
        $btn_selecionar_sumir = 's';
        InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' disabled ', '');

        $objAmostra->setObjProtocolo($objProtocolo);
        $objAmostra->setObjPerfil($arr_idsPerfis);
        $arr_amostras = $objAmostraRN->listar_aguardando_RTqCPR($objAmostra);

        $alert .= Alert::alert_info("Foram encontradas " . count($arr_amostras) . " amostras");




        //lista das amostras com o perfil certo, só exibir tudo
        foreach ($arr_amostras as $amostra) {
            if(isset($_POST['enviar_perfil'])){
                $hdnValue= 'S';
                $class = ' sucesso_rgba ';
                $texto = '<i class="fas fa-minus"></i> Remover da placa';
            }else{
                $hdnValue= $_POST['hdnAmostra' . $amostra->getIdAmostra()];
                $texto = '';
                if($hdnValue == 'S') {
                    $class = ' sucesso_rgba ';
                }else{
                    $class = ' error_rgba ';

                }
            }
            $collapse .= '<div id="accordion_' . $amostra->getObjTubo()->getIdTubo() . '" style="margin-top: 10px;">
                                  <div class="card" >
                                    <div class="card-header '.$class.'"  id="heading_' . $amostra->getObjTubo()->getIdTubo() . '" style="padding:2px; height: 50px;">
                                      <h5 class="mb-0" style="margin-top: 5px;">
                                       <input type="hidden" name="hdnAmostra' . $amostra->getIdAmostra() . '" id="hdnAmostra' . $amostra->getIdAmostra() . '"  value="'.$hdnValue.'">  ';


            $collapse .= ' <button type="button" onclick="remover(' . $amostra->getIdAmostra() . ',' . $amostra->getObjTubo()->getIdTubo() . ')" id="btnAmostra' . $amostra->getIdAmostra() . '" style="float: right;font-size: 13px;color: #3a5261;text-decoration: none !important; background: none;border: none;" name="btn_remover">  '.$texto.' </button>';


            $collapse .= ' <button class="btn btn-link" style="text-decoration: none !important;" data-toggle="collapse" type="button"
                                        data-target="#collapse_' . $amostra->getObjTubo()->getIdTubo() . '" aria-expanded="true" 
                                        aria-controls="collapse_' . $amostra->getObjTubo()->getIdTubo() . '">
                                     <h6 style="text-decoration: none !important; color: #3a5261;">' . $amostra->getNickname() . ' - ' . $amostra->getObjPerfil()->getIndex_perfil() . '</h6>                           
                                </button>
                              </h5>
                            </div>
                                
                                    <div id="collapse_' . $amostra->getObjTubo()->getIdTubo() . '" class="collapse show " aria-labelledby="heading_' . $amostra->getObjTubo()->getIdTubo() . '" data-parent="#accordion_' . $amostra->getObjTubo()->getIdTubo() . '">
                                      <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label >Data Coleta:</label>
                                                        <input type="date" disabled  style="text-align: center;" class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="dtDataColeta"  value="' . $amostra->getDataColeta() . '">  
                                                </div>
                                                <div class="col-md-4">
                                                    <label >Tipo amostra:</label>
                                                        <input type="text" style="text-align: center;" disabled class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="txtTipoTubo"  value="' . TuboRN::mostrarDescricaoTipoTubo($amostra->getObjTubo()->getTipo()) . '">  
                                                </div>
                                                <div class="col-md-4">
                                                    <label >Observações:</label>
                                                        <input type="text" disabled style="text-align: center;" class="form-control" id="idData" placeholder="" 
                                                       onblur="" name="txtTipoTubo"  value="' . $amostra->getObservacoes() . '">  
                                                </div>
                                                
                                            </div>
                                      </div>
                                    </div>
                                  </div>
                             </div>';

            if (isset($_POST['salvar_placa'])) {
                if($_POST['hdnAmostra' . $amostra->getIdAmostra()] == 'S') {
                    $arr_amostras_escolhidas[] = $amostra;
                }
            }

        }

        if (isset($_POST['salvar_placa'])) {

            if(count($arr_amostras_escolhidas) == 0){
                $alert = Alert::alert_warning("Nenhuma amostra foi selecionada para a placa");
            }else{
                $alert = Alert::alert_info("Foram selecionadas " . count($arr_amostras_escolhidas) . " amostras");
            }

            // $sumir_btn_salvar = 's';
            print_r($arr_amostras_escolhidas);

            $objPlaca->setIdProtocoloFk($_GET['idProtocolo']);
            $objPlaca->setSituacaoPlaca(PlacaRN::$STA_SOLICITACAO_MONTAGEM_CONCLUIDA);
            $objPlaca->setObjsAmostras($arr_amostras_escolhidas);

            foreach ($arr_idsPerfis as $perfil){
                $objPerfilPaciente->setIdPerfilPaciente($perfil);
                $arr_perfis[] = $objPerfilPaciente;
            }
            $objRelPerfilPlaca->setObjPerfis($arr_perfis);


            InterfacePagina::montar_select_perfisMultiplos($select_perfis, $perfisSelecionados, $objPerfilPaciente, $objPerfilPacienteRN, ' disabled ', '');
        }





        //$objAmostra->setIdPerfilPaciente_fk();
    }



} catch (Throwable $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}

Pagina::getInstance()->abrir_head("Solicitar Montagem Placa RTqPCR");
Pagina::getInstance()->adicionar_css("precadastros");
?>
    <script type="text/javascript">
        function remover(idAmostra,idTubo){

            var sinalizador = document.getElementById('hdnAmostra'+idAmostra).value;
            if(sinalizador == 'S'){
                document.getElementById('hdnAmostra'+idAmostra).value = 'N';
                document.getElementById('btnAmostra'+idAmostra).innerHTML = '<i class="fas fa-plus"></i> Adicionar na placa';
                if (document.getElementById('heading_'+idTubo).classList.contains("sucesso_rgba")) {
                    document.getElementById('heading_'+idTubo).classList.remove("sucesso_rgba");
                    document.getElementById('heading_'+idTubo).classList.add("error_rgba");
                }

            }else {
                document.getElementById('hdnAmostra'+idAmostra).value = 'S';
                document.getElementById('btnAmostra'+idAmostra).innerHTML = ' <i class="fas fa-minus"></i> Remover da placa';

                if (document.getElementById('heading_'+idTubo).classList.contains("error_rgba")) {
                    document.getElementById('heading_'+idTubo).classList.remove("error_rgba");
                    document.getElementById('heading_'+idTubo).classList.add("sucesso_rgba");
                }
            }
        }

    </script>

<?php
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("SOLICITAR MONTAGEM PLACA RTqPCR",null,null,"listar_solicitacoes_montagem","LISTAR SOLICITAÇÕES");
Pagina::getInstance()->mostrar_excecoes();
echo $alert.'
 
<div class="conteudo_grande" style="margin-top: -15px;">
<form method="POST">
    <div class="form-row">';
if($adicionar_qntMaxAmostras == 'n'){
    echo '<div class="col-md-12">';
}else{
    echo '<div class="col-md-8">';
}
echo '<label >Selecione o protocolo:</label>'
    .$select_protocolos;
echo'</div>';
if($adicionar_qntMaxAmostras == 's'){
    echo '<div class="col-md-4">';
    echo '<label >Número máximo de amostras:</label>
                    <input type="number" disabled class="form-control" id="idNumMax" placeholder="nº" 
                   onblur="" name="numMaxAmostras"  value="'.Pagina::formatar_html($objProtocolo->getNumMaxAmostras()).'">';
    echo '</div>';
}

echo'</div>  
</form>';

if($adicionar_qntMaxAmostras == 's') {
    echo '<form method="post">
                <div class="form-row">';
    if($objProtocolo->getCaractere() == ProtocoloRN::$TP_LACEN_IBMP  || $btn_selecionar_sumir == 's' ){
        echo '<div class="col-md-12">';
    }else{
        echo '<div class="col-md-10">';
    }
    echo '<label for="label_nome">Selecione o(s) perfil(s):</label>' .
        $select_perfis . '
                                             
                    </div>
                    <input type="hidden" id="idPerfis" name="hdnPerfisSel" value="'.$perfisSelecionados.'">';
    if($objProtocolo->getCaractere() != ProtocoloRN::$TP_LACEN_IBMP && $btn_selecionar_sumir == 'n') {
        echo '<div class="col-md-2" >
                        <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="enviar_perfil">SELECIONAR</button>
                    </div>';
    }
    echo '</div>';

    if($sumir_btn_salvar == 'n') {
        echo ' <div class="form-row">
                <div class="col-md-6">
                    <button class="btn btn-primary" style="margin-left:0px;margin-top: 31px;width: 100%;" type="submit"  name="salvar_placa">SALVAR</button>
                </div>
            <div class="col-md-6">
                 <button type="button" class="btn btn-primary" style="margin-left:0px;margin-top: 31px;margin-left:0%;width: 100%;color:white;text-decoration: none;" 
                    data-toggle="modal"  data-target="#exampleModalCenter3" name="btn_cancelar" > Cancelar</button>
            </div>
           
            <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="text-align: center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                            Tem certeza que dejesa deseja cancelar? </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        Ao cancelar, nenhum dado será salvo
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
                            <button type="button"  class="btn btn-primary">
                            <a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=solicitar_montagem_placa_RTqPCR') . '">Tenho certeza</a></button>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>';
    }


    if($btn_selecionar_sumir = 's'){
        echo '<div class="form-row">
                <div class="col-md-12" >
                '.$collapse.'
                </div>
               </div>';
    }

    echo '    </form>
       </div>';

    /*if(count($arr_amostras) > 0){
        echo '<div class="conteudo_grande" style="margin-top: -15px;width: 90%; margin-left: 5%;">'.
            $collapse
            .'</div>';

    }*/


}

Pagina::getInstance()->fechar_corpo();

