<?php define('WP_USE_THEMES', false);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 :: Educational Resources</title>

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
    <style>
    .footer {position: static; width: 100%}
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

  <body class="resources">

<?php get_template_part('g2c2-nav'); ?>
<div class="container">

  <header class="section-header">
    <h1 class="col-xs-12" >Online Resources</h1>
  </header>

  <section class="col-xs-12 links-main js-masonry" data-masonry-options='{ "columnWidth": 367.5, "itemSelector": "article.link" }'>

      <?php
$args = array(
  'post_type' => 'resource',
  'meta_query' => array(
      array(
          'key' => 'g2c2-resource_type',
          'value' => 'Online resource',
          'compare' => '='
          )
      )
);
$loop = new WP_Query( $args );

if ( $loop->have_posts()) : while ( $loop->have_posts() ) : $loop->the_post();

    $image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'g2c2-resource_image',true ), 'full' ); 
      ?>

      <article class="link">
        <a href="<?php the_field('g2c2-resource_link'); ?>" target="_blank">
          <?php echo $image; ?>
          <p><?php the_field('g2c2-resource_description'); ?></p>
        </a>
      </article>

<?php endwhile; else : ?>
	<em style="color: #808080;">No online resources</em>
<?php endif; ?>

  </section>

  <header class="section-header">
    <h1 class="col-xs-12">University Courses</h1>
  </header>
  
  <section class="col-xs-12 links-main js-masonry" data-masonry-options='{ "columnWidth": 367.5, "itemSelector": "article.link" }'>
      <?php
$args = array(
  'post_type' => 'resource',
  'meta_query' => array(
      array(
          'key' => 'g2c2-resource_type',
          'value' => 'University course',
          'compare' => '='
          )
      )
);
$loop = new WP_Query( $args );

if ($loop->have_posts()) : while ( $loop->have_posts() ) : $loop->the_post();
  
    $image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'g2c2-resource_image',true ), 'full' ); 
      ?>

      <article class="link">
        <a href="<?php the_field('g2c2-resource_link'); ?>" target="_blank">
          <?php echo $image; ?>
          <p><?php the_field('g2c2-resource_description'); ?></p>
        </a>
      </article>

<?php endwhile; else : ?>
	<em style="color: #808080;">No courses</em>
<?php endif; ?>

    </section>

<div class="resource-intro col-xs-6">

      <?php

      if (have_posts()) {
        /* Start the Loop */
        while (have_posts()) {
          the_post();
          get_template_part('content', 'page');
        }
      } else {
        theme_404_content();
      }
      ?>

</div>    


</div> <!-- container -->

<div class="footer col-xs-12">
<p>Copyright &copy; 2014 <a href="http://www.greenchemistrynetwork.org" target="_blank">Green Chemistry Network</a>.</p>
<p class="small">Developed by <a href="http://www.willsoutter.co.uk" target="_blank">Will Soutter</a>. Powered by WordPress. G2C2 and the Green Chemistry Network are not responsible for the content of external websites linked from this site.</p>
</div>

<script type="text/javascript">
head.load(
  "<?php echo get_bloginfo('template_directory');?>/js/jquery-1.10.2.js",
  "<?php echo get_bloginfo('template_directory');?>/js/bootstrap.min.js",
  "<?php echo get_bloginfo('template_directory');?>/js/masonry.min.js",
  "<?php echo get_bloginfo('template_directory');?>/cookiebar/jquery.cookiebar.js"
);
//COOKIE BAR
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
//End Cookie Bar
</script>

  </body>
</html>