<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Catocoin Portal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/images/logo/logo.png">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- nivo slider CSS -->
    <link rel="stylesheet" href="/lib/css/nivo-slider.css"/>
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="/css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="/css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/css/responsive.css">
    <!-- Template color css -->
    <link href="/css/color/color-core.css" data-style="styles" rel="stylesheet">
    <!-- User style -->
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="http://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">


    <!-- Modernizr JS -->
    <!-- <script src="/js/vendor/modernizr-2.8.3.min.js"></script> -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="/js/vendor/jquery-3.1.1.min.js"></script>

</head>

<body>

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- HEADER AREA START -->
        <header class="header-area header-wrapper">
            <div class="header-middle-area  transparent-header mi-header-area">
                <div class="container">
                    <div class="full-width-mega-drop-menu">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4 top-bar-items">Cato Coin Balance: <span class="catocoin_balance"></span></div>
                            <div class="col-md-4 col-sm-4 col-xs-4 top-bar-items">Current BTC Price: <span class="btc_price"></span></div>
                            <div class="col-md-4 col-sm-4 col-xs-4 top-bar-items">CatoCoin Value ($): <span class="value_usd_of_catocoin"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="header-top-bar bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="images/logo/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="header-search clearfix">
                                <form action="#">
                                    <button class="search-icon" type="submit">
                                        <img src="images/icons/search.png" alt="">
                                    </button>
                                    <input type="text" placeholder="Search...">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div id="sticky-header" class="header-middle-area  transparent-header hidden-xs">
                <div class="container">
                    <div class="full-width-mega-drop-menu">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="sticky-logo">
                                    <a href="index.html">
                                        <img src="images/logo/logo.png" alt="">
                                    </a>
                                </div>
                                <nav id="primary-menu">
                                    <ul class="main-menu text-center">
                                        <li><a href="/">Home</a></li>
                                        <li><a href="/fund">Fund Your Account</a></li>
                                        <li><a href="/wallet">Wallet Balance</a></li>
                                        <li><a target="_blank" href="https://catocoin.net">Explore CatoCoin</a></li>
                                        <li><a href="/news">CatoCoin News</a></li>
                                        <!--<li><a href="contact.html">Contact</a></li>-->
                                        <li id="log1"><a href="#">Login/Signup</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER AREA END -->

        <div class="signup-form" id="popup" style="display:block">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 hidden-xs login-left">
                        <br>
                        <h2>Login/Signup</h2>
                        <br></br>
                        <p align=left>
                            To acces your wallet balance(s), transactions and masternode status you must</br>
			    1. Signup (we will get notified)</br>
			    2. Download and install the 'Google Authenticator' for Apple or Android</br>
			    3. We will contact you to verify your identity (if we already host your wallet)</br>
			    4. We will then link your CatoCoin wallet to you account here</br>
                        </p>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <i class="fas fa-times cancel-btn"></i>
                        <form action="" method="post">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home" id="login-upMn">Login</a></li>
                                <li><a data-toggle="tab" href="#menu1" id="sign-upMn">Signup</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="registered-customers mb-50">
                                        <form action="{{ url('/login') }}" method="POST">
                                            {{csrf_field()}}
                                            <div class="login-account p-30 box-shadow">
                                                <p>If you have an account with us, Please log in.</p>
                                                @if ($message = Session::get('error'))
                                                  <div style="color:#cf0000;background-color:#f8f8f8;padding:10px 30px 10px 30px;border-bottom: 1px solid #eee">
                                                      <span style="font-weight:bold;">{{ $message }}</span>
                                                  </div>
                                                @endif
                                                <input type="email" name="email" placeholder="Email Address">
                                                @if ($errors->has('email'))
                                                    <span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
                                                @endif
                                                <input type="password" name="password" placeholder="Password">
                                                @if ($errors->has('password'))
                                                    <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                                                @endif
                                                <p><small><a href="{{ url('/password/reset') }}">Forgot our password?</a></small></p>
                                                <button class="submit-btn-1" type="submit">login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <div class="new-customers mb-50">
                                        <form action="{{ url('/register') }}" method="POST">
                                            {{ csrf_field() }}

                                            <div class="login-account p-30 box-shadow">
                                                <div class="row" style="background: none;">
                                                    <div class="col-sm-6">
                                                        <input type="text"  name="first_name" placeholder="First Name">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text"  name="last_name" placeholder="Last Name">
                                                    </div>
                                                </div>
                                                <input type="text" name="name"  placeholder="User Name">
                                                <input type="text" name="email" placeholder="Email address here...">
                                                <input type="password"  name="password" placeholder="Password">
                                                <input type="password"  name="password_confirmation" placeholder="Confirm Password">
                                                <div class="row" style="background: none;">
                                                    <div class="col-sm-6 col-xs-12">
                                                        <button class="submit-btn-1 mt-20" type="submit" value="register">Register</button>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-12">
                                                        <button class="submit-btn-1 mt-20 f-right" type="reset">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU AREA START -->
        <div class="mobile-menu-area hidden-sm hidden-md hidden-lg">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/fund-your-account">Fund Your Account</a></li>
                                    <li><a href="/wallet">Wallet Balance</a></li>
                                    <li><a href="/download">Explore CatoCoin</a></li>
                                    <li><a href="/news">CatoCoin News</a></li>
                                    <!--<li><a href="contact.html">Contact</a></li>-->
                                    <li id="log2"><a href="#">Login/Signup</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MOBILE MENU AREA END -->


        @yield('content')

        <!-- Start footer area -->
        <footer id="footer" class="footer-area bg-2 bg-opacity-black-90">
            <div class="footer-top pt-110 pb-80">
                <div class="container">
                    <div class="row">
                        <!-- footer-address -->
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-widget">
                                <h6 class="footer-titel">GET IN TOUCH</h6>
                                <ul class="footer-address">
                                    <li>
                                        <div class="address-icon">
                                            <img src="images/icons/location-2.png" alt="">
                                        </div>
                                        <div class="address-info">
                                            <span>8901 Marmora Raod,</span>
                                            <span>Glasgow, D04  89GR</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="address-icon">
                                            <img src="images/icons/phone-3.png" alt="">
                                        </div>
                                        <div class="address-info">
                                            <span>Telephone : (801) 4256  9856</span>
                                            <span>Telephone : (801) 4256  9658</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="address-icon">
                                            <img src="images/icons/world.png" alt="">
                                        </div>
                                        <div class="address-info">
                                            <span>Email : contact@misujon.com</span>
                                            <span>Web :<a href="#" target="_blank"> www.misujon.com</a></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- footer-latest-news -->
                        <div class="col-lg-6 col-md-5 hidden-sm col-xs-12">
                            <div class="footer-widget middle">
                                <h6 class="footer-titel">LATEST NEWS</h6>
                                <div class="footer-latest-news">
                                    <a class="twitter-timeline"
                                       href="https://twitter.com/catocoin"
                                       data-tweet-limit="3">
                                        Tweets by @TwitterDev
                                    </a>
                                    <script async src="http://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                            </div>
                        </div>
                        <!-- footer-contact -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="footer-widget">
                                <h6 class="footer-titel">QUICK CONTACT</h6>
                                <div class="footer-contact">
                                    <p>Lorem ipsum dolor sit amet, consectetur acinglit sed do eiusmod tempor</p>
                                    <form  id="contact-form-2" action="mail_footer.php" method="post">
                                        <input type="email" name="email2" placeholder="Type your E-mail address...">
                                        <textarea name="message2" placeholder="Write here..."></textarea>
                                        <button type="submit" value="send">Send</button>
                                    </form>
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="copyright text-center">
                                <p>Copyright &copy; 2018 Cato Coins LLC. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End footer area -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Bootstrap framework js -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- Nivo slider js -->
    <script src="/lib/js/jquery.nivo.slider.js"></script>
    <!-- ajax-mail js -->
    <script src="/js/ajax-mail.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="/js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="/js/main.js"></script>

    <script src='http://www.google.com/recaptcha/api.js'></script>

    <script>
        $(document).ready(function(){
            $("#log1").click(function(){
                $("#popup").fadeToggle( "slow" );

            });

            $(".cancel-btn").click(function () {
                $("#popup").hide();
            });

            $("#log2").click(function(){
                $("#popup").fadeToggle( "slow" );

            });
        });

    </script>

<script>
    $("#sign-upMn").click(function () {
        $(".login-left").height(565);
    })
    $("#login-upMn").click(function () {
        $(".login-left").height(435);
    })
</script>

</body>

</html>
