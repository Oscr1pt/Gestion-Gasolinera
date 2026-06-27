<?php
$lines = file('storage/logs/laravel.log');
$error = '';
foreach(array_reverse($lines) as $line) {
    if(strpos($line, 'local.ERROR') !== false) {
        $error = $line;
        break;
    }
}
echo substr($error, 0, 1000);
