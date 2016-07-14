<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<?php if(is_page('sign-up') && get_query_var("membership_id")): ?>
<article class="about">
<h1 class="entry-title">
Signing up for <strong><?php echo do_shortcode("[ms-membership-title id=\"".get_query_var("membership_id")."\" label=\"\"]"); ?></strong>
</h1>
<p>Annual fee: &pound;<?php echo do_shortcode("[ms-membership-price id=\"".get_query_var("membership_id")."\" label=\"\"]"); ?></p>

</article>
<?php elseif(get_field("banner_content")): ?>
<article class="about">
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php the_field('banner_content'); ?>
</article>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<header class="entry-header">
		
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'g2c2_2016' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'g2c2_2016' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php edit_post_link( __( 'Edit', 'g2c2_2016' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
