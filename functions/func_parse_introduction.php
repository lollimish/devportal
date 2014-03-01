<<?php

function parse_introduction($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $intro = array();
    $introduction = '';
    $intro = findSec($inputfile, 'Introduction', 'section', '\subsection{Audience}');
    foreach ($intro as $line) {
        if (!startsWith($line, '\subsection{Audience}') && !startsWith($line, '\input')) {
            $line = '<p>' . $line . '<p>';
            $introduction .= $line;
        }
    }
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
    $rest = findSec($inputfile, 'RESTful Web Services Definition', 'section', '\subsection{REST Operation Summary}');
    $count = 0;
    $hasLevel3 = false;
    foreach ($rest as $line) {

        if (startsWith($line, '\subsection*')) {
            $count++;
            $hasLevel3 = true;

            if ($count === 1) {
                $line = str_replace("\\subsection*{", "<section class=\"level-3\">\n<header>", $line);
            }
            $line = str_replace("\\subsection*{", "</section>\n<section class=\"level-3\">\n<header>", $line);
            $line = str_replace('}', "</header>\n", $line);
        }
        if (!startsWith($line, '\subsection{REST Operation Summary}')) {
            $line = '<p>' . $line . '<p>';
            $restful .= $line;
        } else {
            break;
        }
    }
    $restful = getItem($restful);
    $restful = str_replace(array("\n\n"), "<br>", $restful);
    writehtml($restful, $outputfile);
    if ($hasLevel3) {
        writehtml("</section>", $outputfile);
    }
    writehtml("</section>", $outputfile);

    //Provisioning
    $content = <<<"EOD"
        
    <section id="introduction-provisioning" class="level-2">
    <header>Provisioning</header>
        
EOD;

    writehtml($content, $outputfile);
    $prov = array();
    $provisioning = '';
    $prov = findSec($inputfile, 'Provisioning: ', 'subsection','\subsection{');

    foreach ($prov as $line) {
        $line = '<p>' . $line . '<p>';
        $provisioning .= $line;
    }
    $provisioning = noCommet($provisioning);
    $provisioning = getItem($provisioning);
    $provisioning = str_replace(array("\n\n"), "</p>\n<p>", $provisioning);
    writehtml($provisioning, $outputfile);
    writehtml("</section>", $outputfile);
    writehtml("</section>", $outputfile);
}
