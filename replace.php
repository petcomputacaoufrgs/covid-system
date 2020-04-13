<?php

exec('rm src -r && cp classes src -r');
migrate('classes');


function migrate_file($path) {
    echo $path . PHP_EOL;

    $contents = file_get_contents($path);
    $regex = '/^require_once [\'"]..\\/(classes\\/[^\'"]*\\.php)[\'"];$/m';
    $contents = preg_replace_callback(
        $regex, 
        function ($matches) use ($path) {
            $common = 0;
            $last_slash = $common;
            while ($matches[1][$common] == $path[$common]) {
                $common++;
                if ($path[$common - 1] == '/') {
                    $last_slash = $common;
                }
            }
            $count = substr_count(substr($path, $last_slash), '/');
            $new_path = str_repeat('/..', $count);
            $new_path .= '/' . substr($matches[1], $last_slash);
            echo $new_path . PHP_EOL;
            return 'require_once __DIR__ . \'' . $new_path . '\';';
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
