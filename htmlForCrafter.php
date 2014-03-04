<?php
//TODO: param tables..!
//php htmlForCrafter.php locker
//php htmlForCrafter.php addressbook
include 'functions/functions.php';
include 'functions/func_parse_introduction.php';
include 'functions/func_parse_oauth.php';
include 'functions/func_parse_operation.php';
include 'functions/func_parse_paramTable.php';
include 'functions/func_parse_leftnav.php';

$api = $argv[1];
if (!file_exists("../apis/$api/ATT-$api-Service-Specification.tex")) {
    echo "Can't find spec file\n";
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
    parse_leftnav($inputfile, "html/$api/leftnav.html");

    $operations[] = allOperationsFileNames($inputfile);
    foreach ($operations[0] as $op) {
        if (file_exists("../apis/$api/$op")) {
            $op_filename = substr($op, 0, strlen($op) - 3) . 'html';
            $outputfile = "html/$api/operations/$op_filename";
            parse_operation("../apis/$api/$op", $outputfile);

            //parameter head
            $operation_name = getOperationName("../apis/$api/$op");
            $content = "<section id=\"resources-{$operation_name}-parameters\" class=\"level-3\">";
            writehtml($content, $outputfile);
            //Input param
            $file = getRefFile("../apis/$api/$op");
            parse_paramTable("../apis/$api/" . $file['input'], $outputfile);
            $object = getObjFile("../apis/$api/" . $file['input']);
            foreach ($object as $obj) {
                parse_paramTable("../apis/$api/" . $obj, $outputfile);
            }
            unset($object);
            //Output param
            parse_paramTable("../apis/$api/" . $file['output'], $outputfile);
            $object = getObjFile("../apis/$api/" . $file['output']);
            $object = array_filter($object);
            count($object);

            foreach ($object as $obj) {
                parse_paramTable("../apis/$api/" . $obj, $outputfile);
            }
            unset($object);
            writehtml('</section></section>', $outputfile);
            //Leftnav
        }
    }
}

