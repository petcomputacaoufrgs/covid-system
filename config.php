<?php
$dbopts = parse_url(getenv('JAWSDB_MARIA_URL'));
$config = array(
    'versao' => '1.0.0',
    'producao' => false,
    'banco' => array(
        'servidor' => $dbopts["host"], 
        'porta' => $dbopts["port"],
        'nome' => ltrim($dbopts["path"],'/'),
        'usuario' => $dbopts["user"],
        'senha' => $dbopts["pass"]
    ),
);
