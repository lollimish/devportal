<?php

//php parse_error.php ../apis/iam/Errors-Create_Message_Index.tex html/error.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_error.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    parse_error($inputfile, $outputfile);
}

