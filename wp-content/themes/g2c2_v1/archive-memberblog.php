<?php

/**
 *
 * archive-memberblog.php
 *
 * The archive template. Used when a list of posts is queried.
 * 
 */
if ( is_user_logged_in() ) :
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>

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
  </head>

  <body class="members-blogpost">

<?php get_template_part('g2c2-nav'); ?>

<div class="container" style="margin-top: 60px">

    <ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>/?page_id=22">Back to members homepage</a></li>
    </ul>

<section class="blog-container col-xs-12">

    <header style="margin-top: 0;" class="section-header col-xs-12">
      <h1>Members' Blog</h1>
    </header>

  <?php
      $args = array( 
        'post_type' => 'memberblog',
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



</section>
</div>

<div class="footer col-xs-12">
    <p>Copyright (c) 2009 Green Chemistry Network: Company Limited by Guarantee, registered in England and Wales, No: 6879262</p>
    <p class="small">The GCN aims to provide accurate information on this website. However the GCN accepts no liability for errors and/or omissions and is not responsible for the content of external websites linked from this site.</p>
</div>

</body>
</html>
<?php
else :
  $rdurl = wp_login_url( get_permalink() );
  header("Location: ".$rdurl);
  die();
endif;
?>
