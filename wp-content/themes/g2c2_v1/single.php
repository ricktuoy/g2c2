<?php

/**
 *
 * single.php
 *
 * The single post template. Used when a single post is queried.
 * 
 */


get_header(); ?>

<div class="container" style="margin-top: 60px">

    <ul class="breadcrumb">
    <li><a href="<?php echo site_url(); ?>">Back to homepage</a></li>
    </ul>

<section class="blog-container col-xs-12">

      <?php
      if ( have_posts() ) : while ( have_posts() ) : the_post();
      $more = 1;
      ?>

<article class="blog-post">  
            <h2 class="blog-post-title"><?php the_title(); ?></h2>
            <p class="blog-post-meta"><?php the_date(); ?> by <?php the_author(); ?></p>
            <?php the_content(); ?>
        </article>
            <div class="blog-comments" ><?php $withcomments = "1"; comments_template(); ?> </div>

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




