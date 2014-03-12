<?php

//php htmlForCrafter.php locker
//php htmlForCrafter.php addressbook
//php htmlForCrafter.php lyx /var/folders/dm/lz3mh3ts7rj62mdscftpy8600000gn/T/lyx_tmpdir.L49626/lyx_tmpbuf0/ ATT-Locker-Service-Specification.tex /Users/michellepai/Sites/devcontent/apis/locker/trunk/


if ($argv[1] === 'lyx') {
    writehtml($argv[2] . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
    writehtml($argv[3] . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
    writehtml($argv[4] . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");

    $input_dir = $argv[2]; //temp path
    $tex_file_name = $argv[3];
    $output_dir = $argv[4]; //original path
    $temp = explode('-', $tex_file_name);
    $api = $temp[1];
    $dir_files = scandir($input_dir);
    foreach ($dir_files as $file) {
        if (substr($file, strlen($file) - 3) === 'tex') {
            writehtml(substr($file, strlen($file) - 3) . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
            writehtml($file. "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");

            $temp = explode('_trunk_', $file);
            $new_name = isset($temp[1]) ? $temp[1] : NULL;
            rename($input_dir . $file, $input_dir . $new_name);
        }
    }
}

if (!file_exists($input_dir . "ATT-$api-Service-Specification.tex")) {
    echo "Can't find spec file\n";
    writehtml("Can't find spec file\n" . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
} else {
//    writehtml("File found?\n" . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
    if (file_exists($output_dir . "DevDocs(html)")) {
        rrmdir($output_dir . "DevDocs(html)");
    }
    mkdir($output_dir . "DevDocs(html)/introductions", 0777, true);
    mkdir($output_dir . "DevDocs(html)/oauth", 0777, true);
    mkdir($output_dir . "DevDocs(html)/operations", 0777, true);
    mkdir($output_dir . "DevDocs(html)/errors", 0777, true);

    $inputfile = $input_dir . "ATT-$api-Service-Specification.tex";

    parse_introduction($inputfile, $output_dir . "DevDocs(html)/introductions/introduction.html");
    parse_oauth($inputfile, $output_dir . "DevDocs(html)/oauth/oauth.html");
    parse_leftnav($inputfile, $output_dir . "DevDocs(html)/leftnav.html");
    $operations = array();
    $operations = allOperationsFileNames($inputfile);


    foreach ($operations as $op) {
        if (file_exists($input_dir . $op)) {
            $op_filename = substr($op, 0, strlen($op) - 3) . 'html';
            $outputfile = $output_dir . "DevDocs(html)/operations/$op_filename";
            parse_operation($input_dir . $op, $outputfile);

            //parameter head
            $operation_name = getOperationName("../apis/$api/trunk/$op");
            $content = "<section id=\"resources-{$operation_name}-parameters\" class=\"level-3\">";
            writehtml($content, $outputfile);
            //Input param
            $file = getRefFile($input_dir . $op);

//            writehtml("$file: " . $file . "\n", "/Users/michellepai/Sites/devcontent/devportal/log.txt");
            parse_paramTable($input_dir . $file['input'], $outputfile);

            $object = getObjFile($input_dir . $file['input']);
            foreach ($object as $obj) {
                parse_paramTable($input_dir . $obj, $outputfile);
            }
            unset($object);
            //Output param
            parse_paramTable($input_dir . $file['output'], $outputfile);
            $object = getObjFile($input_dir . $file['output']);
            $object = array_filter($object);
            count($object);

            foreach ($object as $obj) {
                parse_paramTable($input_dir . $obj, $outputfile);
            }
            unset($object);
            writehtml('</section></section>', $outputfile);
            //Leftnav
        }
    }
    //errors

    $dir_files = scandir($input_dir);
    $j = 0;
    $allerrors = array();
    $errorcodes = array();
    foreach ($dir_files as $file) {
        if (startsWith($file, "Errors") && substr($file, strlen($file) - 3) === 'tex') {
            $errors = parse_error($input_dir . $file);
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
        $outputfile = $output_dir . "DevDocs(html)/errors/" . strtolower($error[0]) . '.html';
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
            writehtml("<a class=\"api icon-after\" href=\"/api/$api/docs/#$operation\">$api - $operation_name </a>", $outputfile);
//            writehtml("                        <a class=\"api icon-after\" href=\"/api/in-app-messaging/docs\">In-App Messaging - $operation_name method</a>", $outputfile);
        }
        $content = <<<"EOD"
                        
                    </div>
                </div>
            </div>

            
EOD;
        writehtml($content, $outputfile);
    }
}

function parse_introduction($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $intro = array();
    $introduction = '';
    $intro = findSec($inputfile, 'Introduction', 'section', '\subsection{Audience}');
    foreach ($intro as $line) {
        if (!startsWith($line, '\subsection{Audience}') && !startsWith($line, '\input')) {
            $introduction .= $line;
        }
    }

    $content = <<<"EOD"
        
<section id="introduction" class="level-1">
    <header>1. Introductiontest</header>
    <section id="introduction-overview" class="level-2">
    <header>Overview</header>
        
EOD;

    writehtml($content, $outputfile);
    writehtml($introduction, $outputfile);
    writehtml("</section>", $outputfile);

    //consideration
    $content = <<<"EOD"
        
    <section id="introduction-considerations" class="level-2">
    <header>Considerations</header>
        
EOD;
    writehtml($content, $outputfile);
    $rest = array();
    $restful = '';
    $rest = findSec($inputfile, 'RESTful Web Services Definition', 'section', '\subsection{REST Operation Summary}');

    $hasLevel3 = false;
    foreach ($rest as $line) {
        $restful .= $line;
        if (startsWith($line, '\subsection*')) {
            $count++;
            $hasLevel3 = true;
        }
    }

    writehtml($restful, $outputfile);
    if ($hasLevel3) {
        writehtml("</section>", $outputfile);
    }
    writehtml("</section>", $outputfile);

    //Provisioning
    $content = <<<"EOD"
        
    <section id="introduction-provisioning" class="level-2">
    <header>Provisioning</header>
        
EOD;

    writehtml($content, $outputfile);
    $prov = array();
    $provisioning = '';
    $prov = findSec($inputfile, 'Provisioning: ', 'subsection', '\subsection{');

    foreach ($prov as $line) {
        $line = '<p>' . $line . '<p>';
        $provisioning .= $line;
    }
    $provisioning = noCommet($provisioning);
    $provisioning = getItem($provisioning);
    $provisioning = str_replace(array("\n\n"), "</p>\n<p>", $provisioning);
    writehtml($provisioning, $outputfile);
    writehtml("</section>", $outputfile);
    writehtml("</section>", $outputfile);
}

//include 'functions/func_parse_oauth.php';
function parse_oauth($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }

    $allOperationNames = getAllOpsName($inputfile);
    $scope = ApiName($inputfile);
    $id = strtolower($scope);
    $oauth_overview = <<<"EOD"
    <section id="oauth-authorization-{$id}" class="level-2">
        <p>You may authorize access for this API by using the following scopes.</p>
        <ul>
            <li><p>"{$scope}" for {$allOperationNames}</p></li>
        </ul>
    </section>

EOD;
    writehtml($oauth_overview, $outputfile);
}

//include 'functions/func_parse_operation.php';


function parse_operation($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $operation_name = getOperationName($inputfile);
    $operation_title = ucfirst(str_replace('-', ' ', $operation_name));
    $funcBehav = array();
    $authTable = array();
    $funcBehav = findSubSubSecByName($inputfile, 'Functional Behavior');
    $funcBehav = findSec($inputfile, 'Functional Behavior', 'subsubsection', '\subsubsection{');
    $overview = '';
    foreach ($funcBehav as $line) {
        $overview .= $line;
    }
//auth secion
    $scope = '';
    $model = '';
    $authTbl = '';
    $authTable = findSubSubSecByName($inputfile, 'Authentication and Authorization');
    $begin_line = '\endhead';
    $end_line = '\end{longtable';
    $tbl = findSectionInArray($authTable, $begin_line, $end_line);

    foreach ($tbl as $line) {
        $authTbl .= $line;
    }
    $row = explode('\hline', $authTbl);
    for ($i = 1; $i < count($row) - 1; $i++) {
        $row[$i] = noCommet($row[$i]);

        $row[$i] = str_replace(array("\n", '\hline', '%{}', '\emph', ' ', '\end{longtable}'), '', $row[$i]);
        $cell[$i] = explode('&', $row[$i]);
        $model .= trim(getCellValue($cell[$i][0])) . ' ';
    }
    $scope = getCellValue($cell[1][2]);

    $requestExample = getExample($inputfile, 'Request', $operation_name);

    $content = <<<"EOD"
<section id="resources-{$operation_name}" class="level-2">
        <header>{$operation_title}</header>

        <section id="resources-{$operation_name}-overview" class="level-3">
            <header>Overview</header>
            <p>{$overview}</p>
        </section>

        <section id="resources-{$operation_name}-oauth" class="level-3">
            <ul class="oauth">
                <li><span>OAuth Scope</span></li>
                <li><p><span>Scope:</span> {$scope}</p></li>
                <li><p><span>Model:</span> {$model}</p></li>
            </ul>
            <ul class="oauth">
                <li><span>Resource</span></li>
                <li class="code">
                    <div class="code-block">
                        <span class="copy-button" data-clipboard-text="/speechToText">copy</span>
                        <pre>/speechToText</pre>
                    </div>
                </li>
            </ul>
        </section>
                
        <section id="resources-{$operation_name}-examples" class="level-3">
            <header>Request Examples</header>
            <div class="tabs">
            <ul class="tab_nav">
EOD;
    writehtml($content, $outputfile);
    $tablist = '';
    for ($i = 1; $i <= count($requestExample); $i++) {
        $selected = $i === 1 ? "class=\"selected\"" : "";
        $tablist .= "<li><a href=\"#" . $requestExample[$i]['id'] . "\"" . $selected . ">" . $requestExample[$i]['name'] . "</a></li>\n";
    }
    writehtml($tablist, $outputfile);

    $content = <<<"EOD"
        
            </ul>
        
EOD;
    writehtml($content, $outputfile);
    $codeendTags = <<<"EOD"
                        </div>
                    </div>
                </div>
        
EOD;
    for ($i = 1; $i <= count($requestExample); $i++) {
        $code = $requestExample[$i]['code'] . '</pre>';
        writehtml(codeHeadTags($requestExample[$i]['id'], $requestExample[$i]['intro']), $outputfile);
        writehtml($code, $outputfile);
        writehtml($codeendTags, $outputfile);
    }

    $responseExample = array();
    $responseExample = getExample($inputfile, 'Response', $operation_name);
    $content = <<<"EOD"
            </div>\n<header>Response Examples</header>
                        <div class="tabs">
                        <ul class="tab_nav">
EOD;
    writehtml($content, $outputfile);
    $tablist = '';
    for ($i = 1; $i <= count($responseExample); $i++) {
        $selected = $i === 1 ? "class=\"selected\"" : "";
        $tablist .= "<li><a href=\"#" . $responseExample[$i]['id'] . "\"" . $selected . ">" . $responseExample[$i]['name'] . "</a></li>\n";
    }
    writehtml($tablist, $outputfile);

    $content = <<<"EOD"
            </ul>
        
EOD;
    writehtml($content, $outputfile);

    for ($i = 1; $i <= count($responseExample); $i++) {
        $code = $responseExample[$i]['code'] . '</pre>';
        writehtml(codeHeadTags($responseExample[$i]['id'], $responseExample[$i]['intro']), $outputfile);
        writehtml($code, $outputfile);
        writehtml($codeendTags, $outputfile);
    }



//end of level2 section             
    $content = <<<"EOD"
        </section><!--end of example-->

EOD;
    writehtml($content, $outputfile);
}

//include 'functions/func_parse_paramTable.php';

function parse_paramtable($inputfile, $outputfile) {
    //append to outputfile

    $type = '';
    if (strpos($inputfile, 'Input') !== false) {
        $type = 'Request';
    } elseif (strpos($inputfile, 'Output') !== false) {
        $type = 'Require';
    } elseif (strpos($inputfile, 'Object') !== false) {
        $path = explode('/', $inputfile);
        $file = explode('.', $path[count($path) - 1]);
        if (startsWith($file[0], 'Object-content_')) {
            $type = ucfirst(substr($file[0], 15)) . " Object";
        } else {
            $type = $file[0];
        }
    }
    $content = <<<"EOD"
    <header>{$type} Parameters</header>
    <label>
        <span class="required form-icon"></span>
        Required Parameters
    </label>

    <div class="grid">
        <div class="grid-row">
            <div class="grid-left">
                <div class="header">Parameter</div>
            </div>
        </div>
EOD;
    writehtml($content, $outputfile);
    chmod($outputfile, 0664);

//getting the parameter table section
    $begin_line = '\endhead';
    $end_line = '\end{longtable';
    $paramTbl = findSection($inputfile, $begin_line, $end_line);
    $rowopen = false;
    $row = '';
    $count = 0;
    $parameter = '';
    $datatype = '';
    $req = '';
    $description = '';
    $loc = '';
    foreach ($paramTbl as $line) {
        if (substr($line, 0, 6) === '\hline') {
            $count++;
        }
        if ($count >= 1 && !startsWith($line, ' & ')) {
            $rowopen = true;
            $row .= $line;
            if ($rowopen && substr($line, 0, 6) === '\hline') {
                if ($count > 1) {
                    //take out comments
                    $row = noCommet($row);
                    //take out notes
                    $row = str_replace('\emph{\footnotesize{Note}}{\footnotesize{:', '<br><p><span style="font-style: italic">Note</span>: ', $row);
                    $row = str_replace(array('\hline', '%{}', '\emph', "\n"), ' ', $row);
                    $cell = explode(' & ', $row);
                    for ($c = 0; $c < 5; $c++) {
                        if (isset($cell[$c])) {
                            $cell[$c] = trim(str_replace(array('\tabularnewline'), ' ', $cell[$c]));
                            if ($c !== 3) {
                                $cell[$c] = trim(str_replace(array('{\footnotesize{', '}}'), "", $cell[$c]));
                            } else {
                                $cell[3] = parseDesc(trim($cell[3]));
                                $desc = '';
                                foreach ($cell[3] as $d) {
                                    $desc .= $d;
                                }
                            }
                        } else {
                            continue;
                        }
                    }
                    $temp = isset($cell[2]) ? trim($cell[2]) : '';
                    if (startsWith(strtolower($temp), 'y')) {
                        $req = "<span class=\"required form-icon\"></span>\r\n";
                    } else {
                        $req = '';
                    }
                    $parameter = isset($cell[0]) ? trim($cell[0]) : '';
                    $datatype = isset($cell[1]) ? trim($cell[1]) : '';
                    $loc = isset($cell[4]) ? trim($cell[4]) : '';
                    $description = isset($desc) ? $desc : '';
                    if ($parameter !== '' && strpos($parameter, 'multicolumn') === false) {
                        $content = <<<"EOD"
        <div class="grid-row">
            <div class="identifier">
                <div class="parameter">
                    <span class="label">{$parameter}</span>
                    {$req}
                    <span class="data-type">{$datatype}</span>
                    <span class="placement">{$loc}</span>
                </div>
            </div>
            <div class="grid-right">
                {$description}
            </div>
        </div>
EOD;
                        writehtml($content, $outputfile);
                        $row = '';
                    }
                }
            }
        }
//        var_dump($cell);
    }

    writehtml('</div>', $outputfile);
}

//include 'functions/func_parse_leftnav.php';
function parse_leftnav($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $api = strtolower(ApiName($inputfile));
    $head = <<<"EOD"
    <aside>
    <div class="fixed-scroll">
        <div id="toc">
            <ul class="level-1">
                <li class="highlighted" id="nav_introduction"><a href="#introduction">1. Introduction</a></li>
                <li id="nav_authorization"><a href="#authorization">2. OAuth</a></li>
                <li id="nav_resources"> <a href="#resources">3. Resources</a>
                <ul class="level-2">
EOD;
    writehtml($head, $outputfile);
    $allOperationNames = allOperationsFileNames($inputfile);
    asort($allOperationNames);
    $subnav = '';
    foreach ($allOperationNames as $op) {
        $subnav .= "<li id=\"nav_resources-" . substr(id($op), 0, strlen(id($op)) - 4) . "\"><a href=\"#resources-" . substr(id($op), 10, strlen(id($op)) - 14) . "\">" . str_replace('-', ' ', ucfirst(substr(id($op), 10, strlen(id($op)) - 14))) . "</a></li>\n";
    }
    writehtml($subnav, $outputfile);
    $tail = <<<"EOD"
                    </ul>
                </li>
                <li id="nav_quickstart"><a href="#quickstart">4. Quickstart</a></li>
                <li id="nav_sample-apps"><a href="#sample-apps">5. Sample Apps</a></li>
                <li id="sdks-plugins-link"><a href="/sdks-plugins?api={$api}" target="sdksWindow">6. SDKs & Plugins</a></li>
                <li id="nav_faqs"><a href="/support/faqs/{$api}-api-faqs" target="faqsWindow">7. FAQs</a></li>
                <li id="errors-link"><a href="/apis/errors?api={$api}" target="errorsWindow">8. Errors</a></li>
            </ul>
        </div>

    </div>
</aside>

EOD;
    writehtml($tail, $outputfile);
}

function parse_error($inputfile) {
    $operation_name = id(getInbetweenStrings('Errors-', '.tex', $inputfile));
    $errors = array();
    $count = 0;
    $errors[$count] = '';
    $file_handle = fopen($inputfile, 'r');
    $startrow = false;
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '{\footnotesize{SVC') || startsWith($line, '{\footnotesize{POL')) {
            $startrow = true;
        }
        if ($startrow) {
            $errors[$count] .= $line;
            if (substr($line, strlen($line) - 15) === "tabularnewline\n") {
                $startrow = false;
                $count++;
                $errors[$count] = '';
            }
        }
    }
    $errors = array_filter($errors);
    fclose($file_handle);
    for ($i = 0; $i < count($errors); $i++) {
        $errors[$i] = explode('&', $errors[$i]);
        for ($j = 0; $j < 4; $j++) {
            $errors[$i][$j] = str_replace("\n", ' ', getInbetweenStrings('footnotesize{', '}}', $errors[$i][$j]));
            $errors[$i][$j] = str_replace('\\', '', $errors[$i][$j]);
        }
        $errors[$i][4][] = $operation_name;
    }
    return $errors;
}

//functions
function writehtml($content, $outputfile) {
    file_put_contents($outputfile, stripslashes($content) . "\r\n", FILE_APPEND);
}

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function getOperationName($filename) {
    $temp1 = explode(".", $filename);
    $temp = explode("-", $temp1[count($temp1) - 2]);
    $opname = str_replace('_', '-', $temp[count($temp) - 1]);
    return strtolower($opname);
}

//use for other doc but param @@ return array
function findSection($filename, $begin_line, $end_line) {
    $file_handle = fopen($filename, 'r');
    $foundSection = false;
    $output = array();
    if ($file_handle) {
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            if ($foundSection) {
                $output[] = $line;
            }
            if (substr($line, 0, strlen($begin_line)) === $begin_line) {
                $foundSection = true;
            }
            if (substr($line, 0, strlen($end_line)) === $end_line) {
                $foundSection = false;
                break;
            }
        }
        fclose($file_handle);
    }
    return $output;
}

