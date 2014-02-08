<?php

//php htmlForCrafter.php locker
include 'functions.php';
include 'func_parse_introduction.php';
include 'func_parse_oauth.php';
include 'func_parse_operation.php';
include 'func_parse_paramTable.php';


$api = $argv[1];

echo $api;

if (!file_exists("../apis/$api/ATT-$api-Service-Specification.tex")) {
    echo '@@';
} else {
    if (file_exists("html/$api")) {
        rrmdir("html/$api");
    }
    mkdir("html/$api/introductions", 0777, true);
    mkdir("html/$api/oauth", 0777, true);
    mkdir("html/$api/operations", 0777, true);
    $inputfile = "../apis/$api/ATT-$api-Service-Specification.tex";

    parse_introduction($inputfile, "html/$api/introductions/introduction.html");
    parse_oauth($inputfile, "html/$api/oauth/oauth.html");

    $operations[] = allOperationsFileNames($inputfile);
    //var_dump($operations);
    foreach ($operations[0] as $op) {
        //parse_operation($inputfile, $outputfile);         
        if (file_exists("../apis/$api/$op")) {
            $op_filename = substr($op, 0, strlen($op) - 3) . 'html';
            $outputfile = "html/$api/operations/$op_filename";
            parse_operation("../apis/$api/$op", $outputfile);
            //TODO: input param
            $file = getRefFile("../apis/$api/$op");
            parse_paramTable("../apis/$api/".$file['input'], $outputfile);

            //TODO: output param
            parse_paramTable("../apis/$api/".$file['output'], $outputfile);
        }
    }
}

