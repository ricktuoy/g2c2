<!DOCTYPE html>
<html lang="en">
<head>
<title>
G2C2 :: A global network of green chemistry centres
</title>
<link rel="icon" href="<?php g2c2_2016_static_url("favicon.ico"); ?>" type="image/x-icon">
<?php wp_head(); ?>
</head>
<body>
<header class="main">
<img class="g2c2" src="<?php g2c2_2016_static_url("g2c2_logo.png") ?>" alt="G2C2" />
<?php if ( has_nav_menu( 'header-menu' ) ) : ?>
<?php wp_nav_menu( 
	array( 
		'theme_location' => 'header-menu'
	 	) ); ?>
<?php endif; ?>
<img class="gcn" src="<?php g2c2_2016_static_url("gcn_logo.png") ?>" alt="GCN" />
<div class="clear">&nbsp;</div>
</header>