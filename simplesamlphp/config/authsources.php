<?php
$config = array (

	'admin' => array(
		'core:AdminPassword',
	),

	'default-sp' => array(
		'saml:SP',
		'privatekey' 	=> 'simplesaml.key',
		'certificate' 	=> 'simplesaml.crt',
		'entityID' 	=> 'https://www.inf.ufrgs.br/covid19-teste/simplesaml/',
		'idp' 		=> 'https://login.teste.ufrgs.br/idp/shibboleth',
	),
);