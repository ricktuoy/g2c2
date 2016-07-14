<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage G2C2
 * @since G2C2 1.0
 */
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 <?php wp_title(); ?></title>

    <link href="<?php echo get_bloginfo('template_directory');?>/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/headjs/1.0.3/head.min.js"></script>
    <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/cookiebar/jquery.cookiebar.js"></script>


<style>
.footer {position: static}
.featured-event img {max-width: 100% !important; height: auto !important}
</style>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56888704-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End Google Analytics -->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//kebili.willsoutter.co.uk/analytics/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 2]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//kebili.willsoutter.co.uk/analytics/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik -->
<!-- Adaptive Images -->
<script>
    document.cookie='resolution='+Math.max(screen.width,screen.height)+("devicePixelRatio" in window ? ","+devicePixelRatio : ",1")+'; path=/';
</script>
<!-- End Adpative Images -->


<!-- COOKIE BAR -->
<script>
$(document).ready(function(){
  $.cookieBar({
    message: 'We use cookies to improve your experience on this site.',
    acceptButton: true,
    acceptText: 'I Understand',
    declineButton: false,
    declineText: 'Disable Cookies',
    policyButton: true,
    policyText: 'Cookie Policy',
    policyURL: '/cookie-policy/',
    autoEnable: true,
    acceptOnContinue: false,
    expireDays: 365,
    forceShow: false,
});
});
</script>
<!-- End Cookie Bar -->

  </head>

  <body>

    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <img src="<?php echo get_bloginfo('template_directory');?>/icon-mobile-nav.png" width="32px" />
          </button>
          <a class="navbar-brand" href="<?php echo site_url(); ?>/"><img src="<?php echo get_bloginfo('template_directory');?>/g2c2-logo.png" /></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li>
              <a href="<?php echo site_url(); ?>/#about">About G2C2</a>
            </li>
            <li>
              <a href="<?php echo site_url(); ?>/#news">News</a>
            </li>
            <li>
        <a href="<?php echo site_url(); ?>/?page_id=22">Members&#39; Area</a>
      </li>
          
          </ul>    
        </div><!--/.nav-collapse -->
    </nav>