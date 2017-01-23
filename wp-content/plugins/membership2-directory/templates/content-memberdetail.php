<?php
/**
 * The Template for displaying details of a member
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $member_info;

?>
<div class="member-detail">
	
		<h1><?php echo $member_info->organisation; ?></h1>
		<?php if($member_info->description_image_src): ?>
		<img src="<?php echo $member_info->description_image_src; ?>" class="detail" alt="<?php echo $member_info->organisation; ?>" />
		<?php endif; ?>
		<div class="description">
		<?php echo $member_info->description; ?>
		</div>
		<h3>Contact person</h3>
		<?php echo $member_info->display_name; ?>: <a href="mailto:<?php echo $member_info->email; ?>"><?php echo $member_info->email; ?></a>
		<h3>Location</h3>
		<?php echo $member_info->location; ?>
	
</div>