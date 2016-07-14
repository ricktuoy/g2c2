<?php

get_header(); ?>

<div class="container" style="margin-top: 60px">

    <ul class="breadcrumb" style="margin-bottom: 0;">
    <li><a href="<?php echo site_url(); ?>">Back to homepage</a></li>
    </ul>

<section class="blog-container col-xs-12">

    <header style="margin-top: 0;" class="section-header col-xs-12">
      <h1>News Archive</h1>
    </header>

  <?php
      $args = array( 
        'post_type' => 'post',
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
<p>Copyright &copy; 2014 <a href="http://www.greenchemistrynetwork.org" target="_blank">Green Chemistry Network</a>.</p>
<p class="small">Developed by <a href="http://www.willsoutter.co.uk" target="_blank">Will Soutter</a>. Powered by WordPress. G2C2 and the Green Chemistry Network are not responsible for the content of external websites linked from this site.</p>
</div>

</body>
</html>



