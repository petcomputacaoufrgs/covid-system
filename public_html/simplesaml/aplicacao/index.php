<?php
define("UID",           'urn:oid:0.9.2342.19200300.100.1.1');
define("CN",            'urn:oid:2.5.4.3');
define("MAIL",          'urn:oid:0.9.2342.19200300.100.1.3');
define("UFRGSVINCULO",  'urn:oid:1.3.6.1.4.1.12619.200.1.1.15');

require_once('../../../simplesamlphp/lib/_autoload.php');

//define que deve ser utilizada a autenticacao shibboleth
$as = new SimpleSAML_Auth_Simple('default-sp');

if (isset($_POST[autenticar])) {
  $as->requireAuth();
}
?>

<HTML>
<HEAD>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
<TITLE>Portal Teste SimpleSAML XYZ</TITLE>
</HEAD>
<BODY>
<FONT FACE="Vedana">

<H1>Bem Vindo ao Portal Teste SimpleSAML</H1>
<EM>Atualização: 07/07/2011</EM><BR>
<HR>

<H2>Acesso Federação UFRGS-TESTE</H2>

<?php
$attributes = $as->getAttributes();
if (empty($attributes[UID][0])) {
?>
Você não está autenticado na Federação UFRGS-TESTE!<br>
Clique no botão a seguir para efetuar login<br>

<form id="form1" name="form1" method="post" action="index.php">
<input name="autenticar" type="hidden" id="autenticar">
<input type="submit" value="UFRGS-TESTE">
</form>

<?php
}
else {
print(htmlspecialchars( "Olá " . $attributes[CN][0] . "!" ) ."<br><br>" );
print(htmlspecialchars( "Tu estás logado na Federação UFRGS-TESTE.") . "<br>" );
print(htmlspecialchars( "Teus atributos são os seguintes:" ) . "<br><br>" );
print(htmlspecialchars( "uid: " . $attributes[UID][0]) . "<br>");
print(htmlspecialchars( "cn: " . $attributes[CN][0]) . "<br>");
print(htmlspecialchars( "mail: " . $attributes[MAIL][0]) . "<br>");
for ($i=0; $i<count($attributes[UFRGSVINCULO]); $i++)
  print(htmlspecialchars( "ufrgsVinculo ". $i .": " . $attributes[UFRGSVINCULO][$i]) . "<br>");
}
?>

</FONT>
</BODY>
</HTML>