<?php

//php parse_oauth.php ../apis/locker/ATT-Locker-Service-Specification.tex html/oauth.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_oauth.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    parse_oauth($inputfile, $outputfile);
}


