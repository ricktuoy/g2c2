<?php
/**
 * The Template for displaying the header for a membership listing
 *
 * Override this template by copying it to yourtheme/simple-membership-directory/header-membership.php
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $membership;
?>


<table class="membership">
<caption><?php echo $membership->name ?></caption>
<thead>
<tr>
<th>Logo</th>
<th>Contact</th>
<th>Organisation</th>
<th>Research interests</th>
</tr>
</thead>