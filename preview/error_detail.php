<?php
$livesite = 'https://stg-devcentral.cingular.com/';
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8" />
        <title>Speech API Documentation | AT&amp;T Developer</title>
        <meta charset="utf-8" />
        <meta name="description" content="Use AT&T APIs to build, test, and certify applications across a range of devices and platforms." />
        <meta name="keywords" content="AT&T Developer, AT&T APIs, APIs, API, Speech API, SMS API, Network Services, Developers, Mobile Apps, Mobile Devices, Cross Carrier Distribution Opportunities, Developer Program, API SDK, SDK, SDKs, U-Verse Enabled, AT&T ARO, LTE, 4G, AT&T, AT&T Wireless" />
        <meta name="robots" content="noindex" />

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=640">

        <!-- Fonts
        ================================================== -->

        <!-- CSS
        ================================================== -->
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/default.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/skeleton.css" />
        <link rel="stylesheet" href="static-assets/css/api-doc.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/modular.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/button.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/footer.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/header-common.css" />
        <link rel="stylesheet" href="<?=$livesite?>static-assets/css/header-title.css" />
        <!--[if lt IE 9]>
          <script src="/<?=$livesite?>static-assets/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <script src="<?=$livesite?>static-assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?=$livesite?>static-assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="<?=$livesite?>static-assets/js/errors.js" type="text/javascript"></script>



    </head>


    <body class=api-docs>

        <div id="content-area">


            <div id="att-header" class="container">

                <a class="logo" href="/">
                    <img class="att-logo" title="AT&T Developer" alt="AT&T Developer" src="<?=$livesite?>static-assets/images/logo-developer.png"
                         data-at2x="<?=$livesite?>static-assets/images/hi-res/logo-developer.png" width="127" />
                </a>
                <form id="quick-search" class="hide-border" action="/search-results">
                    <button class="magnifying-glass form-icon" type="submit" value="Search" title="Click here to see search results"></button>
                    <input id="search" type="text" autocomplete="off" placeholder="Type here to search" />
                    <div id="suggested-result">
                        <ul>
                            <li>
                                <a href="/api/speech">Speech API</a>
                            </li>
                        </ul>
                    </div>
                </form>

                <nav>
                    <div class="dropdown">
                        <a href="/apis" class="expands">
                            <abbr>APIs</abbr>
                        </a>
                        <div class="dropdown-menu apis" style="display: none;">
                            <ul>
                                <li>
                                    <a href="/apis/speech">
                                        <img class="api-icon" title="Speech API" alt="Speech API" src="/<?=$livesite?>static-assets/images/api-icons/speech-icon.png" data-at2x="/<?=$livesite?>static-assets/images/hi-res/api-icons/speech-icon.png" width="20">
                                        Speech
                                    </a>
                                    <a class="docs-link" href="/apis/speech/docs">Docs</a>
                                </li>
                                <li>
                                    <a href="/apis/call-management">
                                        <img class="api-icon" title="Call Management API" alt="Call Management API" src="/<?=$livesite?>static-assets/images/api-icons/call-management-icon.png" data-at2x="/<?=$livesite?>static-assets/images/hi-res/api-icons/call-management-icon.png" width="20">
                                        Call Management (Beta)
                                    </a>
                                    <a class="docs-link" href="/apis/call-management/docs">Docs</a>
                                </li>
                                <li>
                                    <a href="/apis/msm-mms">
                                        <img class="api-icon" title="SMS API" alt="SMS API" src="/<?=$livesite?>static-assets/images/api-icons/sms-icon.png" data-at2x="/<?=$livesite?>static-assets/images/hi-res/api-icons/sms-icon.png" width="20">
                                        SMS
                                    </a>
                                    <a class="docs-link" href="/apis/sms/docs">Docs</a>
                                </li>
                                <li>
                                    <a href="/apis/msm-mms">
                                        <img class="api-icon" title="MMS API" alt="MMS API" src="/<?=$livesite?>static-assets/images/api-icons/mms-icon.png" data-at2x="/<?=$livesite?>static-assets/images/hi-res/api-icons/mms-icon.png" width="20">
                                        MMS
                                    </a>
                                    <a class="docs-link" href="/apis/msm-mms/docs">Docs</a>
                                </li>
                                <li>
                                    <a href="/apis/in-app-messaging">
                                        <img class="api-icon" title="IMMN API" alt="IMMN API" src="/<?=$livesite?>static-assets/images/api-icons/immn-icon.png" data-at2x="/<?=$livesite?>static-assets/images/hi-res/api-icons/immn-icon.png" width="20">
                                        In-App Messaging
                                    </a>
                                    <a class="docs-link" href="/apis/in-app-messaging/docs">Docs</a>
                                </li>
                                <li>
                                    <a href="/apis">
                                        View all APIs
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a href="/community" class="expands">Community</a>
                        <div class="dropdown-menu" style="display: none;">
                            <ul>
                                <li>
                                    <a href="/community/events">
                                        Hackathons &amp; Events
                                    </a>
                                </li>
                                <li>
                                    <a href="/community/forums">
                                        Forums
                                    </a>
                                </li>
                                <li>
                                    <a href="/community/blog">
                                        Blog
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href="/stories">
                        Stories
                    </a>

                    <a href="/pricing">
                        Pricing
                    </a>

                    <div class="dropdown">
                        <a href="/login" class="login">Login</a>
                    </div>

                    <a class="button" href="/signup">Get Started Free</a>

                </nav>
            </div>
            <div id="errors" class="landing-page page">
                <!--errors-sub-header start-->
                <div class="sub-header-container">
                    <div class="sub-header">
                        <div class="container">
                            <a href="/apierrors">
                                <h1>
                                    Error Codes
                                </h1>
                            </a>      
                        </div>
                    </div>
                </div>
                <!--error-sub-header stop-->
                <header id="api-docs-header">
                    <div class="sub-banner">
                        <form id="filters" class="detail_filter">
                            <div class="filter">
                                <label for="api-selector">Fine API</label>
                                <select id="api-selector" name="api"
                                        data-value="speech">
                                    <option value="all">All APIs</option>
                                    <option value="advertising">Advertising</option>
                                    <option value="call-management">Call Management</option>
                                    <option value="device-capabilities">Device Capabilities</option>
                                    <option value="in-app-messaging">In-App Messaging</option>
                                    <option value="mms">MMS</option>
                                    <option value="notary">Notary</option>
                                    <option value="oauth-2">OAuth 2.0</option>
                                    <option value="payment">Payment</option>
                                    <option value="sms">SMS</option>
                                    <option value="speech">Speech</option>
                                </select>
                            </div>

                            <div class="filter">
                                <label for="type-selector">Error Type</label>
                                <select id="type-selector" name="type"
                                        data-value="">
                                    <option value="all">All Errors</option>
                                    <option value="SVC">Service Errors</option>
                                    <option value="POL">Policy Errors</option>

                                </select>
                            </div>

                            <div class="filter">
                                <input id="errorcode" type="text" name="code"
                                       placeholder="Type to search or filter results..." />
                            </div>
                        </form>
                    </div>

                </header>
                <div id="errors" class="landing-page page">
                    <section id="error-code" class="level-1">

                        <?php
                        include 'html/iam/errors/pol0002.html';
                        ?>

                </div>

                </section>
                <div id="att-footer" class="container">
                    <div class="footer-top">
                        <div id="sitemap">
                            <section class="apis">
                                <header>APIs &amp; Tools</header>
                                <ul>
                                    <li><a href="/api/list">Our APIs</a></li>
                                    <li><a href="/aro">AT&amp;T ARO for Android</a></li>
                                    <li><a href="/sdks-plugins-and-more">SDKs, Plugins, &amp; More</a></li>
                                </ul>
                            </section>

                            <section class="resources">
                                <header>Additional Resources</header>
                                <ul>
                                    <li><a href="/technical-library">Technical Articles</a></li>
                                    <li><a href="/distribute-your-app">Distribute Your App</a></li>
                                    <li><a href="/device-references-and-specs">Device References and Specs</a></li>
                                </ul>
                            </section>

                            <section class="support">
                                <header>Support</header>
                                <ul>
                                    <li><a href="/contact-us">Contact Us</a></li>
                                    <li><a href="#">Live Chat</a></li>
                                    <li><a href="#">Submit a Ticket</a></li>
                                    <li><a href="/support/faqs">FAQs</a></li>
                                    <li><a href="/support/bug-bounty">Bug Bounty</a></li>
                                </ul>
                            </section>
                        </div>

                        <section class="platform">
                            <div class="status healthy">
                                <div class="icon"></div>

                                <p class="healthy">
                                    AT&amp;T Developer Network
                                    <strong>Platform is Healthy</strong>
                                </p>

                                <a href="#" class="button gray">See Details</a>
                            </div>
                        </section>

                        <section class="social-media-links">
                            <ul>
                                <li class="facebook">
                                    <a href="#"><span class="icon"></span> Facebook</a>
                                </li>

                                <li class="twitter">
                                    <a href="#"><span class="icon"></span> Twitter</a>
                                </li>

                                <li class="github">
                                    <a href="#"><span class="icon"></span> GitHub</a>
                                </li>
                            </ul>
                        </section>
                    </div>

                    <div class="footer-bottom">
                        <a class="logo" href="http://www.att.com/" title="AT&amp;T">
                            <img class="att-logo" alt="AT&T Developer" src="<?=$livesite?>static-assets/images/logo-globe.png"
                                 data-at2x="<?=$livesite?>static-assets/images/hi-res/logo-globe.png" width="30">
                        </a>

                        <div id="links">
                            <nav>
                                <a href="http://www.att.com/gen/general?pid=11561">Terms of Use</a>
                                <a href="http://www.att.com/gen/privacy-policy?pid=2506">Privacy Policy</a>
                                <a href="/contact" class="last">Contact Us</a>
                            </nav>

                            <p><a href="http://www.att.com/gen/privacy-policy?pid=2587">&copy;2013 AT&amp;T Intellectual Property.</a> All rights reserved.</p>
                        </div>

                        <div id="trademark-notes">
                            <p>AT&amp;T, the AT&amp;T logo and all other AT&amp;T marks contained herein are trademarks of<br>AT&amp;T Intellectual Property and/or AT&amp;T affiliated companies. AT&amp;T 36USC220506</p>
                        </div>
                    </div>
                </div>

                <div id="att-footer-responsive" class="container">
                    <div class="footer-top">

                        <a class="button big blue remove-responsive">View Full Website</a>

                        <div id="sitemap">
                            <section>
                                <header>Mobile Sitemap</header>
                                <ul>
                                    <li><a href="/api/list">Our APIs</a></li>
                                    <li><a href="/aro">AT&amp;T ARO for Android</a></li>
                                    <li><a href="/api/pricing">Pricing</a></li>
                                    <li><a href="/stories">Stories</a></li>
                                </ul>
                            </section>
                        </div>

                        <section class="social-media-links">
                            <ul>
                                <li class="facebook">
                                    <a href="#"><span class="icon"></span> Facebook</a>
                                </li>

                                <li class="twitter">
                                    <a href="#"><span class="icon"></span> Twitter</a>
                                </li>

                                <li class="github">
                                    <a href="#"><span class="icon"></span> GitHub</a>
                                </li>
                            </ul>
                        </section>
                    </div>

                    <section class="platform">
                        <div class="status healthy">
                            <div class="icon"></div>

                            <p class="healthy">
                                AT&amp;T Developer Network
                                <strong>Platform is Healthy</strong>
                            </p>
                        </div>
                    </section>

                    <div class="footer-bottom">

                        <div id="links">
                            <nav>
                                <a href="http://www.att.com/gen/general?pid=11561">Terms of Use</a>
                                <a href="http://www.att.com/gen/privacy-policy?pid=2506">Privacy Policy</a>
                                <a href="/sitemap">Sitemap</a>
                                <a href="/contact">Contact Us</a>
                            </nav>
                        </div>

                        <a class="logo" href="http://www.att.com/" title="AT&amp;T">
                            <img class="att-logo" alt="AT&T Developer" src="<?=$livesite?>static-assets/images/logo-globe.png"
                                 data-at2x="<?=$livesite?>static-assets/images/hi-res/logo-globe.png" width="60">
                        </a>

                        <div id="trademark-notes">
                            <p><a href="http://www.att.com/gen/privacy-policy?pid=2587">&copy;2013 AT&amp;T Intellectual Property. All rights reserved.</a></p>
                            <p>AT&amp;T, the AT&amp;T logo and all other AT&amp;T marks contained herein are trademarks of<br>AT&amp;T Intellectual Property and/or AT&amp;T affiliated companies. AT&amp;T 36USC220506</p>
                        </div>
                    </div>
                </div>


            </div>
            <!--<script src="<?=$livesite?>static-assets/js/fancy-select.js" type="text/javascript"></script>-->


            <link rel="stylesheet" href="/css/hi-res.css" />
    </body>
</html>
