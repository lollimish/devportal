<?php

function parse_error($inputfile) {
    $operation_name = id(getInbetweenStrings('Errors-', '.tex', $inputfile));
    $errors = array();
    $count = 0;
    $errors[$count]='';
    $file_handle = fopen($inputfile, 'r');
    $startrow = false;
    while (!\feof($file_handle)) {
        $line = fgets($file_handle);
        if (startsWith($line, '{\footnotesize{SVC') || startsWith($line, '{\footnotesize{POL')) {
            $startrow = true;
        }
        if($startrow){
            $errors[$count] .= $line;
            if(substr($line, strlen($line)-15)==="tabularnewline\n"){
                $startrow = false;
                $count++;
                $errors[$count] = '';
            }
        }
    }
    $errors = array_filter($errors);
    fclose($file_handle);
    for($i=0; $i<count($errors);$i++){
        $errors[$i]  = explode('&', $errors[$i]);
        for($j=0; $j<4;$j++){
            $errors[$i][$j] = str_replace("\n", ' ',getInbetweenStrings('footnotesize{', '}}', $errors[$i][$j]));
            $errors[$i][$j] = str_replace('\\','', $errors[$i][$j]);
        }
        $errors[$i][4][] = $operation_name;
    }
    return $errors;
}