//use for other doc but param @@ return array
function findSectionInArray($array, $begin_line, $end_line) {

    $foundSection = false;
    $output = array();
    foreach ($array as $line) {
        if ($foundSection) {
            $output[] = $line;
        }
        if (substr($line, 0, strlen($begin_line)) === $begin_line) {
            $foundSection = true;
        }
        if (substr($line, 0, strlen($end_line)) === $end_line) {
            $foundSection = false;
            break;
        }
    }
    return $output;
}

//use for other doc but param @@ return array
function findSubSubSecByName($filename, $secName) {
    $begin_line = '\subsubsection{' . $secName . '}';
    $end_line = '\subsubsection{';
    $file_handle = fopen($filename, 'r');
    $foundSection = false;
    $output = array();
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, $begin_line)) {
            $foundSection = true;
        }
        if (startsWith($line, $end_line) && !startsWith($line, $begin_line)) {
            $foundSection = false;
        }
        if ($foundSection && !startsWith($line, $begin_line)) {
            $output[] = $line;
        }
    }
    fclose($file_handle);
    return $output;
}

function findSec($filename, $secName, $level, $end) {
    $begin_line = '\\' . $level . '{' . $secName . '}';
    $end_line = $end;
    $file_handle = fopen($filename, 'r');
    $foundSection = false;
    $comment = false;
    $output = array();
    $count = 0;
    $str = '';
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, $begin_line)) {
            $foundSection = true;
        }
        if (startsWith($line, $end_line) && !startsWith($line, $begin_line)) {
            $foundSection = false;
        }
        if ($foundSection && !startsWith($line, $begin_line)) {
            //$output[] = $line;
            if (startsWith($line, '\begin{comment}')) {
                $comment = true;
            }
            if (startsWith($line, '\end{comment}')) {
                $comment = false;
            }
            if (!$comment && !startsWith($line, '\end{comment}') && !startsWith($line, '\hline')) {
                //$str .= $line;
                if (startsWith($line, "\n")) {
                    $count++;
                    $str = '';
//                   $output[] = $line;
                } elseif (startsWith($line, '\item') || startsWith($line, '\begin') || startsWith($line, '\paragraph') || startsWith($line, '\begin') || startsWith($line, '\end') || startsWith($line, '{\footnotesize{')) {
                    $str = '';
                    $str .= $line;
                    $count++;
                    if (startsWith($str, '\begin{itemize}')) {
                        $str = str_replace('\begin{itemize}', '<ul>', $str);
                    } elseif (startsWith($str, '\end{itemize}')) {
                        $output[$count] = str_replace('\end{itemize}', '</ul>', $str);
                        $count++;
                        $str = '';
                    } elseif (startsWith($str, '\begin{enumerate}')) {
                        $str = str_replace('\begin{enumerate}', '<ol>', $str);
                    } elseif (startsWith($str, '\end{enumerate}')) {
                        $output[$count] = str_replace('\end{enumerate}', '</ol>', $str);
                        $count++;
                        $str = '';
                    } elseif (startsWith($str, '\item')) {
                        $str = str_replace('\item', '<li>', $str);
                    } elseif (startsWith($str, '\paragraph{')) {
                        $str = str_replace('\paragraph{', '<h5>', $str);
                        $str = str_replace('}', '', $str);
                        $str = $str . '</h5>';
                    } elseif (startsWith($str, '\begin{longtable}')) {
                        $output[$count] = '<table>';
                        $count++;
                        $str = '';
                    } elseif (startsWith($str, '\end{longtable}')) {
                        $output[$count] = '</table>';
                        $count++;
                        $str = '';
                    } elseif (startsWith($str, '\subsection*')) {
                        $output[$count] = '<h5>';
                        $count++;
                        $str = '';
                    }
                } else {
                    $str .= $line;
                }
                $output[$count] = str_replace("\n", ' ', $str);
            }
        }
    }
    $output = array_filter($output);
    $tr = '';
    foreach ($output as $k => $line) {
        if (startsWith($line, '\endfirsthead') || startsWith($line, '{\footnotesize{')) {
            $row = array();
            unset($row);
            $row = explode('&', $line);
            foreach ($row as $i => $col) {
                $row[$i] = '<td>' . getInbetweenStrings('{\footnotesize{', '}}', $col) . '</td>';
                $tr .= $row[$i];
            }
            $tr = '<tr>' . $tr . "</tr>";
            $output[$k] = $tr;
            $tr = '';
            continue;
        } elseif (startsWith($line, '\textbf{\footnotesize') || startsWith($line, '\endhead')) {
            $output[$k] = '';
            continue;
        } elseif (startsWith($line, '\subsection*{')) {
            $output[$k] = str_replace('\subsection*{', '<h5>', $line);
            $output[$k] = str_replace('}', '</h5>', $output[$k]);
        } elseif (startsWith($line, '<li>')) {
            $output[$k] = $line . '</li>';
        } elseif (!startsWith($line, '<')) {
            $output[$k] = '<p>' . str_replace("\n", ' ', $line) . "</p>\n";
        }
        if (strpos($line, '\textbf{') || startsWith($line, '\textbf{')) {
            $output[$k] = str_replace('\textbf{', '<strong> ', $output[$k]);
            $output[$k] = str_replace('}', '</strong>', $output[$k]);
        }
        if (strpos($line, '\emph{') || startsWith($line, '\emph{')) {
            $output[$k] = str_replace('\emph{', '<strong> ', $output[$k]);
            $output[$k] = str_replace('}', '</strong>', $output[$k]);
        }
    }
    fclose($file_handle);
    return $output;
}

