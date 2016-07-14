<?php 
global $more;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 :: Members Area</title>

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
.featured-event img {max-width: 100% !important; height: auto !important}
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

  <body class="members-home">

<?php get_template_part('g2c2-nav'); ?>

<div class="container">

<header class="section-header">
  <h1>Members Area</h1>
</header>

<section class="intro-container col-xs-12">

  <article class="intro-text col-xs-12">
      <?php
        while ( have_posts() ) : the_post();
          //get_template_part( 'content', 'page' );
          the_content();
        endwhile;
      ?>
  <a href="#" id="welcome-toggle">Hide welcome message</a>
  </article>

</section>

<section class="feeds-container col-xs-12">

<div class="col-xs-6">
  <h2>Members Blog</h2>
  <?php
      $args = array( 
        'post_type' => 'memberblog',
        'posts_per_page' => '2'
      );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
  ?>

  <article class="blog-post">  
    <h3 class="blog-post-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <p class="blog-post-meta"><?php the_date(); ?></p>
    <?php the_excerpt(); ?><a class="blog-readmore" href="<?php the_permalink();?>">Read more &hellip;</a>
  </article>

  <?php endwhile; else: 
    theme_404_content();
    endif; 
    ?>
  <h5 class="col-xs-12 blog-archivelink"><a href="/memberblog/" title="Blog archive">Read older blog posts&nbsp;&nbsp;&nbsp;&gt;&gt;</a></h5>

</div><!-- /col-xs-6 column separator -->

<div class="col-xs-6">
<!-- Show featured event graphic, if present-->
<?php
if (have_posts()) {
$args = array( 
  'post_type' => 'event',
  'meta_query' => array(
      array(
          'key' => 'g2c2-event_type',
          'value' => 'Networking',
          'compare' => 'IN',
       ),
      array(
          'key' => 'g2c2-event_featured',
          'value' => true,
          'compare' => '='
       )
   )
 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
?>
  
    <a class="featured-event" href="<?php thepermalink(); ?>">
      <?php 
        $image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'g2c2-event_advert',true ), 'full' ); 
        echo $image;
        ?>  
    </a>


<?php
endwhile;
      } 
      ?>

<!-- include "latest updates" widget -->
<?php widgets_on_template('1')?>

<!-- include custom event agendas -->
<div class="agenda-container">
<?php get_template_part('g2c2-networkingwidget'); ?>
<?php get_template_part('g2c2-fundingwidget'); ?>
</div><!-- /agenda-container -->
</div><!-- /col-xs-6 column separator -->

</section><!-- /feeds container -->

</section> <!-- agenda container -->


</div> <!-- container -->

<div class="footer col-xs-12">
<p>Copyright &copy; 2014 <a href="http://www.greenchemistrynetwork.org" target="_blank">Green Chemistry Network</a>.</p>
<p class="small">Developed by <a href="http://www.willsoutter.co.uk" target="_blank">Will Soutter</a>. Powered by WordPress. G2C2 and the Green Chemistry Network are not responsible for the content of external websites linked from this site.</p>
</div>

<!--
<script type="text/javascript">
head.load(
  "<?php echo get_bloginfo('template_directory');?>/g2c2-js/jquery-1.10.2.js",
  "<?php echo get_bloginfo('template_directory');?>/g2c2-js/bootstrap.min.js",
);
</script>
-->
<script type="text/javascript">
  $(document).ready(function() {
    $('#welcome-toggle').click(function() {
      event.preventDefault();
      $('.intro-text').slideUp();
    });
  });


</script>

</body>
</html>