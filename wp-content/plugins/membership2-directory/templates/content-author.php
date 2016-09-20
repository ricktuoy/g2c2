<?php
/**
 * The Template for displaying Author listings
 *
 * Override this template by copying it to yourtheme/authors/content-author.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $user;

$user_info = get_userdata( $user->ID );
$num_posts = count_user_posts( $user->ID );
?>
<li id="user-<?php echo $user->ID; ?>" class="author-block">
	<?php echo get_avatar( $user->ID, 90 ); ?>

<a href="<?php echo get_edit_user_link($user->ID); ?>"><?php echo $user_info->display_name;?></a>
	
	</li>

</div>