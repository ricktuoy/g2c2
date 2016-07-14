<?php

function g2c2_2016_enqueue_style() {
	wp_enqueue_style( 'gfont-catamaran','https://fonts.googleapis.com/css?family=Catamaran:300,700', false);
    if ( is_child_theme() ) {
        // load parent stylesheet first if this is a child theme
	wp_enqueue_style( 'parent-stylesheet', trailingslashit( get_template_directory_uri() ) . 'style.css', false );
    }
    // load active theme stylesheet in both cases
    wp_enqueue_style( 'theme-stylesheet', get_stylesheet_uri(), false );
}

function g2c2_2016_static_url($path) {
    bloginfo('template_url');
    echo "/static/".$path;
}

function g2c2_2016_register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
    )
  );
}
add_action( 'init', 'g2c2_2016_register_my_menus' );

function g2c2_2016_setup_theme_admin_menus() {
    // We will write the function contents very soon.
	add_menu_page('Theme settings', 'G2C2 2016 theme',
		'manage_options','g2c2_2016_theme_settings',
		'theme_settings_page');
    add_submenu_page('g2c2_2016_theme_settings', 
        'Header Elements', 'Header', 'manage_options', 
        'g2c2_2016_theme_settings', 'theme_header_settings'); 
}
 
// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "g2c2_2016_setup_theme_admin_menus");

add_action( 'wp_enqueue_scripts', 'g2c2_2016_enqueue_style' );


add_filter( 'wp_nav_menu_header-menu_items','g2c2_2016_loginout_menu_link' );

function g2c2_2016_loginout_menu_link( $menu ) {
    $loginout = "<li class=\"loginout\">".wp_loginout($_SERVER['REQUEST_URI'], false )."</li>";
    
    $menu .= $loginout;
    return $menu;
}

function g2c2_2016_add_query_vars_filter( $vars ){
  $vars[] = "membership_id";
  return $vars;
}
add_filter( 'query_vars', 'g2c2_2016_add_query_vars_filter' );

?>