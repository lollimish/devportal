<?php
function parse_introduction($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $intro = array();
    $introduction = '';
    $intro = findSecByName($inputfile, 'Introduction');
    
    foreach ($intro as $line) {
        $introduction .= $line;
    }
    $introduction = noCommet($introduction);
    $introduction = getItem($introduction);
    $introduction = str_replace(array("\n\n"), "</p>\n<p>", $introduction);
    
    $content = <<<"EOD"
        
<section id="introduction" class="level-1">
    <header>1. Introduction</header>
    <section id="introduction-overview" class="level-2">
        
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
    $rest = findSecByName($inputfile, 'RESTful Web Services Definition');
    foreach ($rest as $line) {
        if (!startsWith($line, '\subsection{REST Operation Summary}')) {
            $restful .= $line;
        } else {
            break;
        }
    }
    $restful = noCommet($restful);
    $restful = getItem($restful);
    $restful = str_replace(array("\n\n"), "</p>\n<p>", $restful);
    writehtml($restful, $outputfile);
    writehtml("</section>", $outputfile);

    //Provisioning
    $content = <<<"EOD"
        
    <section id="introduction-provisioning" class="level-2">
    <header>Provisioning</header>
        
EOD;

    writehtml($content, $outputfile);
    $prov = array();
    $provisioning = '';
    $prov = findSubSecByName($inputfile, 'Oauth Scope');
    foreach ($prov as $line) {
        $provisioning .= $line;
    }
    $provisioning = noCommet($provisioning);
    $provisioning = getItem($provisioning);
    $provisioning = str_replace(array("\n\n"), "</p>\n<p>", $provisioning);
    writehtml($provisioning, $outputfile);
    writehtml("</section>", $outputfile);
    writehtml("</section>", $outputfile);
}