<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Catocoin Portal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
          @if (isset($page) && $page == "wallet")
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
            <div class="header-middle-area  transparent-header mi-header-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="logo" style="text-align:right">
                                <a target="_blank" href="https://www.coinexchange.io/market/CATO/BTC">
                                    <img src="/images/coinexchange_logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12"></div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                          <div class="logo" style="text-align:left">
                              <a target="_blank" href="https://wallet.crypto-bridge.org/market/BRIDGE.CATO_BRIDGE.BTC">
                                  <img src="/images/cryptobridge_logo.png" alt="">
                              </a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
                                        @if (Auth::guest())
                                        <li><a href="/login">Log in/Sign up</a></li>
                                        @else
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                {{ Auth::user()->name }} <span class="caret"></span>
                                            </a>

                                            <ul class="dropdown-menu" role="menu">
                                                <li style="width: 100%;"><a href="/2fa">2FA</a></li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="Logout(event)">Log Out</a>
                                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER AREA END -->

        <div class="signup-form" id="popup" style="">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 hidden-xs login-left">
                        <br>
                        <h2>Login</h2>
                        <br>
                        <p>
                            Get access to your Orders, Wishlist and Recommendations
                        </p>
                        <img src="images/login-left.png" class="img-responsive">
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
                                                <input type="email" name="email" placeholder="Email Address">
                                                <input type="password" name="password" placeholder="Password">
                                                <p><small><a href="#">Forgot our password?</a></small></p>
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
                                                        <input type="text" name="first_name" placeholder="First Name">
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
                        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
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
                        <!-- <div class="col-lg-6 col-md-5 hidden-sm col-xs-12">
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
                        </div> -->
                        <!-- footer-contact -->
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
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
                                <p>Copyright &copy; 2018 <a href="https://www.misujon.com/"><b>Misujon</b></a>. All rights reserved.</p>
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
    function Logout(e){
      console.log('logout');
      e.preventDefault();
      document.getElementById('logout-form').submit();
    }


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

    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    console.log('chrome', isChrome);

    if (!isChrome){
      alert('We require to run on chrome browser!');
    }
</script>

</body>

</html>
