<?php

try{
    //die( 'Versão Atual do PHP: ' . phpversion());

session_start();

require_once __DIR__.'/../../classes/Sessao/Sessao.php';
require_once __DIR__.'/../../classes/Pagina/Pagina.php';
require_once __DIR__ . '/../../classes/Pagina/InterfacePagina.php';
require_once __DIR__.'/../../classes/Excecao/Excecao.php';
require_once __DIR__.'/../../utils/Alert.php';
require_once __DIR__.'/../../classes/Estatisticas/PDF_Estatisticas.php';

Sessao::getInstance()->validar();

if(isset($_POST['enviar'])){
    if($_POST['dtEstatistica'] != null) {
        $data = explode("-", $_POST['dtEstatistica']);
        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];

        $resultData = $dia . '/' . $mes . '/' . $ano;

        header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=mostrar_estatisticas&idDia=' . $resultData));
    }
    $alert .= Alert::alert_primary("Informe a data");

}
}catch (Throwable $e){
    die($e);
}

Pagina::abrir_head("Gerar Estatísticas");
Pagina::getInstance()->adicionar_css("precadastros");
Pagina::getInstance()->fechar_head();
Pagina::getInstance()->montar_menu_topo();
Pagina::montar_topo_listar("ESTATÍSTICAS DE CADASTRO");

echo $alert;


echo '<div class="conteudo_grande" style="margin-top: 0px;">
    <form method="POST" >
        <div class="form-row" style="width: 100%;padding: 0px;margin: 0px;">
            <div class="col-md-8" style="width: 100%;">
                <label for="label_dataEstatistica">Informe uma data:</label>
                <input type="date" class="form-control " id="idDataEstatistica" placeholder=""  
                       onblur="" name="dtEstatistica"  value="">
            </div>
             <div class="col-md-4" style="width: 100%;">
            <button class="btn btn-primary" style="margin-top:33px;margin-left: -5px;width: 100%;" type="submit" name="enviar">GERAR ESTATÍSTICAS</button>
             </div>
        </div>
    </form>
</div>';

Pagina::getInstance()->fechar_corpo();
/*
 include 'filesLogic.php';?>


    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">upload</button>
        </form>
      </div>
    </div>



<table>
<thead>
    <th>ID</th>
    <th>Filename</th>
    <th>size (in mb)</th>
    <th>Downloads</th>
    <th>Action</th>
</thead>
<tbody>
  <?php foreach ($files as $file): ?>
    <tr>
      <td><?php echo $file['id']; ?></td>
      <td><?php echo $file['name']; ?></td>
      <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $file['downloads']; ?></td>
      <td><a href="downloads.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>
*/