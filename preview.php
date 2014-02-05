<?php
//include 'parse_lyx_param.php';
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
        <link rel="stylesheet" href="static-assets/css/default.css" />
        <link rel="stylesheet" href="static-assets/css/skeleton.css" />
        <link rel="stylesheet" href="static-assets/css/api-doc-clean.css" />
        <link rel="stylesheet" href="static-assets/css/modular.css" />
        <link rel="stylesheet" href="static-assets/css/button.css" />
        <link rel="stylesheet" href="static-assets/css/footer.css" />
        <link rel="stylesheet" href="static-assets/css/font.css" />
        <link rel="stylesheet" href="static-assets/css/header-common.css" />
        <link rel="stylesheet" href="static-assets/css/header-title.css" />
        <link rel="stylesheet" href="static-assets/css/responsive.css">


        <!--[if lt IE 9]>
        <script src="static-assets/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <script src="static-assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="static-assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="static-assets/js/ZeroClipboard.min.js" type="text/javascript"></script>
        <script src="static-assets/js/apidoc.js" type="text/javascript"></script>
        <script src="static-assets/js/crafterGATracker.js" type="text/javascript" ></script> 

        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="static-assets/images/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="static-assets/icons/apple-touch-icon-iphone.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="static-assets/icons/apple-touch-icon-ipad.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="static-assets/icons/apple-touch-icon-iphone4.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="static-assets/icons/touch-icon-ipad-retina.png" />
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
                        <img class="att-logo" title="AT&T Developer" alt="AT&T Developer" src="static-assets/images/logo-developer.png" data-at2x="static-assets/images/hi-res/logo-developer.png" width="127" />
                    </a>

                    <form id="quick-search" class="hide-border" action="/search-results">

                        <button class="magnifying-glass form-icon search-btn off-text" type="submit" 
                                value="Search" title="Click here to see search results" 
                                onclick="document.location = ('/search?q=' + document.getElementById('search').value);
                                        return false;" >
                        </button>
                        <input id='search' type="text" placeholder="Type here to search" autocomplete="off" data-provide="typeahead" data-source="[ ]" />
                        <div id="suggested-result">
                            <ul>
                                <li>
                                    <a href="/apis/speech">Speech API</a>
                                </li>
                            </ul>
                        </div>
                    </form>  

                    <nav>
                        <div class="dropdown">
                            <a href="/apis" class="expands">
                                <abbr>APIs</abbr>
                            </a>
                        </div>
                        <a href="/success-stories">
                            Stories
                        </a>

                        <a href="/pricing">
                            Pricing
                        </a>

                        <img src="/developer/images/global/keep-alive.gif"/>

                        <div class="dropdown">
                            <a href="/developer/mvc/auth/login" class="login">Sign In</a>
                        </div>

                        <a class="button" href="/developer/flow/apiPlaygroundFlow.do?assetId=12600093&destPage=https://matrix.bf.sl.attcompute.com/apps">Get Started Free</a>

                    </nav>
                </div>
            </div>

            <div id="att-header-responsive" class="container show-on-mobile hide">
                <nav>
                    <a id="mobile-menu" href="#">
                        <img title="Touch to see menu" alt="Mobile Menu" src="static-assets/images/responsive/dropdown-menu.png" data-at2x="/images/responsive/dropdown-menu.png">
                    </a>
                </nav>

                <a class="logo" href="/">
                    <img class="att-logo" title="AT&T Developer" alt="AT&T Developer" src="static-assets/images/responsive/logo-developer.png" data-at2x="/images/responsive/logo-developer.png" width="212">
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
                                <div class="container"> 
                                    <h1>Preview "<?= $operation_name ?>"</h1>

                                    <nav>
                                        <ul>
                                            <li class="tour"> <a href=# title="Take a tour of the Speech API">API
                                                    Tour</a> </li>
                                            <li class="docs active"> <a href="#" title="Read the Speech API Documentation">API
                                                    Documentation</a> </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- End Doc Header -->
                        <!-- Begin Console Banner -->
                        <header id="api-docs-header">
                            <div class="inner">
                                <aside>
                                    <span>API Version</span>
                                    <select id="version" onchange="window.location = this.value">
                                        <option value="/apis/speech/docs/v3">Version 3</option>
                                    </select>
                                    <a href="https://apigee.com/att/embed/console/ATT?v=2" target="_blank" class="button blue hide" title="Get started!">API Console</a>
                                </aside>
                                <div class="main">
                                    <div class="status">
                                        <div class="status-icon form-icon" title="alert"></div>
                                        <div class="status-status">
                                            <span>Active:</span>
                                            <span>AT&amp;T version 2 was released Dec 17th, 2013.</span> <span>More information in the <a href="/apis/release-notes" title="AT&amp;T Developer Program API Platform Release Notes" alt="AT&amp;T Developer Program API Platform Release Notes" target="releaseNotesWindow">Release Notes</a>.</span>
                                        </div>
                                        <span><a href="https://apigee.com/att/embed/console/ATT?v=2" target="_blank" class="button blue" title="Get started!" style="
                                                 ">API Console</a></span>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div id="document-area">  
                            <section id="api-docs-content">
                                <div class="inner">
                                    <!-- Begin Content: Left Nav -->
                                    <aside>
                                        <div class="fixed-scroll">
                                            <div id="toc">
                                                <ul class="level-1">
                                                    <li class="highlighted" id="nav_introduction"><a href="#">1.Introduction</a></li>
                                                    <li id="nav_authorization"><a href="#">2. OAuth</a></li>
                                                    <li id="nav_resources"> <a href="#">3. Resources</a>
                                                    </li>
                                                    <li id="nav_quickstart"><a href="#">4. Quickstart</a></li>
                                                    <li id="nav_sample-apps"><a href="#">5. Sample Apps</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </aside>
                                    <!-- End Content: Left Nav -->
                                    <div class="main">
                                        <!-- Back to top icon -->
                                        <div class="back-to-top">
                                            <a href="#" class="retina-icon" title="Click here to go back the top of the document"></a>
                                        </div>
                                        <!-- Begin Status message -->

                                        <!-- End Status message -->
                                        <!-- Content Sections -->
                                        <!-- TODO Need to modify api-doc-html-item.ftl to use a different variable -->



 


<?php
//param
                                    $param_sec = file_get_contents('output_html/op.html');
                                    echo $param_sec;
                                    ?>


<?php
//param
                                    $param_sec = file_get_contents('output_html/param.html');
                                    echo $param_sec;
                                    ?>