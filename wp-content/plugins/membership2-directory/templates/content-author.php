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
<tr id="user-<?php echo $user->ID; ?>" class="author-block">
	<td>
	<img src="<?php echo content_url(xprofile_get_field_data( 'Logo', $user->ID)); ?>" class="logo" alt="Logo: "<?php echo xprofile_get_field_data( 'Organisation name', $user->ID); ?> />
	</td>
	<td>
	<a href="<?php echo bp_core_get_user_domain($user->ID); ?>"><?php echo $user_info->display_name; ?></a>
	</td>
	<td>
		<a href="<?php echo xprofile_get_field_data( 'Website address', $user->ID); ?>" target="_blank">
			<?php echo xprofile_get_field_data( 'Organisation name', $user->ID); ?>
		</a>
	</td>
	<td>
	<ul>
	<?php 
	foreach(xprofile_get_field_data( 'Research interests', $user->ID) as $interest) {
		echo "<li>".$interest."</li>";
	} 
	?>
	</ul>
	</td>
</tr>