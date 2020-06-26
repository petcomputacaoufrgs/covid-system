<?php
session_start();
try {

    require_once __DIR__ .'/../../classes/Sessao/Sessao.php';
    require_once __DIR__ .'/../../classes/Pagina/Pagina.php';

    require_once __DIR__ . '/../../classes/Protocolo/Protocolo.php';
    require_once __DIR__ . '/../../classes/Protocolo/ProtocoloRN.php';

    require_once __DIR__ . '/../../classes/Placa/Placa.php';
    require_once __DIR__ . '/../../classes/Placa/PlacaRN.php';

    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlaca.php';
    require_once __DIR__ . '/../../classes/RelPocoPlaca/PocoPlacaRN.php';

    require_once __DIR__ . '/../../classes/Poco/Poco.php';
    require_once __DIR__ . '/../../classes/Poco/PocoRN.php';

    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocolo.php';
    require_once __DIR__ . '/../../classes/DivisaoProtocolo/DivisaoProtocoloRN.php';

    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlaca.php';
    require_once __DIR__ . '/../../classes/RelTuboPlaca/RelTuboPlacaRN.php';

    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR.php';
    require_once __DIR__.'/../../classes/MixRTqPCR/MixRTqPCR_RN.php';

    require_once __DIR__.'/../../classes/Tubo/Tubo.php';
    require_once __DIR__.'/../../classes/Tubo/TuboRN.php';

    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR.php';
    require_once __DIR__ . '/../../classes/RTqPCR/RTqPCR_RN.php';

    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPaciente.php';
    require_once __DIR__.'/../../classes/PerfilPaciente/PerfilPacienteRN.php';

    require_once __DIR__.'/../../classes/Equipamento/Equipamento.php';
    require_once __DIR__.'/../../classes/Equipamento/EquipamentoRN.php';

    require_once __DIR__.'/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTexto.php';
    require_once __DIR__.'/../../classes/LocalArmazenamentoTexto/LocalArmazenamentoTextoRN.php';

    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlaca.php';
    require_once __DIR__ . '/../../classes/RelPerfilPlaca/RelPerfilPlacaRN.php';


    Sessao::getInstance()->validar();

    $objMix = new MixRTqPCR();
    $objMixRN = new MixRTqPCR_RN();

    $objRelPerfilPlaca = new RelPerfilPlaca();
    $objRelPerfilPlacaRN = new RelPerfilPlacaRN();

    $objProtocolo = new Protocolo();
    $objProtocoloRN = new ProtocoloRN();

    $objPoco = new Poco();
    $objPocoRN = new PocoRN();

    $objPlaca = new Placa();
    $objPlacaRN = new PlacaRN();

    $objPocoPlaca = new PocoPlaca();
    $objPocoPlacaRN = new PocoPlacaRN();

    $objRTqPCR= new RTqPCR();
    $objRTqPCR_RN = new RTqPCR_RN();

    $quantidade = 8;
    $letras = range('A', chr(ord('A') + $quantidade));


    $objRTqPCR->setIdRTqPCR($_GET['idRTqPCR']);
    $arrRTqPCRs = $objRTqPCR_RN->paginacao($objRTqPCR);

    $objPocoPlaca->setIdPlacaFk($arrRTqPCRs[0]->getIdPlacaFk());
    $arrPocos = $objPocoPlacaRN->listar_completo($objPocoPlaca);

    $quantidade = 8;
    $letras = range('A', chr(ord('A') + $quantidade));
    $dadosXls  = "";
    $dadosXls .= "  <table border='1' >
                        <tr><td> linha 1 </td></tr>
                        <tr><td> linha 2 </td></tr>
                        <tr><td> linha 3 </td></tr>
                        <tr><td> linha 4 </td></tr>
                        <tr><td> linha 5 </td></tr>
                        <tr><td> linha 6 </td></tr>
                        <tr><td> - </td></tr>
                         <tr>
                            <td> Well </td>
                            <td> Sample Name </td>
                            <td> Task </td>
                            <td> Reporter </td>
                            <td> Quencher </td>
                            <td> Ct </td>
                         </tr>";

    for ($i = 0; $i <= 8; $i++) {
        for ($j = 0; $j <= 12; $j++) {
            foreach ($arrPocos as $poco) {
                if ($poco->getObjPoco()->getLinha() == $letras[$i - 1] && $poco->getObjPoco()->getColuna() == $j) {
                    $dadosXls .= " <tr>
                            <td> " . $letras[$i - 1] . $j . " </td>
                            <td> " . $poco->getObjPoco()->getConteudo() . " </td>
                            <td> xx </td>
                            <td> xx </td>
                            <td> xx </td>
                            <td> xx </td>
                         </tr>
                         ";
                }
            }
        }
    }

    $dadosXls .= "  </table>";

    /*
    $fp = fopen("arquivo.csv", "w"); // o "a" indica que o arquivo será sobrescrito sempre que esta função for executada.
    $escreve = fwrite($fp, $dadosXls);
    fclose($fp);

    $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('CSV');
    $objReader->setDelimiter(";"); // define que a separação dos dados é feita por ponto e vírgula
    $objReader->setInputEncoding('UTF-8'); // habilita os caracteres latinos.
    $objPHPExcel = $objReader->load('bandas.csv'); //indica qual o arquivo CSV que será convertido
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('bandas.xls'); // Resultado da conversão; um arquivo do EXCEL
    */


    // Definimos o nome do arquivo que será exportado
    $arquivo = "results.xls";
    // Configurações header para forçar o download
    //header('Content-Type: application/vnd.ms-excel');
   // header('Content-Disposition: attachment;filename="'.$arquivo.'"');
   // header('Cache-Control: max-age=0');
    // Se for o IE9, isso talvez seja necessário
    //header('Cache-Control: max-age=1');

    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ('Content-Disposition: attachment; filename="'.$arquivo.'"' );
    header ("Content-Description: PHP Generated Data" );

    // Envia o conteúdo do arquivo
    echo $dadosXls;
    //header('Location: ' . Sessao::getInstance()->assinar_link('controlador.php?action=listar_analise_RTqPCR'));
    exit;

}catch (Throwable $e){
    die($e);
}