function getInbetweenStrings($startstr, $endstr, $out) {
    if (strpos($out, $startstr) !== false && strpos($out, $endstr) !== false) {
        $startsAt = strpos($out, $startstr) + strlen($startstr);
        $endsAt = strpos($out, $endstr, $startsAt);
        return $result = substr($out, $startsAt, $endsAt - $startsAt);
    } else {
        return '';
    }
}

//ul
function getItem($string) {
    if (strpos($string, 'begin{itemize}') !== false) {
        $string = str_replace('\begin{itemize}', '<ul>', $string);
        $string = str_replace('\end{itemize}', '</li></ul>', $string);
        $string = str_replace('\item', "</li>\r\n<li>", $string);
        return $string;
    }
    return $string;
}

//take out comments
function noCommet($string) {
    $comment = getInbetweenStrings('\begin{comment}', '\end{comment}', $string);
    $originalStr = '\begin{comment}' . $comment . '\end{comment}';
    $noCommet = str_replace($originalStr, '', $string);
    return $noCommet;
}

function parseDesc($string) {
    $row = array();
    $row = preg_split('/(par}|mize}|erate}|end{| ,)/', $string);
    foreach ($row as $k => $r) {
        $row[$k] = stripslashes(trim(str_replace(array('}{\footnotesize', '{\footnotesize'), '', $r)));
        if (startsWith($row[$k], '{')) {
            $row[$k] = '<p>' . substr($row[$k], 1, strlen($row[$k]) - 3) . '</p>';
        } elseif (startsWith($row[$k], "begin{enum")) {
            $row[$k] = str_replace("begin{enum", '<ol>', $row[$k]);
        } elseif (startsWith($row[$k], "begin{ite")) {
            $row[$k] = str_replace("begin{ite", '<ul>', $row[$k]);
        } elseif (startsWith($row[$k], "item")) {
            $row[$k] = str_replace("item {", '<li>', $row[$k]) . '</li>';
        } else {
            $row[$k] = str_replace("enum", '</ol>', $row[$k]);
            $row[$k] = str_replace("ite", '</ul>', $row[$k]);
        }
        if (strpos($row[$k], '}}textbf{')) {
            $strong = getInbetweenStrings('}}textbf{', '}', $row[$k]);
            $start = strpos($row[$k], '}}textbf{');
            $len = strlen('}}textbf{') + strlen($strong) + 1;
            $row[$k] = substr($row[$k], 0, $start) . '<strong> ' . $strong . '</strong>' . substr($row[$k], $start + $len);
        }
        $row[$k] = str_replace(array('{', '}'), '', $row[$k]);
    }
    return array_filter($row);
}

