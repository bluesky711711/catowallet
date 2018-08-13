<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"  />
    <link rel="stylesheet" type="text/css" href="css/hover-min.css"  />
    <link rel="stylesheet" type="text/css" href="css/animate.css"  />
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css"  />
	  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"  />
    <link rel="stylesheet" type="text/css" href="fonts/sitefonts/stylesheet.css"  />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="css/owl.theme.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />
</head>

<body>
<wrapper>
	<header class="form_header">
    	<div class="header_middle">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-3">
                    	<div class="logo_left">
                        	<a href="/"><img src="images/coin_logo.png" alt="logo" class="img-responsive" style="height:45px"/><img src="images/coin_logo_next.png" alt="logo" class="img-responsive" style="height:45px;padding-left:5px"/></a>
                        </div>
                    </div>
                    <div class="col-md-9">
                    	<div class="form_header_right">
                        	<ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fa fa-github-alt"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                                <li><a href="#"><i class="fa fa-github"></i></a></li>
                            </ul>
                            <span><a class="btn btn-default" href="/register">register</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="form_body">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6">

                	<div class="form_content login_form">
                    	<h2>Signin <span>Login your account</span></h2>
                        <div class="row">
                          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                              {{ csrf_field() }}
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                            <div class="col-sm-12">
                                <div class="form_block">
                                    <span><i class="ti-email"></i>
                                    <input type="text" autocomplete="off" placeholder="Email ID" name="email" required/></span>
                                </div>
                                <div class="form_block">
                                    <span><i class="ti-key"></i>
                                    <input type="password" autocomplete="off" placeholder="Password" name="password" required/></span>
                                </div>
                                <div class="check_box">
                                    <span><input type="checkbox" autocomplete="off" /> Remember me</span>
                                </div>
                                <div class="submit_btn">
                                    <input type="submit" class="btn btn-primary" value="Login" />
                                </div>
                            </div>
                          </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                	<div class="banner_right form_body_right">
                    	<h4>PRE - ICO Start in</h4>
                        <div id="clockdiv" class="clock_counter_main">
                            <ul>
                                <li><span class="days"></span><small>:</small></li>
                                <li><span class="hours"></span><small>:</small></li>
                                <li><span class="minutes"></span><small>:</small></li>
                                <li><span class="seconds"></span></li>
                            </ul>
                        </div>
                        <p>Nulla a condimentum mauris. Sed ut convallis turpis. Ut cursus porta ligula at ultricies.</p>
                        <img src="images/banner_arcana.png" alt="banner_show_img" class="img-responsive" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="form_footer">
        <div class="footer_bottom">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<h6>Terms of service  &  All rights Reserved</h6>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</wrapper>
</body>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function initializeClock(id, endtime) {
        var clock = document.getElementById(id);
        var daysSpan = clock.querySelector('.days');
        var hoursSpan = clock.querySelector('.hours');
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

            daysSpan.innerHTML = t.days;
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000);
    initializeClock('clockdiv', deadline);
</script>

</html>
