<?php 
global $more;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 :: Networking &amp; Conferences</title>

    <link href="<?php echo get_bloginfo('template_directory');?>/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/headjs/1.0.3/head.min.js" ></script>
    <script type="text/javascript">
      head.load(
        "<?php echo get_bloginfo('template_directory');?>/js/jquery-1.10.2.js",
        "<?php echo get_bloginfo('template_directory');?>/js/jquery.migrate.1.2.1.min.js",
        "<?php echo get_bloginfo('template_directory');?>/js/hashchange.min.js",
        "<?php echo get_bloginfo('template_directory');?>/js/jquery-ui-1.10.4.custom.min.js",
        "<?php echo get_bloginfo('template_directory');?>/js/bootstrap.min.js",
        "<?php echo get_bloginfo('template_directory');?>/cookiebar/jquery.cookiebar.js"
  );
    </script>
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

  <body class="events networking">

<?php get_template_part('g2c2-nav'); ?>



<div class="container">

<header class="section-header">
  <h1>Networking Events</h1>
</header>

<section class="intro-container col-xs-12">
  <article class="intro-text">
      <?php
        while ( have_posts() ) : the_post();
          //get_template_part( 'content', 'page' );
          the_content();
        endwhile;
      ?>
  </article>
</section>

<section class="events-list col-xs-5">
<ul>
      <?php
$args = array( 
  'post_type' => 'event',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_key' => 'g2c2-event_date',
  'meta_query' => array(
      array(
          'key' => 'g2c2-event_type',
          'value' => 'Networking',
          'compare' => 'IN',
       ),
      array(
          'key' => 'g2c2-event_date',
          'value' => date('Ymd'),
          'compare' =>  '>',
          'type' => 'DATE'
       )      
   )
 );
$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
?>

  <li>
    <a class="event-link id-<?php the_ID(); ?>" href="#<?php the_ID(); ?>">
      <h3 class="events-entry-title"><?php the_title(); ?></h3>
      <div class="events-entry-date">
        <?php 
          $ed = DateTime::createFromFormat('Ymd', get_field('g2c2-event_date'));
          echo $ed->format('j F Y');
        ?>
      </div>
      <p class="events-entry-shortdesc"><?php the_field('g2c2-event_shortDescription'); ?></p>
    </a>
  </li>  

<?php endwhile; else : ?>
  <em style="color: #808080;">No upcoming events</em>
<?php endif; ?>

</ul>

<h3>Past Events</h3>
<ul class="past-events-list">
      <?php
$args = array( 
  'post_type' => 'event',
  'orderby' => 'meta_value',
  'order' => 'ASC',
  'meta_key' => 'g2c2-event_date',
  'meta_query' => array(
      array(
          'key' => 'g2c2-event_type',
          'value' => 'Networking',
          'compare' => 'IN',
       ),
      array(
          'key' => 'g2c2-event_date',
          'value' => date('Ymd'),
          'compare' =>  '<',
          'type' => 'DATE'
       )      
   )
 );
$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
?>
  <li>
    <a class="event-link id-<?php the_ID(); ?>" href="#<?php the_ID(); ?>">
      <h3 class="events-entry-title"><?php the_title(); ?></h3>
      <p class="events-entry-shortdesc"><?php the_field('g2c2-event_shortDescription'); ?></p>
    </a>
  </li>  

<?php endwhile; else : ?>
  <em style="color: #808080;">No events</em>
<?php endif; ?>

</ul>
</section> <!--/events-list -->

<section class="events-content col-xs-7">

<article id="placeholder">
  Select an item to view details...
</article>


      <?php
$args = array(
  'post_type' => 'event',
  'meta_query' => array(
      array(
          'key' => 'g2c2-event_type',
          'value' => 'Networking',
          'compare' => 'IN',
          )
      )
);
$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
?>

  <article id="<?php the_ID(); ?>">
      <h2><?php the_title(); ?></h2>
      <div class="events-entry-date">
        <?php 
          $ed = DateTime::createFromFormat('Ymd', get_field('g2c2-event_date'));
          echo $ed->format('j F Y');
        ?>
      </div>
      <?php the_content(); ?>
      <div class="blog-comments" ><?php $withcomments = "1"; comments_template(); ?> </div>
  </article>    

<?php endwhile; else : ?>
  <em style="color: #808080;">No events</em>
<?php endif; ?>



</section><!-- /events-content -->


</div> <!-- container -->

<div class="footer col-xs-12">
<p>Copyright &copy; 2014 <a href="http://www.greenchemistrynetwork.org" target="_blank">Green Chemistry Network</a>.</p>
<p class="small">Developed by <a href="http://www.willsoutter.co.uk" target="_blank">Will Soutter</a>. Powered by WordPress. G2C2 and the Green Chemistry Network are not responsible for the content of external websites linked from this site.</p>
</div>



<script type="text/JavaScript">
head.ready(function() {
  if (window.location.hash) {
    var hash = window.location.hash;
    var hashclass = 'id-' + hash.substring(1);
    $('a.' + hashclass).addClass('selected');
    $('article:target').fadeIn(250);
  } else {
    $('#placeholder').fadeIn(250);
  }


  $(window).hashchange(function(){
    $('.events-content article').hide(0,function() {
          $('article:target').fadeIn(250);
    });
  });

  $('a.event-link').click(function() {
    $('a.event-link').removeClass('selected');
    $(this).addClass('selected');
  });

});

</script>
</body>
</html>