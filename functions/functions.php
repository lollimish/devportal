<?php

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
                    } elseif(startsWith($str, '\subsection*')){
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
        } elseif(startsWith($line, '\subsection*{')){
            $output[$k] = str_replace('\subsection*{', '<h5>',$line);
            $output[$k] = str_replace('}', '</h5>',$output[$k]);
        }elseif (startsWith($line, '<li>')) {
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

function parseDesc($string){
    $row = array();
    $row = preg_split( '/(par}|mize}|erate}|end{| ,)/', $string);
    foreach($row as $k => $r){
        $row[$k] = stripslashes(trim(str_replace(array('}{\footnotesize','{\footnotesize' ), '', $r)));
        if(startsWith($row[$k], '{')){
            $row[$k] = '<p>'.substr($row[$k], 1, strlen($row[$k])-3).'</p>';
        }elseif(startsWith($row[$k], "begin{enum")){
            $row[$k] = str_replace( "begin{enum", '<ol>', $row[$k]);
        }elseif(startsWith($row[$k], "begin{ite")){
            $row[$k] = str_replace( "begin{ite", '<ul>', $row[$k]);
        }elseif(startsWith($row[$k], "item")){
            $row[$k] = str_replace( "item {", '<li>', $row[$k]).'</li>';
        }else{
            $row[$k] = str_replace( "enum", '</ol>', $row[$k]);
            $row[$k] = str_replace( "ite", '</ul>', $row[$k]);
        }
        if(strpos($row[$k], '}}textbf{')){
            $strong = getInbetweenStrings('}}textbf{', '}', $row[$k]);
            $start = strpos($row[$k], '}}textbf{');
            $len = strlen('}}textbf{')+strlen($strong)+1;
            $row[$k] = substr($row[$k], 0, $start).'<strong> '. $strong .'</strong>'.substr($row[$k], $start+ $len);
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
            if (!isset($output[$count]['name']) || strlen($output[$count]['name'])==0)
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
        if (StartsWith($line, '{\footnotesize{\input{InputParam')) {
            $refFiles['input'] = trim(getInbetweenStrings('input{', '}', $line));
        }
        if (StartsWith($line, '{\footnotesize{\input{OutputParam')) {
            $refFiles['output'] = trim(getInbetweenStrings('input{', '}', $line));
        }
        if (StartsWith($line, '\input{Object-')) {
            $refFiles['object'] = trim(getInbetweenStrings('input{', '}', $line));
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
