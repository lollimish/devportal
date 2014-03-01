<?php
//leftnav
function parse_leftnav($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    $api = strtolower(ApiName($inputfile));
    $head = <<<"EOD"
    <aside>
    <div class="fixed-scroll">
        <div id="toc">
            <ul class="level-1">
                <li class="highlighted" id="nav_introduction"><a href="#introduction">1. Introduction</a></li>
                <li id="nav_authorization"><a href="#authorization">2. OAuth</a></li>
                <li id="nav_resources"> <a href="#resources">3. Resources</a>
                <ul class="level-2">
EOD;
    writehtml($head, $outputfile);
    $allOperationNames = allOperationsFileNames($inputfile); 
    asort($allOperationNames);
    $subnav = '';
    foreach($allOperationNames as $op){
        $subnav .= "<li id=\"nav_resources-".substr(id($op),0,strlen(id($op))-4)."\"><a href=\"#resources-".substr(id($op),10,strlen(id($op))-14)."\">".str_replace('-',' ',ucfirst(substr(id($op),10,strlen(id($op))-14)))."</a></li>\n";
    }
    writehtml($subnav, $outputfile);                              
$tail = <<<"EOD"
                    </ul>
                </li>
                <li id="nav_quickstart"><a href="#quickstart">4. Quickstart</a></li>
                <li id="nav_sample-apps"><a href="#sample-apps">5. Sample Apps</a></li>
                <li id="sdks-plugins-link"><a href="/sdks-plugins?api={$api}" target="sdksWindow">6. SDKs & Plugins</a></li>
                <li id="nav_faqs"><a href="/support/faqs/{$api}-api-faqs" target="faqsWindow">7. FAQs</a></li>
                <li id="errors-link"><a href="/apis/errors?api={$api}" target="errorsWindow">8. Errors</a></li>
            </ul>
        </div>

    </div>
</aside>

EOD;
    writehtml($tail, $outputfile);
}