//get cell value when there are more than one value and separate them with a space
function getCellValue($cell) {
    if (startsWith($cell, '{\footnotesize')) {
        preg_match_all('/footnotesize{(.*?)}}/s', $cell, $matches);
        $output = '';
        foreach ($matches[1] as $m) {
            $output .= $m . ' ';
        }
        return str_replace('\_', '_', $output);
    }
    return $cell;
}

function getExample($filename, $type, $opname) {
    $file_handle = fopen($filename, 'r');
    $output = array();
    $start = false;
    $count = 1;
    $code = '';
    $intro = false;
    $introstr = '';
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        $line = str_replace('\texttt{}', '', $line);
        if (startsWith($line, '\paragraph{' . $type)) {
            $name = trim(getInbetweenStrings('(', ')', $line));
            $output[$count]['name'] = $name;
            $output[$count]['id'] = id($name) . '-' . $type . '-' . $opname;
            $intro = true;
            $start = true;
        }
        if (startsWith($line, '\begin{lstlisting}')) {
            $intro = false;
            $introstr = '';
        }
        if ($intro && !startsWith($line, '\paragraph') && !startsWith($line, '}') && !startsWith($line, "\n")) {
            $introstr .= str_replace("\n", ' ', $line);
            $output[$count]['intro'] = $introstr;
        }
        if ($start && !$intro && !startsWith($line, '\begin{lstlisting}') && !startsWith($line, '\end{lstlisting}') && !startsWith($line, '\paragraph')) {
            $code .= htmlspecialchars($line);
            $output[$count]['code'] = $code;
        }
        if (startsWith($line, '\end{lstlisting}') && $start) {
            $count++;
            $code = '';
            $start = false;
        }
        if (isset($output[$count]['code'])) {
            if (!isset($output[$count]['name']) || strlen($output[$count]['name']) == 0)
                $output[$count]['name'] = 'Example';
            if (!isset($output[$count]['id']))
                $output[$count]['id'] = 'Example' . '-' . $type . '-' . $opname;
            if (!isset($output[$count]['intro']))
                $output[$count]['intro'] = '';
        }
    }
    fclose($file_handle);
    return $output;
}

