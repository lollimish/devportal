<?php

function writehtml($content, $outputfile) {
    file_put_contents($outputfile, $content . "\r\n", FILE_APPEND);
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

//use for other doc but param @@ return array
function findSecByName($filename, $secName) {
    $begin_line = '\section{' . $secName . '}';
    $end_line = '\section{';
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

function getExample($filename, $type) {
    $file_handle = fopen($filename, 'r');
    $output = array();
    $start = false;
    $count = 1;
    $code = '';
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '\paragraph{', $type)) {
            $name = trim(getInbetweenStrings('(', ')', $line));
            $output[$count]['name'] = $name;
            $output[$count]['id'] = id($name);
            $start = true;
        }
        if ($start && !startsWith($line, '\begin{lstlisting}') && !startsWith($line, '\end{lstlisting}') && !startsWith($line, '\paragraph')) {
            $code .= htmlspecialchars($line);

            $output[$count]['code'] = $code;
        }
        if (startsWith($line, '\end{lstlisting}') && $start) {
            $count++;
            $start = false;
        }
    }
    fclose($file_handle);
    return $output;
}

function id($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $string)); // Removes special chars.
}

function codeHeadTags($id) {
    $tags = "       <div id=\"$id\" class=\"code\">\n";
    $tags .= '            <div class="code">' . "\n";
    $tags .= '                <div class="code-block">' . "\n";
    $tags .= '                    <span class="copy-button">copy</span>' . "\n";
    $tags .= '                    <pre>' . "\n";
    return $tags;
}

//get all the input operation file names
function allOperationsFileNames($filename) {
    $operations = array();
    $file_handle = fopen($filename, 'r');
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '\input{Operation-')) {
            $operations[] = getInbetweenStrings('{', '}', $line);
        }
    }
    return $operations;
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
        if(StartsWith($line, '{\footnotesize{\input{InputParam')){
            $refFiles['input'] = trim(getInbetweenStrings('input{', '}', $line));;
        }
        if(StartsWith($line, '{\footnotesize{\input{OutputParam')){
            $refFiles['output'] = trim(getInbetweenStrings('input{', '}', $line));;
        }
    }
    return $refFiles;
}