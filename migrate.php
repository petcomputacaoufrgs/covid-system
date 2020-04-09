<?php

migrate('acoes');


function migrate_file($path) {
    echo $path . PHP_EOL;

    $contents = file_get_contents($path);
    /*$regex = '/<\\?php\\s*(\\/\\*(\\*(?!\\/)|[^\\*])*\\*\\/)?/';
    $without_ext = preg_replace('/\\.php$/', '', $path);
    $without_src = preg_replace('/^src\\//', '', $without_ext);
    $pieces = explode('/', $without_src);
    array_pop($pieces);
    array_unshift($pieces, 'InfUfrgs');
    $namespace = join('\\', $pieces);
    $replace = "<?php\n\n$1\n\nnamespace " . $namespace . ";";
    $contents = preg_replace($regex, $replace, $contents);*/

    $regex = '/^require_once [\'"]classes\\/([^\'"]*)\\.php[\'"];$/m';
    $contents = preg_replace_callback(
        $regex, 
        function ($matches) {
            $pieces = explode('/', $matches[1]);
            array_unshift($pieces, 'InfUfrgs');
            return 'use ' . join('\\', $pieces) . ";";
        },
        $contents
    );
    file_put_contents($path, $contents);
}

function migrate($path) {
    $dir = opendir($path);
    while (($ent = readdir($dir)) != null) {
        if ($ent == '.' || $ent == '..') continue;

        $sub_path = join('/', [$path, $ent]);
        if (is_file($sub_path)) {
            migrate_file($sub_path);
        } elseif (is_dir($sub_path)) {
            migrate($sub_path);
        }
    }
}
