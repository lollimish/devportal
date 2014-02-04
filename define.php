<?php

session_start();

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
define("UPLOAD_FILE", $inputfile);
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
    $ulopen = false;
    $end_layout = false;
    for ($i = 0; $i < count($paragraph); $i++) {
        if (substr($paragraph[$i], 0, 13) === '\begin_layout' && substr($paragraph[$i], 0, 21) !== '\begin_layout Itemize') {
            $htmlblock[$i] = "<p>";
            $closetag = "</p>";
        } elseif (substr($paragraph[$i], 0, 21) === '\begin_layout Itemize') {
            $htmlblock[$i] = "<ul>\r\n<li>";
            $closetag = "</li>\r\n</ul>";


//            if (!$ulopen) {
//                $htmlblock[$i] = "<ul><li>";
//                $ulopen = true;
//            } else {
//                $htmlblock[$i] = "<li>";
//                if ($end_layout) {
//                    $closetag = "</li>";
//                }else{
//                    $closetag = "</li></ul>";
//                }
//            }
            $end_layout = false;
        } elseif (substr($paragraph[$i], 0, 11) === '\end_layout') {
            $htmlblock[$i] = $closetag;
            $closetag = '';
            $end_layout = true;
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

//use for other doc but param @@ return array
function findSection($filename, $begin_line, $end_line) {
    $file_handle = fopen($filename, 'r');
    $foundSection = false;
    $output = array();
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
function findSubSecByName($filename, $secName) {
    $begin_line = '\subsubsection{' . $secName . '}';
    $end_line = '\subsubsection{';
    $file_handle = fopen($filename, 'r');
    $foundSection = false;
    $output = array();
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if ($foundSection) {
            $output[] = $line;
        }
        if (startsWith($line, $begin_line)) {
            $foundSection = true;
        }
        if (startsWith($line, $end_line) && !startsWith($line, $begin_line)) {
            $foundSection = false;
        }
    }
    fclose($file_handle);
    return $output;
}

function getInbetweenStrings($startstr, $endstr, $out) {
    $startsAt = strpos($out, $startstr) + strlen($startstr);
    $endsAt = strpos($out, $endstr, $startsAt);
    return $result = substr($out, $startsAt, $endsAt - $startsAt);
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

//ol
function getEnumerate($string) {
    if (strpos($string, 'begin{enumerate}') !== false) {
        $item = getInbetweenStrings('\begin{enumerate}', '\end{enumerate}', $string);
        $originalStr = '\begin{enumerate}' . $item . '\end{enumerate}';
        $item = str_replace("\item ", "<li>", $item);
        $item = str_replace("\n", "</li>\n", $item);
        $item = '<ol>' . $item . '</ol>';
        $ol = str_replace($originalStr, $item, $string);
        return $ol;
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

//parse paragraph in tex
function parseParagraph($string) {

    $string = getItem($string);

    return $string;
}

//get cell value when there are more than one value and separate them with a space
function getCellValue($cell) {
    preg_match_all('/footnotesize{(.*?)}}/s', $cell, $matches);
    $output = '';
    foreach ($matches[1] as $m) {
        $output .= $m . ' ';
    }
    return str_replace('\_', '_', $output);
}
