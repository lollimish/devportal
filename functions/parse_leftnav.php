<?php

//php parse_leftnav.php ../apis/locker/ATT-Locker-Service-Specification.tex html/leftnav.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_leftnav.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    parse_leftnav($inputfile, $outputfile);
}