function id($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $string)); // Removes special chars.
}

function codeHeadTags($id, $intro) {
    $tags = "       <div id=\"$id\" class=\"code\">\n";
    $tags .= "          <p>$intro</p>";
    $tags .= '            <div class="code">' . "\n";
    $tags .= '                <div class="code-block">' . "\n";
    $tags .= '                    <span class="copy-button">copy</span>' . "\n";
    $tags .= '                    <pre>';
    return $tags;
}

//get all the input operation file names
function allOperationsFileNames($filename) {
    $operations = array();
    $file_handle = fopen($filename, 'r');
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '\input{') && strpos($line, 'Operation') !== false) {
            $temp = getInbetweenStrings('{', '}', $line);
            $temparr = explode('_trunk_', $temp);
            $operations[] = isset($temparr[1]) ? $temparr[1] : null;
        }
    }
    return array_filter($operations);
}

function getAllOpsName($filename) {
    $array = allOperationsFileNames($filename);
    $string = '';
    foreach ($array as $a) {
        $a = 'the ' . ucfirst(str_replace('-', ' ', getOperationName($a))) . ' method, ';
        $string .= $a;
    }
    //make comma to period on the last one.
    $string = substr($string, 0, strlen($string) - 2) . '.';
    return $string;
}

function ApiName($filename) {
    $api = '';
    $file_handle = fopen($filename, 'r');
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '\attservice{')) {
            $api = getInbetweenStrings('{', '}', $line);
        }
    }
    return $api;
}

