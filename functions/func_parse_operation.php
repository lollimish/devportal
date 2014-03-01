<?php

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
        $code = $requestExample[$i]['code'].'</pre>';
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
        $code = $responseExample[$i]['code'].'</pre>';
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