<<?php

function parse_introduction($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $intro = array();
    $introduction = '';
    $intro = findSecByName($inputfile, 'Introduction', '\subsection{Audience}');
//    var_dump($intro);
    foreach ($intro as $line) {
        if (!startsWith($line, '\subsection{Audience}') && !startsWith($line, '\input')) {
            $line = '<p>'.$line.'<p>';
            $introduction .= $line;
        }
    }
    //echo $introduction;
    $introduction = getItem($introduction);
    $introduction = str_replace('\&', "&", $introduction);
    $content = <<<"EOD"
        
<section id="introduction" class="level-1">
    <header>1. Introduction</header>
    <section id="introduction-overview" class="level-2">
    <header>Overview</header>
        
EOD;

    writehtml($content, $outputfile);
    writehtml($introduction, $outputfile);
    writehtml("</section>", $outputfile);
    //consideration
    $content = <<<"EOD"
        
    <section id="introduction-considerations" class="level-2">
    <header>Considerations</header>
        
EOD;
    writehtml($content, $outputfile);
    $rest = array();
    $restful = '';
    $rest = findSecByName($inputfile, 'RESTful Web Services Definition', '\subsection{REST Operation Summary}');
    //var_dump($rest);
    $count = 0;
    foreach ($rest as $line) {
        
        if (startsWith($line, '\subsection*')) {
            $count++;
            if($count === 1){
                $line = str_replace("\\subsection*{", "<section class=\"level-3\">\n<header>", $line);
            }
            $line = str_replace("\\subsection*{", "</section>\n<section class=\"level-3\">\n<header>", $line);
            $line = str_replace('}', "</header>\n", $line);
            
            //echo $line;
        }
        if (!startsWith($line, '\subsection{REST Operation Summary}')) {
            $line = '<p>'.$line.'<p>';
            $restful .= $line;
        } else {
            break;
        }
    }
    //echo $restful;
    $restful = getItem($restful);

    $restful = str_replace(array("\n\n"), "<br>", $restful);
    //$restful = str_replace(array('<p></p>',"<p>\t", "<p>\n\n"), "", $restful);
    writehtml($restful, $outputfile);
    writehtml("</section></section>", $outputfile);

    //Provisioning
    $content = <<<"EOD"
        
    <section id="introduction-provisioning" class="level-2">
    <header>Provisioning</header>
        
EOD;

    writehtml($content, $outputfile);
    $prov = array();
    $provisioning = '';
    $prov = findSubSecByName($inputfile, 'Provisioning: ');
    //var_dump($prov);
    
    foreach ($prov as $line) {
        $line = '<p>'.$line.'<p>';
        $provisioning .= $line;
    }
    $provisioning = noCommet($provisioning);
    $provisioning = getItem($provisioning);
    $provisioning = str_replace(array("\n\n"), "</p>\n<p>", $provisioning);
    writehtml($provisioning, $outputfile);
    writehtml("</section>", $outputfile);
    writehtml("</section>", $outputfile);
}