//recursive remove dir
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function getRefFile($opfile) {
    $refFiles = array();
    $file_handle = fopen($opfile, 'r');
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (StartsWith($line, '{\footnotesize{\input{') && strpos($line, 'InputParam') !== false) {
            $refFiles['input'] = trim(getInbetweenStrings('_trunk_', '}', $line));
        }
        if (StartsWith($line, '{\footnotesize{\input{') && strpos($line, 'OutputParam') !== false) {
            $refFiles['output'] = trim(getInbetweenStrings('_trunk_', '}', $line));
        }
        if (StartsWith($line, '\input{') && strpos($line, 'Object-') !== false) {
            $refFiles['object'] = trim(getInbetweenStrings('_trunk_s', '}', $line));
        }
    }
    return $refFiles;
}

function getObjFile($paramFile) {
    $objFiles = array();
    $file_handle = fopen($paramFile, 'r');
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (StartsWith($line, '\input{Object-')) {
            $objFiles[] = trim(getInbetweenStrings('input{', '}', $line));
        }
    }
    $objFiles = array_filter($objFiles);
    return $objFiles;
}

function switchTags($val, $oldStart, $oldEnd, $newStart, $newEnd) {
    if (startsWith($val, $oldStart)) {
        preg_match_all('/' . $oldStart . '(.*?)' . $oldEnd . '/s', $val, $matches);
        $output = '';
        foreach ($matches[1] as $m) {
            $output .= $m . ' ';
        }
        return str_replace('\_', '_', $output);
    }
    return $newStart . $val . $newEnd;
}
