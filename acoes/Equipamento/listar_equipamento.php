<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

session_start();
try{

     require_once __DIR__.'/../../classes/Sessao/Sessao.php';
    require_once __DIR__.'/../../classes/Pagina/Pagina.php';
    require_once __DIR__.'/../../classes/Excecao/Excecao.php';

    require_once __DIR__.'/../../classes/Equipamento/Equipamento.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoRN.php';

    require_once __DIR__.'/../../classes/Marca/Marca.php';
    require_once __DIR__.'/../../classes/Marca/MarcaRN.php';

    require_once __DIR__.'/../../classes/Modelo/Modelo.php';
    require_once __DIR__.'/../../classes/Modelo/ModeloRN.php';

    require_once __DIR__.'/../../classes/Detentor/Detentor.php';
    require_once __DIR__.'/../../classes/Detentor/DetentorRN.php';

    $objEquipamento = new Equipamento();
    $objEquipamentoRN = new EquipamentoRN();
    $html = '';

    $objMarca = new Marca();
    $objMarcaRN = new MarcaRN();

    $objModelo = new Modelo();
    $objModeloRN = new ModeloRN();

    $objDetentor = new Detentor();
    $objDetentorRN = new DetentorRN();


    $arrEquipamentos = $objEquipamentoRN->listar($objEquipamento);
    foreach ($arrEquipamentos as $e){

        $objMarca->setIdMarca($e->getIdMarca_fk());
        $objMarca = $objMarcaRN->consultar($objMarca);

        $objModelo->setIdModelo($e->getIdModelo_fk());
        $objModelo = $objModeloRN->consultar($objModelo);

        $objDetentor->setIdDetentor($e->getIdDetentor_fk());
        $objDetentor = $objDetentorRN->consultar($objDetentor);

        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($e->getIdEquipamento()).'</th>
                        <td>'.Pagina::formatar_html($objDetentor->getDetentor()).'</td>
                        <td>'.Pagina::formatar_html($objMarca->getMarca()).'</td>
                        <td>'.Pagina::formatar_html($objModelo->getModelo()).'</td>
                        <td>'.Pagina::formatar_html($e->getDataUltimaCalibragem()).'</td>
                        <td>'.Pagina::formatar_html($e->getDataChegada()).'</td>
                        <td>';
        
            if(Sessao::getInstance()->verificar_permissao('editar_equipamento')){      
                $html.= '<a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=editar_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'">Editar</a>';
            }
            $html .= '</td><td>';
                if(Sessao::getInstance()->verificar_permissao('remover_equipamento')){
                   $html.= ' <a href="'. Sessao::getInstance()->assinar_link('controlador.php?action=remover_equipamento&idEquipamento='.Pagina::formatar_html($e->getIdEquipamento())).'">Remover</a>';
                }
            $html .='</td></tr>';
    }
    
} catch (Exception $ex) {
  Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Listar Equipamentos");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();

echo    '
    <div class="conteudo_listar">'.
    
       Pagina::montar_topo_listar('LISTAR EQUIPAMENTOS', null,null,'cadastrar_equipamento', 'NOVO EQUIPAMENTO').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">detentor</th>
                        <th scope="col">marca</th>
                        <th scope="col">modelo</th>
                        <th scope="col">data da última calibragem</th>
                        <th scope="col">data chegada</th>
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