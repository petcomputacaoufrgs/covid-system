<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */


session_start();
require_once '../classes/Sessao/Sessao.php';
require_once '../classes/Pagina/Pagina.php';
require_once '../classes/Excecao/Excecao.php';
require_once '../classes/Paciente/Paciente.php';
require_once '../classes/Paciente/PacienteRN.php';
require_once '../classes/Etnia/Etnia.php';
require_once '../classes/Etnia/EtniaRN.php';
require_once '../classes/Sexo/Sexo.php';
require_once '../classes/Sexo/SexoRN.php';


try{
    Sessao::getInstance()->validar();
    $objPaciente = new Paciente();
    $objPacienteRN = new PacienteRN();
    $html = '';
    $objSexo = new Sexo();
    $objSexoRN = new SexoRN();
    
    $objEtnia = new Etnia();
    $objEtniaRN = new EtniaRN();
    
    
    $arrPacientes = $objPacienteRN->listar($objPaciente);
    //print_r($arrPacientes);
    
    foreach ($arrPacientes as $p){   
       
        if($p->getIdSexo_fk() != null){
            $objSexo->setIdSexo($p->getIdSexo_fk());
            $objSexo = $objSexoRN->consultar($objSexo);
        }else{
            $objSexo->setSexo('');
        }
        
        if($p->getIdEtnia_fk() != null){
            $objEtnia->setIdEtnia($p->getIdEtnia_fk());
            $objEtnia = $objEtniaRN->consultar($objEtnia);
            $etnia = $objEtnia->getEtnia();
        }else{
            $etnia = '';
        }
         
        $html.='<tr>
                    <th scope="row">'.Pagina::formatar_html($p->getIdPaciente()).'</th>
                        <td>'.Pagina::formatar_html($p->getNome()).'</td>
                        <td>'.Pagina::formatar_html($p->getNomeMae()).'</td>
                        <td>'.Pagina::formatar_html($objSexo->getSexo()).'</td>        
                        <td>'.Pagina::formatar_html($p->getCEP()).'</td>        
                        <td>'.Pagina::formatar_html($etnia).'</td>        
                        <td>'.Pagina::formatar_html($p->getPassaporte()).'</td>        
                        <td>'.Pagina::formatar_html($p->getDataNascimento()).'</td>        
                        <td>'.Pagina::formatar_html($p->getCPF()).'</td>        
                        <td>'.Pagina::formatar_html($p->getRG()).'</td>        
                        
                        <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=editar_paciente&idPaciente='.Pagina::formatar_html($p->getIdPaciente())).'">Editar</a></td>
                        <td><a href="' . Sessao::getInstance()->assinar_link('controlador.php?action=remover_paciente&idPaciente='.Pagina::formatar_html($p->getIdPaciente())).'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    Pagina::getInstance()->processar_excecao($ex);
}


Pagina::getInstance()->abrir_head("Listar Pacientes");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();


echo '
    <div class="conteudo_listar">'.
    
       Pagina::montar_topo_listar('LISTAR PACIENTES',null,null, 'cadastrar_paciente', 'NOVO PACIENTE').
        
        '<div class="conteudo_tabela">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">NOME</th>
                    <th scope="col">NOME DA MÃE</th>
                    <th scope="col">SEXO</th>
                    <th scope="col">CEP</th>
                    <th scope="col">ETNIA</th>
                    <th scope="col">PASSAPORTE</th>
                    <th scope="col">DATA NASCIMENTO</th>
                    <th scope="col">CPF</th>
                    <th scope="col">RG</th>
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


