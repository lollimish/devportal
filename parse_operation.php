<?php

//php parse_operation.php ../apis/webrtc/Operation-AcceptRejectJoinchatGroup.tex html/op.html
//php parse_operation.php ../apis/locker/Operation-Create_Upload_Token.tex html/op.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_operation.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    parse_operation($inputfile, $outputfile);
}

