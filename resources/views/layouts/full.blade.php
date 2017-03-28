<!DOCTYPE html>
<!-- saved from url=(0051) -->
<html class="no-mobile no-touch" style="height: auto;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Humanitarci.hr</title>
    <meta name="description"
          content="Humanitarci.hr je potpuno transparentna platforma za doniranje novca, hrane i nužnih potrepština">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="google-site-verification" content="pKDL-2njZLD7AHfG5Lhf1kqockfqKfhmqpBTGmz5GcU" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">


    {{--Social tags--}}
    @if(isset($page))
        <meta name="description" content="<?= htmlentities(strip_tags($page->description)) ?>">
        <meta name="title" content="Humanitarci.hr">
        <meta name="keywords" content="humanitarci, donacije, udruge, online donacije, humanitarna platforma, transparentno doniranje"/>
        <meta name="robots" content="index, follow" />

        <meta property="fb:app_id" content="1022391537889674">
        <meta property="og:title" content="<?= htmlentities($page->title) ?>"/>
        <meta property="og:type" content="website"/>
        <meta property="og:locale" content="en_US"/>
        <meta property="og:site_name" content="Humanitarci.hr"/>
        <meta property="og:image" content="<?= $page->image ?>"/>
        <meta property="og:url" content="<?= env('APP_URL').$page->url ?>"/>
        <meta property="og:description" content="<?= htmlentities(strip_tags($page->description)) ?>"/>

        <!-- START: TWITTER -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@humanitarci.hr">
        <meta name="twitter:creator" content="@humanitarci.hr">
        <meta name="twitter:title" content="<?= htmlentities($page->title) ?>">
        <meta name="twitter:description" content="<?= htmlentities(strip_tags($page->description)) ?>">
        <meta name="twitter:image" content="<?= $page->image ?>">
        @endif
                <!-- Favicons -->
        <link rel="shortcut icon" href="/front/images/humanitarci-icon.png">
        <link rel="apple-touch-icon" href="http://rhythm.bestlooker.pro/images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72"
              href="http://rhythm.bestlooker.pro/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114"
              href="http://rhythm.bestlooker.pro/images/apple-touch-icon-114x114.png">

        <!-- CSS -->
        {{--Select2--}}
        <link href="/administrator/css/plugins/select2/select2.min.css" rel="stylesheet">

        <link rel="stylesheet" href="/front/css/bootstrap.min.css">
        <link rel="stylesheet" href="/front/css/style.css">
        <link rel="stylesheet" href="/front/css/style-responsive.css">
        <link rel="stylesheet" href="/front/css/animate.min.css">
        <link rel="stylesheet" href="/front/css/vertical-rhythm.min.css">
        <link rel="stylesheet" href="/front/css/owl.carousel.css">
        <link rel="stylesheet" href="/front/css/magnific-popup.css">
        <link rel="stylesheet" href="/front/css/extended.css">
        <style type="text/css">
            .accent {
                color: #08c;
            }
        </style>
        <script type="text/javascript" src="/front/js/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="/front/js/bootstrap.min.js"></script>
        <script src="/front/js/donations.js" type="text/javascript"></script>
<body class="appear-animate">
@include('sections.navbar')
@yield('content')
@include('sections.footer')


        <!-- JS -->

<script type="text/javascript" src="/front/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="/front/js/SmoothScroll.js"></script>
<script type="text/javascript" src="/front/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="/front/js/jquery.localScroll.min.js"></script>
<script type="text/javascript" src="/front/js/jquery.viewport.mini.js"></script>
<script type="text/javascript" src="/front/js/jquery.countTo.js"></script>
<!-- Select2 -->
<script src="/administrator/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="/front/js/jquery.appear.js"></script>
<script type="text/javascript" src="/front/js/jquery.sticky.js"></script>
<script type="text/javascript" src="/front/js/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="/front/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="/front/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/front/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="/front/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="/front/js/jquery.magnific-popup.min.js"></script>
<!-- Clock picker -->
<script src="/administrator/js/plugins/clockpicker/clockpicker.js"></script>



