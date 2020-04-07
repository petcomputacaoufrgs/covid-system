<?php
/* 
 *  Author: Carine Bertagnolli Bathaglini
 */

require_once 'classes/Pagina/Pagina.php';
require_once 'classes/Excecao/Excecao.php';
require_once 'classes/Paciente/Paciente.php';
require_once 'classes/Paciente/PacienteRN.php';
require_once 'classes/PerfilPaciente/PerfilPaciente.php';
require_once 'classes/PerfilPaciente/PerfilPacienteRN.php';
require_once 'classes/Sexo/Sexo.php';
require_once 'classes/Sexo/SexoRN.php';

$objPagina = new Pagina();
$objPaciente = new Paciente();
$objPacienteRN = new PacienteRN();
$html = '';

try{
    
    $objSexo = new Sexo();
    $objSexoRN = new SexoRN();
    
    $objPerfilPaciente = new PerfilPaciente();
    $objPerfilPacienteRN = new PerfilPacienteRN();
    
    
    $arrPacientes = $objPacienteRN->listar($objPaciente);
    foreach ($arrPacientes as $p){   
       
        if($p->getIdSexo_fk() != null){
            $objSexo->setIdSexo($p->getIdSexo_fk());
            $objSexo = $objSexoRN->consultar($objSexo);
        }else{
            $objSexo->setSexo('');
        }
        
        
        $objPerfilPaciente->setIdPerfilPaciente($p->getIdPerfilPaciente_fk());
        $objPerfilPaciente = $objPerfilPacienteRN->consultar($objPerfilPaciente);
         
        $html.='<tr>
                    <th scope="row">'.$p->getIdPaciente().'</th>
                        <td>'.$objPerfilPaciente->getPerfil().'</td>
                        <td>'.$p->getNome().'</td>
                        <td>'.$p->getNomeMae().'</td>
                        <td>'. $objSexo->getSexo().'</td>        
                        <td>'.$p->getDataNascimento().'</td>        
                        <td>'.$p->getCPF().'</td>        
                        <td>'.$p->getRG().'</td>        
                        
                        <td><a href="controlador.php?action=editar_paciente&idPaciente='.$p->getIdPaciente().'">Editar</a></td>
                        <td><a href="controlador.php?action=remover_paciente&idPaciente='.$p->getIdPaciente().'">Remover</a></td>
                </tr>';
    }
    
} catch (Exception $ex) {
    $objPagina->processar_excecao($ex);
}

?>

<?php Pagina::abrir_head("Listar Pacientees"); ?>
<?php Pagina::fechar_head(); ?>
<?php $objPagina->montar_menu_topo();?>


<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#ID</th>
      <th scope="col">PERFIL</th>
      <th scope="col">NOME</th>
      <th scope="col">NOME DA MÃE</th>
      <th scope="col">SEXO</th>
      <th scope="col">DATA NASCIMENTO</th>
      <th scope="col">CPF</th>
      <th scope="col">RG</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?=$html?>    
  </tbody>
</table>


<?php 
$objPagina->mostrar_excecoes();
$objPagina->fechar_corpo(); 
?>

