<?php
////OAuth
function parse_oauth($inputfile, $outputfile) {
    if (file_exists($outputfile)) {
        unlink($outputfile);
    }
    
    $allOperationNames = getAllOpsName($inputfile);
    $scope = ApiName($inputfile);
    $id = strtolower($scope);
    $oauth_overview = <<<"EOD"
    <section id="oauth-authorization-{$id}" class="level-2">
        <p>You may authorize access for this API by using the following scopes.</p>
        <ul>
            <li><p>"{$scope}" for {$allOperationNames}</p></li>
        </ul>
    </section>

EOD;
    writehtml($oauth_overview, $outputfile);
}