<script type="text/javascript" src="/front/js/wow.min.js"></script>
<script type="text/javascript" src="/front/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="/front/js/jquery.simple-text-rotator.min.js"></script>
<script type="text/javascript" src="/front/js/all.js"></script>
<script type="text/javascript" src="/front/js/contact-form.js"></script>
<script type="text/javascript" src="/front/js/jquery.ajaxchimp.min.js"></script>
<script type="text/javascript" src="/front/js/shared.js"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="/front/js/placeholder.js"></script><![endif]-->


<script aria-hidden="true" type="application/x-lastpass" id="hiddenlpsubmitdiv" style="display: none;"></script>
<script>try {
        (function () {
            for (var lastpass_iter = 0; lastpass_iter < document.forms.length; lastpass_iter++) {
                var lastpass_f = document.forms[lastpass_iter];
                if (typeof(lastpass_f.lpsubmitorig2) == "undefined") {
                    lastpass_f.lpsubmitorig2 = lastpass_f.submit;
                    if (typeof(lastpass_f.lpsubmitorig2) == 'object') {
                        continue;
                    }
                    lastpass_f.submit = function () {
                        var form = this;
                        var customEvent = document.createEvent("Event");
                        customEvent.initEvent("lpCustomEvent", true, true);
                        var d = document.getElementById("hiddenlpsubmitdiv");
                        if (d) {
                            for (var i = 0; i < document.forms.length; i++) {
                                if (document.forms[i] == form) {
                                    if (typeof(d.innerText) != 'undefined') {
                                        d.innerText = i.toString();
                                    } else {
                                        d.textContent = i.toString();
                                    }
                                }
                            }
                            d.dispatchEvent(customEvent);
                        }
                        form.lpsubmitorig2();
                    }
                }
            }
        })()
    } catch (e) {
    }</script>
<script>try {
        function lpshowmenudiv(id) {
            closelpmenus(id);
            var div = document.getElementById('lppopup' + id);
            var btn = document.getElementById('lp' + id);
            if (btn && div) {
                var btnstyle = window.getComputedStyle(btn, null);
                var divstyle = window.getComputedStyle(div, null);
                var posx = btn.offsetLeft;
                posx -= 80;
                var divwidth = parseInt(divstyle.getPropertyValue('width'));
                if (posx + divwidth > window.innerWidth - 25) {
                    posx -= ((posx + divwidth) - window.innerWidth + 25);
                }
                div.style.left = posx + "px";
                div.style.top = (btn.offsetTop + parseInt(btnstyle.getPropertyValue('height'))) + "px";
                if (div.style.display == 'block') {
                    div.style.display = 'none';
                    if (typeof(slideup) == 'function') {
                        slideup();
                    }
                } else div.style.display = 'block';
            }
        }

        function closelpmenus(id) {
            if (typeof(lpgblmenus) != 'undefined') {
                for (var i = 0; i < lpgblmenus.length; i++) {
                    if ((id == null || lpgblmenus[i] != 'lppopup' + id) && document.getElementById(lpgblmenus[i]))         document.getElementById(lpgblmenus[i]).style.display = 'none';
                }
            }
        }

        var lpcustomEvent = document.createEvent('Event');
        lpcustomEvent.initEvent('lpCustomEventMenu', true, true);
    } catch (e) {
    }</script>
<script>try {
        document.addEventListener('mouseup', function (e) {
            if (typeof(closelpmenus) == 'function') {
                closelpmenus();
            }
        }, false)
    } catch (e) {
    }</script>


<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '1022391537889674',
            xfbml: true,
            version: 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5bqySB73b-fsaoP4446s0CB-dlIBjjJc&callback=initMap"
        async defer></script>
</body>
</html>