<?php

include 'define.php';


if (isset($_SESSION['file_name'])) {
    $filename = $_SESSION['file_name'];
} elseif (isset($argv[1])) {
    $filename = $argv[1];
}

$operation_name = getOperationName($filename);
$operation_title = str_replace('-', ' ',$operation_name);
echo $operation_title;
//$content = <<<"EOD"
//<section id="resources-{$operation_name}" class="level-2">
//        <header>{$operation_title}</header>
//
//        <section id="resources-speech-to-text-overview" class="level-3">
//            <header>Overview</header>
//            <p>
//                The Speech To Text method transcribes audio data files into text-based output. The Speech API applies an API-specific lexicon and transcribes the original text into an enhanced text output. The original and the enhanced text outputs are both returned as separate parameter values in the response. The supported audio formats are: </p><ul><li>16-bit PCM WAV, linear coding, single channel, 8 kHz sampling</li>
//                <li>16-bit PCM WAV, ulaw coding, single channel, 8 kHz sampling</li>
//                <li>16-bit PCM WAV, linear coding, single channel, 16 kHz sampling</li>
//
//        </section>
//
//        <section id="resources-speech-to-text-oauth" class="level-3">
//            <ul class="oauth">
//                <li><span>OAuth Scope</span></li>
//                <li><p><span>Scope:</span> SPEECH</p></li>
//                <li><p><span>Model:</span> client_credentials</p></li>
//            </ul>
//            <ul class="oauth">
//                <li><span>Resource</span></li>
//                <li class="code">
//                    <div class="code-block">
//                        <span class="copy-button" data-clipboard-text="/speechToText">copy</span>
//                        <pre>/speechToText</pre>
//                    </div>
//                </li>
//            </ul>
//        </section>
//
//
//EOD;
//writehtml($content);
//chmod(HTML_FILE, 0664);
