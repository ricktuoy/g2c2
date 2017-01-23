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
	<?php $logo = content_url(xprofile_get_field_data( 'Logo', $user->ID)); ?>
	<?php if($logo && $logo != content_url()): ?>
	
	<img src="<?php echo $logo; ?>" class="logo" alt="Logo: "<?php echo xprofile_get_field_data( 'Organisation name', $user->ID); ?> />
	<?php else: ?>
	-
	<?php endif; ?>
	</td>
	<td>
	<a href="/membership-directory/profile/<?php echo $user->user_login; ?>"><?php echo $user_info->display_name; ?></a>
	</td>
	<td>
		<a href="<?php echo xprofile_get_field_data( 'Website address', $user->ID); ?>" target="_blank">
			<?php echo xprofile_get_field_data( 'Organisation name', $user->ID); ?>
		</a>
	</td>
	<td>
	<?php 
		$interests = xprofile_get_field_data( 'Research interests', $user->ID);
		if($interests) {
			echo "<ul>";
			foreach( xprofile_get_field_data( 'Research interests', $user->ID) as $interest ) {
				echo "<li>".$interest."</li>";
			} 
			echo "</ul>";
		} else {
			echo "-";
		}
	?>
	</td>
</tr>