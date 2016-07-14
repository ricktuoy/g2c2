<?php 
global $more;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2</title>

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
.footer {position: static}
.featured-event img {max-width: 100% !important; height: auto !important}
</style>
  </head>

  <body>

<?php $g2c2_navactiveselect = "1"; get_template_part('g2c2-nav'); ?>

<div class="container" style="margin-top: 64px">

<section class="twitter-container col-xs-3">
<a class="twitter-timeline"  href="https://twitter.com/globalgreenchem"  data-widget-id="442038816463806464">Tweets by @globalgreenchem</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
     
</section> <!-- twitter container -->

<section class="blog-main col-xs-6">
  <h1>Latest updates</h1>

      <?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
      $more = 1;
      ?>

<article class="blog-post">  
            <h2 class="blog-post-title"><?php the_title(); ?></h2>
            <p class="blog-post-meta"><?php the_date(); ?> by <?php the_author(); ?></p>
            <?php the_content(); ?>
            <div class="blog-comments" ><?php $withcomments = "1"; comments_template(); ?> </div>

          </article>

<?php endwhile; else: 
  theme_404_content();
  endif; 
  ?>

</section> <!--/blog-main -->


<section class="agenda-container col-xs-3">
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
  
    <a class="featured-event" href="<?php echo site_url(); ?>/g2c2_networking_conferences/#/#<?php the_ID();?>">
      <?php 
        $image = wp_get_attachment_image( get_post_meta( get_the_ID(), 'g2c2-event_advert',true ), 'full' ); 
        echo $image;
        ?>  
    </a>


<?php
endwhile;
      } 
      ?>

<?php get_template_part('g2c2-networkingwidget'); ?>
<?php get_template_part('g2c2-fundingwidget'); ?>
</section> <!-- agenda container -->


</div> <!-- container -->

<div class="footer col-xs-12">
    <p>Copyright (c) 2009 Green Chemistry Network: Company Limited by Guarantee, registered in England and Wales, No: 6879262</p>
    <p class="small">The GCN aims to provide accurate information on this website. However the GCN accepts no liability for errors and/or omissions and is not responsible for the content of external websites linked from this site.</p>
</div>

<script type="text/javascript">
head.load(
  "<?php echo get_bloginfo('template_directory');?>/g2c2-js/jquery-1.10.2.js",
  "<?php echo get_bloginfo('template_directory');?>/g2c2-js/bootstrap.min.js",
);
</script>


</body>
</html>