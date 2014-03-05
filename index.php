<?php
$list = '../list/list.txt';
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <title>Documentation preview</title>
        <meta name="keywords" content="speech api documentation, speech to text api documentation, text to speech api documentation, speech recognition api, speech-to-text, speech recognition, voice recognition, speech transcription, speech api sample apps, speech api sample code" />
        <meta name="description" content="The RESTful Speech API from AT&T lets you add Text-to-Speech, Speech-to-Text and Custom Speech interactions to your web and mobile apps. This documentation provides sample apps, SDKs, sample code and details on how to provision your app to use Speech API. " />
        <meta name="author" content="AT&T Developer Program" />
        <meta charset="UTF-8" />
        <meta name="robots" content="INDEX, FOLLOW" />
        <meta name="title" content="Speech Documentation" />

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=1202, minimum-scale=0.70, maximum-scale=1.0">

        <!-- Fonts
        ================================================== -->

        <!-- CSS
        ================================================== -->
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/default.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/skeleton.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/api-doc-clean.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/modular.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/button.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/footer.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/font.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/header-common.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/header-title.css" />
        <link rel="stylesheet" href="https://stg-devcentral.cingular.com/static-assets/css/responsive.css">


        <!--[if lt IE 9]>
        <script src="static-assets/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <script src="static-assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="static-assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="static-assets/js/ZeroClipboard.min.js" type="text/javascript"></script>
        <!--<script src="static-assets/js/apidoc.js" type="text/javascript"></script>-->

        <script>
            function submitForm(action)
            {
                document.getElementById('list_form').action = action;
                document.getElementById('list_form').submit();
            }
        </script>
    </head>

    <body>
        <div id="content-area">  

            <div id="header-common">
                <div class="notification">
                    <div class="notification-icon form-icon">Notification icon</div>
                    <span>Notification text</span>
                    <a class="close form-icon" title="Close Message">Close</a> 
                </div>

                <div id="att-header" class="container">
                    <a class="logo" href="/">
                        <img class="att-logo" title="AT&T Developer" alt="AT&T Developer" src="https://stg-devcentral.cingular.com/static-assets/images/logo-developer.png" data-at2x="https://stg-devcentral.cingular.com/static-assets/images/hi-res/logo-developer.png" width="127" />
                    </a>


                </div>
            </div>

            <div id="att-header-responsive" class="container show-on-mobile hide">
                <nav>
                    <a id="mobile-menu" href="#">
                        <img title="Touch to see menu" alt="Mobile Menu" src="https://stg-devcentral.cingular.com/static-assets/images/responsive/dropdown-menu.png" data-at2x="/images/responsive/dropdown-menu.png">
                    </a>
                </nav>

                <a class="logo" href="/">
                    <img class="att-logo" title="AT&T Developer" alt="AT&T Developer" src="https://stg-devcentral.cingular.com/static-assets/images/responsive/logo-developer.png" data-at2x="/images/responsive/logo-developer.png" width="212">
                </a>
            </div>
            <header id="header-title">
                <!-- Removed for HTML page banner setup-->
                <!--<div class="content-error">Required object 'header-title' is missing</div>-->
            </header>

            <div id="content-sections" class="modular-page">

                <div class="api-docs">
                    <div id="content-area">   
                        <!-- Begin Doc Header -->
                        <div class="sub-header-container">
                            <div class="sub-header">
                                <div class="container" style="padding-top: 9px;"> 

                                    <form id='list_form' action=# method='post'>
                                        <label>Select API from 'API List' file</label>
                                        <select name="api">
                                            <?php
                                            $file_handle = fopen($list, 'r');
                                            if ($file_handle) {
                                                $apis = array();
                                                while (!feof($file_handle)) {
                                                    $line = fgets($file_handle);
                                                    $apis[] = $line;
                                                }
                                                foreach ($apis as $api) {
                                                    if (is_string($api)) {
                                                        echo '<option value="' . trim($api) . '">' . trim($api) . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="button" onclick="submitForm('preview.php')" value="Preview" />
                                        <input type="button" onclick="submitForm('delete.php')" value="Delete" />
                                    </form> 
                                </div>
                            </div>
                        </div>
