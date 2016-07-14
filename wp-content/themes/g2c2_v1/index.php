<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>G2C2 :: <?php the_title(); ?></title>

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
  </head>

  <body>

<?php get_template_part('g2c2-nav'); ?>

<div class="container" style="margin-top: 64px">

<section class="col-xs-3">
<br /> 
</section> <!-- twitter container -->

<section class="blog-main col-xs-6">

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
  "<?php echo get_bloginfo('template_directory');?>/js/jquery-1.10.2.js",
  "<?php echo get_bloginfo('template_directory');?>/js/bootstrap.min.js",
);
</script>


</body>
</html>