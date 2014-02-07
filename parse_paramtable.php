<?php
//php parse_paramtable.php ../apis/locker/InputParam-Add_Tracks_To_Playlist.tex html/param.html

include 'functions.php';

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
} else {
    $inputfile = "file/" . $_SESSION['file_name'];
    $outputfile = "test9.html";
}

$file = explode('.', $inputfile);

//$outputfile = 'output_html/'.$file[0].'.tex';

define("UPLOAD_DIR", 'file/');
define("TEX_FILE", $inputfile);
define("HTML_FILE", $outputfile);

//override if it's there
if (file_exists(HTML_FILE)) {
    unlink(HTML_FILE);
}

$operation_name = getOperationName(TEX_FILE);
$content = <<<"EOD"
 <section id="resources-{$operation_name}-parameters" class="level-3">
    <header>Request Parameters</header>
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
writehtml($content);
chmod(HTML_FILE, 0664);

//getting the parameter table section
$begin_line = '\endhead';
$end_line = '\end{longtable';
$paramTbl = findSection(TEX_FILE, $begin_line, $end_line);
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
    if ($count >= 1) {
        $rowopen = true;
        $row .= $line;
        if ($rowopen && substr($line, 0, 6) === '\hline') {
            if ($count > 1) {
                //take out comments
                $row = noCommet($row);
                //take out notes
                $row = str_replace('\emph{\footnotesize{Note}}{\footnotesize{:', '<br><p><span style="font-style: italic">Note</span>: ', $row);
                
                $row = str_replace(array("\n", '\hline', '%{}', '\emph'), ' ', $row);
                
                
                $cell = explode('&', $row);

                for ($c = 0; $c < 5; $c++) {
                    $cell[$c] = str_replace(array('\tabularnewline'), '', $cell[$c]);
                    if ($c !== 3) {
                        $cell[$c] = str_replace(array('{\footnotesize{', '}}'), "", $cell[$c]);
                    } else {
                        $cell[$c] = str_replace('{\footnotesize{', "<p>", $cell[$c]);
                        $cell[$c] = str_replace(array('}}{\footnotesize \par}', '}}'), "</p>\n", $cell[$c]);
                    }
                }
                $temp = trim($cell[2]);
                if (startsWith(strtolower($temp), 'y')) {
                    $req = "<span class=\"required form-icon\"></span>\r\n";
                } else {
                    $req = '';
                }
                $parameter = $cell[0];
                $datatype = $cell[1];
                $loc = $cell[4];
                $description = parseParagraph($cell[3]);
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
                writehtml($content);
                $row = '';
            }
        }
    }
}



//writehtml($test);

$content = <<<'EOD'
    </div>
</section>

EOD;
writehtml($content);
?>