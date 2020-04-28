<?php

/*
 *  Author: Carine Bertagnolli Bathaglini
 */

try {
    session_start();
    require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';
    require_once __DIR__.'/../../utils/Alert.php';

    require_once __DIR__.'/../../classes/Amostra/Amostra.php';
    require_once __DIR__.'/../../classes/Amostra/AmostraRN.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__.'/../../classes/Paciente/Paciente.php';
    require_once __DIR__.'/../../classes/Paciente/PacienteRN.php';

    require_once __DIR__.'/../../classes/InfosTubo/InfosTubo.php';
    require_once __DIR__.'/../../classes/InfosTubo/InfosTuboRN.php';


    Sessao::getInstance()->validar();


    $array_colunas = array('CÓDIGO', 'SITUAÇÃO AMOSTRA', 'DATA COLETA','PERFIL AMOSTRA','CADASTRO PENDENTE');
    $array_tipos_colunas = array('text', 'text', 'date', 'text','select');

    $value = '';
    $retornou_certo = false;
    $options = '';
    $position = null;
    $inputs = '';
    $error = '';
    $arrAmostras_pesquisa = array();
    $valor_selecionado = '';
    $select_a_r_g='';
    $select_perfis = '';
    $disabled = '';$onchange ='';

    /* AMOSTRA */
    $objAmostra = new Amostra();
    $objAmostraRN = new AmostraRN();

    /* PERFIL PACIENTE */
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();

    /* PACIENTE */
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();

    /* TUBO */
    $objTubo = new Tubo();
    $objTuboRN = new TuboRN();


    /* INFOS TUBO */
    $objInfosTubo = new InfosTubo();
    $objInfosTuboRN = new InfosTuboRN();


    $alert = '';
    $html = '';

    $options = Interf::montar_select_pesquisa($array_colunas,$position);

    if(isset($_POST['selecionar_amostra'])){
        if(isset($_POST['txtCodAmostra'])){
            $objAmostra->setIdAmostra($_POST['txtCodAmostra']);
            $objAmostra = $objAmostraRN->consultar($objAmostra);
            $objTubo->setIdAmostra_fk($objAmostra->getIdAmostra());
            $arr_tubos[] = $objTuboRN->listar($objTubo);

            //print_r($arr_tubos);


            foreach ($arr_tubos as $tubos) {
                foreach ($tubos as $t) {

                    $objInfosTubo->setIdTubo_fk($t->getIdTubo());
                    $arr_infos_tubo[] = $objInfosTuboRN->listar($objInfosTubo);
                }
            }


            foreach ($arr_infos_tubo as $infos) {
                foreach ($infos as $i) {
                    $objTubo->setIdTubo($i->getIdTubo_fk());
                    $objTubo = $objTuboRN->consultar($objTubo);

                            $html .= '<tr>
                    <th scope="row">' . Pagina::formatar_html($objAmostra->getCodigoAmostra()) . '</th>
                             <td>' . Pagina::formatar_html($i->getIdInfosTubo()) . '</td>
                            <td>' . Pagina::formatar_html($objTubo->getIdTubo()) . '</td>
                            <td>' . Pagina::formatar_html($objTubo->getIdTubo_fk()) . '</td>
                             <td>' . Pagina::formatar_html($objTubo->getTuboOriginal()) . '</td>
                             <td>' . Pagina::formatar_html($objTubo->getTipo()) . '</td>
                            <td>' . Pagina::formatar_html($i->getReteste()) . '</td>
                            <td>' . Pagina::formatar_html($i->getStatusTubo()) . '</td>'
                                . '<td>' . Pagina::formatar_html($i->getEtapa()) . '</td>
                 <td>' . Pagina::formatar_html($i->getVolume()) . '</td>
                            
                        </tr>';
                }
            }

        }
    }




} catch (Throwable $ex) {
    //die($ex);
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::abrir_head("Listar Amostras");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();



echo $alert.
    '<div class="conteudo_listar">' .
    Pagina::montar_topo_listar('LISTAR AMOSTRAS', null, null, 'cadastrar_amostra', 'NOVA AMOSTRA');

echo '  <div class="conteudo_grande">
        <form method="POST"  >
        <div class="form-row" >
            <div class="col-md-10" style="width: 100%;">
                <label>Informe o número da amostra</label>
                <input type="text" class="form-control" id="idCodAmostra" style="text-align: center;"
                       name="txtCodAmostra" required value="">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" type="submit"  style="margin-top: 33px;width: 100%;margin-left: 0px;" name="selecionar_amostra">selecionar</button>
            </div>
            </div>
        </form>
        </div>';



echo '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">CÓDIGO DA AMOSTRA</th>
                        <th scope="col">COD INFOS</th>
                        <th scope="col">CÓDIGO TUBO</th>
                        <th scope="col">ORIGINOU</th>
                        <th scope="col">TUBO ORIGINAL</th>
                        <th scope="col">TIPO</th>
                        <th scope="col">RETESTE</th>
                        <th scope="col">STATUS TUBO</th>
                        <th scope="col">ETAPA</th>
                        <th scope="col">VOLUME</th>
                    </tr>
                </thead>
                <tbody>'
    . $html .
    '</tbody>
            </table>
        </div>
    </div>';


Pagina::getInstance()->mostrar_excecoes();
Pagina::getInstance()->fechar_corpo();
