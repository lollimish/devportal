<?php

//  php parse_lyx_param.php api/Inpram-Get_Client_Properties.lyx output_html/test6.html
//  this page only parse lyx file for the param table

include 'define.php';


if(isset($_SESSION['file_name'])){
    $operation_name = getOperationName($_SESSION['file_name']);
}elseif(isset($argv[1])){
    $operation_name = getOperationName($argv[1]); 
}
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

$file_handle = fopen(UPLOAD_FILE, 'r');
$isMianRow = 0;
while (!feof($file_handle)) {
    $line = fgets($file_handle);
    if (substr($line, 0, 4) === '<row' && $isMianRow < 2) {
        $isMianRow++;
    }
    //starts
    if ($isMianRow >= 2) {
        $var[] = $line;
        //exit when the branch example hits
        if(substr($line, 0, 27) === '\begin_inset Branch Example'){
            break;
        }
        //save fields to variable on each row
        if (substr($line, 0, 4) === '</ro') {
            $cellcount = 0;
            $cellopen[] = 0;
            $cellclose[] = 0;
            $parameter = '';
            $datatype = '';
            $reqraw = '';
            $req = '';
            $desc = array();
            $loc = '';
            //cells
            for ($i = 0; $i < count($var); $i++) {
                if (substr($var[$i], 0, 5) === '<cell') {
                    $cellcount++;
                    $cellopen[$cellcount] = $i;
                }
                if (substr($var[$i], 0, 5) === '</cel') {
                    $cellclose[$cellcount] = $i;
                }
            }
            //save cell value to varaible
            for ($j = 1; $j <= $cellcount; $j++) {
                for ($k = ($cellopen[$j] + 1); $k < $cellclose[$j]; $k++) {
                    if ($j === 1 && $var[$k] !== ' ' && substr($var[$k], 0, 1) !== '\\' && $var[$k] !== "\r\n") {
                        $parameter .= $var[$k];
                    } elseif ($j === 2 && $var[$k] !== ' ' && substr($var[$k], 0, 1) !== '\\' && $var[$k] !== "\r\n") {
                        $datatype .= $var[$k];
                    } elseif ($j === 3 && $var[$k] !== ' ' && substr($var[$k], 0, 1) !== '\\' && $var[$k] !== "\r\n") {
                        $reqraw .= $var[$k];
                    } elseif ($j === 4 && $var[$k] !== "\r\n") {
                        $desc[] = $var[$k];
                    } elseif ($j === 5 && $var[$k] !== ' ' && substr($var[$k], 0, 1) !== '\\' && $var[$k] !== "\r\n") {
                        $loc .= $var[$k];
                    }
                }
            }
            //require?
            if(startsWith(strtolower($reqraw), 'y')){
                $req = "<span class=\"required form-icon\"></span>\r\n";
            }else{
                $req = '';
            }
            foreach($desc as $d){
                echo $d .'<br>';
            }
            //var_dump($desc);
            //parse description to html block
            $description = parsePara($desc);
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
            //unset the variable for next row
            unset($var);
        }
    }
}
            $content = <<<'EOD'
    </div>
</section>

EOD;
writehtml($content);
fclose($file_handle);
?>