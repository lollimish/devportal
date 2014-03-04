<?php

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
        if (substr($line, 0, 6) === '\hline' || startsWith($line, ' &')) {
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
                    $cell = explode(' & ', $row);
                    for ($c = 0; $c < 5; $c++) {
                        if (isset($cell[$c])) {
                            $cell[$c] = str_replace(array('\tabularnewline'), ' ', $cell[$c]);
                            if ($c !== 3) {
                                $cell[$c] = str_replace(array('{\footnotesize{', '}}'), "", $cell[$c]);
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

                    $parameter = isset($cell[0]) ? $cell[0] : '';
                    $datatype = isset($cell[1]) ? $cell[1] : '';
                    $loc = isset($cell[4]) ? $cell[4] : '';
                    $description = $desc;

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

    writehtml('</div>', $outputfile);
}
