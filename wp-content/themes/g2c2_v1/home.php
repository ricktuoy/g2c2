<?php 
global $more;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 :: A Global Network of Green Chemistry Centers</title>

    <link href="<?php echo get_bloginfo('template_directory');?>/style.css" rel="stylesheet">
    <link id="imgmap_style-css" href="<?php echo plugins_url();?>/imagemapper/imgmap_style.css?ver=4.0" rel="stylesheet">

   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 

    <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/js/head.min.js"></script>

<style>
.footer {position: static; width: 100%}
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

<div class="container">
<section class="hero-container col-xs-12">

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
      <div class="carousel-inner">

      <?php
        $args = array( 
          'post_type' => 'feature',
          'orderby' => 'meta_value',
          'order' => 'ASC',
          'meta_key' => 'g2c2-feature_position',
         );
        $loop = new WP_Query( $args );

        if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
        ?>

        <div class="item">
          <a href="<?php the_field('g2c2-feature_link'); ?>" title="<?php the_title(); ?>">
            <?php 
              $image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'g2c2-feature_image',true ), 'full' ); 
              echo $image;
            ?> 
            <div class="container">
              <div class="carousel-caption">
                <h1><?php the_title(); ?></h1>
                <p><?php the_field('g2c2-feature_subtitle'); ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endwhile;
            endif; ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>

</section>

<header class="section-header col-xs-12" id="news">
  <h1>Latest news</h1>
</header>

<section class="blog-main col-xs-12 col-sm-8 col-sm-push-4">


      <?php
      query_posts( 'posts_per_page=2' );
      if ( have_posts() ) : while ( have_posts() ) : the_post();
      $more = 0;
      ?>

          <article class="blog-post">  
            <h2 class="blog-post-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <p class="blog-post-meta"><?php the_date(); ?></p>
            <?php the_excerpt(); ?><a class="blog-readmore" href="<?php the_permalink();?>">Read more &hellip;</a>

          </article>

<?php endwhile; else: 
  theme_404_content();
  endif; 
  ?>

  <h5 class="col-xs-12 blog-archivelink"><a href="/news-archive/" title="News archive">Read older news&nbsp;&nbsp;&nbsp;&gt;&gt;</a></h5>

</section> <!--/blog-main -->

<section class="twitter-container col-xs-12 col-sm-4 col-sm-pull-8">
<a class="twitter-timeline"  href="https://twitter.com/globalgreenchem"  data-widget-id="442038816463806464">Tweets by @globalgreenchem</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
     
</section> <!-- twitter container -->

<header class="section-header col-xs-12" id="about">
  <h1>About G2C2</h1>
</header>

<section class="map col-xs-12">
<p>The G2C2 is a global collaboration between research centres, working together to further the cause of green chemistry. <a href="https://g2c2.greenchemistrynetwork.org/about-g2c2/">Click here</a> for more information about us, and see the map below for more datail about our members.</p>

<?php echo imgmap_frontend_image(39, "front-map"); ?>
</section>


</div> <!-- container -->

<div class="footer col-xs-12">
<p>Copyright &copy; 2014 <a href="http://www.greenchemistrynetwork.org" target="_blank">Green Chemistry Network</a>.</p>
<p class="small">Developed by <a href="http://www.willsoutter.co.uk" target="_blank">Will Soutter</a>. Powered by WordPress. G2C2 and the Green Chemistry Network are not responsible for the content of external websites linked from this site.</p>
</div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

  <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/js/jqueryui-plugins.min.js"></script>
  <script type="text/javascript" src="<?php echo get_bloginfo('template_directory');?>/cookiebar/jquery.cookiebar.js"></script>

  <!--
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.core.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.widget.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.mouse.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.resizable.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.draggable.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.button.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.position.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/ui/jquery.ui.dialog.min.js?ver=1.10.4"></script>
  <script type="text/javascript" src="<?php echo plugins_url(); ?>/imagemapper/script/jquery.imagemapster.min.js?ver=4.0"></script>
  <script type="text/javascript" src="<?php echo plugins_url(); ?>/imagemapper/imagemapper_script.js?ver=4.0"></script>
  -->

<script type="text/javascript">
// Init setup for dynamic Bootstrap carousel
  //make indicators list
  var myCarousel = $(".carousel");
  myCarousel.append("<ol class='carousel-indicators'></ol>");
  //add a button for each slide
  var indicators = $(".carousel-indicators"); 
  myCarousel.find(".carousel-inner").children(".item").each(function(index) {
      (index === 0) ? 
      indicators.append("<li data-target='#myCarousel' data-slide-to='"+index+"' class='active'></li>") : 
      indicators.append("<li data-target='#myCarousel' data-slide-to='"+index+"'></li>");
  });     
  //activate the first slide
  $('div.carousel-inner > div.item:first-child').addClass('active');
  //then call carousel
  $('.carousel').carousel();
</script>

<script type='text/javascript'>
/* <![CDATA[ */
var imgmap = {"ajaxurl":"https:\/\/g2c2.greenchemistrynetwork.org\/wp-admin\/admin-ajax.php","pulseOption":"first_time","admin_logged":"1","alt_dialog":"1"};
/* ]]> */
</script>

<script type="text/javascript">
$(function() {
  $('.navbar a[href*=#]:not([href=#]), .carousel-inner a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
</script>

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

</body>
</html>
