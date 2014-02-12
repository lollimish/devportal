<?php

//php parse_introduction.php ../apis/locker/ATT-Locker-Service-Specification.tex html/intro.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_introduction.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    parse_introduction($inputfile, $outputfile);
}