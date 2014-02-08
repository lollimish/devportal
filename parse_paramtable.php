<?php

//php parse_paramtable.php ../apis/locker/InputParam-Add_Tracks_To_Playlist.tex html/param.html

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
}

include 'functions.php';
include 'func_parse_paramtable.php';

if (!file_exists($inputfile)) {
    echo "input file is not exist\n";
} else {
    
     if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    parse_paramtable($inputfile, $outputfile);
}


?>