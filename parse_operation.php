<?php
//php parse_operation.php api/Operation-Add_Files_To_Folder.tex output_html/2.html
include 'define.php';


if (isset($_SESSION['file_name'])) {
    $filename = $_SESSION['file_name'];
} elseif (isset($argv[1])) {
    $filename = $argv[1];
}

$operation_name = getOperationName($filename);
$operation_title = ucfirst(str_replace('-', ' ',$operation_name));
//echo $operation_title;
$funcBehav = array();
$authTable = array();
//find function behavior
//$begin_line = '\subsubsection{Functional Behavior}';
//$end_line = '\subsubsection{Call flow}';
//$funcBehav = findSection($filename, $begin_line, $end_line);

$funcBehav = findSubSecByName($filename, 'Functional Behavior');
$overview= '';
foreach($funcBehav as $line){
    $overview .= $line;
    
}
$overview = noCommet($overview);
$overview = getItem($overview);

$overview = str_replace(array("\n\n"), '</p><p>', $overview);
$overview = str_replace(array("\n",'\subsubsection{Call flow}'), '', $overview);

//auth secion
$authTable = findSubSecByName($filename, 'Authentication and Authorization');
$begin_line = '\endhead';
$end_line = '\end{longtable';
$tbl = findSectionInArray($authTable, $begin_line, $end_line);
$scope = '';
$model = '';
$authTbl = '';
foreach($tbl as $line){
    $authTbl .= $line;
}
$authTbl = noCommet($authTbl);
$authTbl = str_replace(array("\n", '\hline', '%{}', '\emph', ' '), '', $authTbl);
$cell = explode('&', $authTbl);
//get model
//preg_match_all('/footnotesize{(.*?)}}/s', $cell[0], $matches);
//foreach($matches[1] as $m){
//    $model .= $m . ' ';
//}
//$model = str_replace('\_','_', $model);
$model =  getCellValue($cell[0]);
$scope =  $cell[2];
echo var_dump($cell[0]);
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


EOD;
writehtml($content);
chmod(HTML_FILE, 0664);


