<?php

//php errorsForCrafter.php iam

include 'functions/functions.php';
include 'functions/func_parse_error.php';

$api = $argv[1];

if (file_exists("html/$api/errors")) {
    rrmdir("html/$api/errors");
}
mkdir("html/$api/errors", 0777, true);
$dir_files = scandir("../apis/$api/");
$j = 0;
$allerrors = array();
$errorcodes = array();
foreach ($dir_files as $file) {
    if (startsWith($file, "Errors") && substr($file, strlen($file) - 3) === 'tex') {
        $errors = parse_error("../apis/$api/$file");
        for ($i = 0; $i < count($errors); $i++) {
            if (!in_array($errors[$i][0], $errorcodes)) {
                $errorcodes[$j] = $errors[$i][0];
                $allerrors[$j] = $errors[$i];
                $j++;
            } else {
                $key = array_search($errors[$i][0], $errorcodes);
                if (!in_array($errors[$i][4][0], $allerrors[$key][4])) {
                    $allerrors[$key][4][] = $errors[$i][4][0];
                }
            }
        }
    }
}
asort($errorcodes);

foreach ($allerrors as $error) {
    $outputfile = "html/$api/errors/" . strtolower($error[0]) . '.html';
    $error_code = $error[0];
    $error_msg = htmlspecialchars($error[1]);
    $error_var = htmlspecialchars($error[2]);
    $http_code = $error[3];
    $ops = $error[4];
    $content = <<<"EOD"
      <div class="container short">
            <header class="error-detail">Error {$error_code}</header>
            <div class="errors-grid">
                <div class="grid-row">
                    <div class="item">Error Code</div>
                    <div class="links error-code">{$error_code}</div>
                </div>
                <div class="grid-row">
                    <div class="item">Error Message</div>
                    <div class="links">{$error_msg}</div>
                </div>
                <div class="grid-row">
                    <div class="item">Error Description</div>
                    <div class="links">{$error_var}</div>
                </div>
                <div class="grid-row">
                    <div class="item">Status Code</div>
                    <div class="links status-code">{$http_code}</div>
                </div>
                <div class="grid-row">
                    <div class="item">Possibles Causes</div>
                    <div class="links"></div>
                </div>
                <div class="grid-row">
                    <div class="item">Possible Solutions</div>
                    <div class="links"></div>
                </div>
                <div class="grid-row" style="display: table-row;">
                    <div class="item">Affected APIs</div>
                    <div class="links">
EOD;
    writehtml($content, $outputfile);
    foreach ($ops as $operation) {
        $operation_name = str_replace('-', ' ', ucwords($operation));
//        writehtml("<a class=\"api icon-after\" href=\"/api/$api/docs/#$operation\">$api - $operation_name </a>", $outputfile);
        writehtml("                        <a class=\"api icon-after\" href=\"/api/in-app-messaging/docs\">In-App Messaging - $operation_name method</a>", $outputfile);
    }
    $content = <<<"EOD"
                        
                    </div>
                </div>
            </div>

            
EOD;
    writehtml($content, $outputfile);
}





