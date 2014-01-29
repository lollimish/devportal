<?php

if (isset($argv)) {
    $inputfile = $argv[1];
    $outputfile = $argv[2];
} else {
    $inputfile = "file/";
    $outputfile = "test_output.txt";
}

define("UPLOAD_DIR", $inputfile);
define("HTML_FILE", $outputfile);

//override if it's there
if (file_exists(HTML_FILE)) {
    unlink(HTML_FILE);
}

function writehtml($content) {
    file_put_contents(HTML_FILE, $content . "\r\n", FILE_APPEND);
}

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function parsePara($paragraph) {
    $htmlblock = array();
    $htmlstring = '';
    for ($i = 0; $i < count($paragraph); $i++) {
        if (substr($paragraph[$i], 0, 13) === '\begin_layout' && substr($paragraph[$i], 0, 21) !== '\begin_layout Itemize') {
            $htmlblock[$i] = "<p>";
            $closetag = "</p>";
        } elseif (substr($paragraph[$i], 0, 21) === '\begin_layout Itemize') {
            $htmlblock[$i] = "<ul>\r\n<li>";
            $closetag = "</li>\r\n</ul>";
        } elseif (substr($paragraph[$i], 0, 11) === '\end_layout') {
            $htmlblock[$i] = $closetag;
            $closetag = '';
        } elseif (substr($paragraph[$i], 0, 1) === '\\') {
            $htmlblock[$i] = '';
        } else {
            $htmlblock[$i] = $paragraph[$i];
        }
    }
    for ($j = 0; $j < count($paragraph); $j++) {
        $htmlstring .= $htmlblock[$j];
    }
    return $htmlstring;
}

function echohtml($htmlblock) {
    return strtr($htmlblock, Array("<" => "&lt;", "&" => "&amp;")) . '<br>';
}

function getOperationName($filename) {
    $temp = explode(".", $filename);
    $temp = explode("-", $temp[0]);
    $opname = str_replace('_', '-', $temp[1]);
    return strtolower($opname);
}
