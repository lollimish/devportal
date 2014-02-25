<?php

include 'functions.php';
$list = '../list/list.txt';

if (isset($_POST['api'])) {
    $api = trim($_POST['api']);
    if ($api !== ' ' && $api !== "\n") {
        $apis = array();
        $file_handle = fopen($list, 'r');
        if ($file_handle) {
            while (!feof($file_handle)) {
                $line = fgets($file_handle);
                if (!startsWith($line, $api) && $line !== ' ' && $line !== "\n") {
                    $apis[] = $line;
                }
            }
        }
        unlink($list);
        file_put_contents($list, implode("", $apis));
        chmod($list, 0777, true);
    }
    header('Location: index.php');
}
