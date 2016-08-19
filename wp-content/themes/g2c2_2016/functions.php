<?php

class CSS_Menu_Walker extends Walker {

  var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
  
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul>\n";
  }
  
  function end_lvl(&$output, $depth = 0, $args = array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }
  
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
  
    global $wp_query;
    $indent = ($depth) ? str_repeat("\t", $depth) : '';
    $class_names = $value = '';
    $classes = empty($item->classes) ? array() : (array) $item->classes;
    
    /* Add active class */
    if (in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }
    
    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }
    
    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
    
    $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
    $id = $id ? ' id="' . esc_attr($id) . '"' : '';
    
    $output .= $indent . '<li' . $id . $value . $class_names .'>';
    
    $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
    $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
    $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
    $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
    
    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;
    
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
  
  function end_el(&$output, $item, $depth = 0, $args = array()) {
    $output .= "</li>\n";
  }
}

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

function g2c2_2016_memberships_filter( $memberships, $members ) {
  $corp = (object) array('name' => 'Corporate members');
  $research = (object) array('name' => 'Research members and associates');
  return array('corporate'=>$corp, 'research'=> $research);
}

function g2c2_2016_members_filter( $members, $memberships, $raw_memberships ) {
  $out_members = array();
  foreach ( $members as $m_id=>$users ) {
    $m_type = $raw_memberships[$m_id]->name;

    if ( strpos( "Corporate", $m_type ) !== FALSE ) {
      $key = "corporate";
    } elseif ( strpos( "Research", $m_type ) !== FALSE ) {
      $key = "research";
    } else {
      continue;
    }
    if ( !array_key_exists($key, $out_members) ) {
      $out_members[$key] = array();
    }
    $out_members[$key] += $users;
  }
  return $out_members;
}

add_filter( 'smd_memberships', 'g2c2_2016_memberships_filter', null, 2);
add_filter( 'smd_members', 'g2c2_2016_members_filter', null, 3);

function g2c2_2016_add_query_vars_filter( $vars ){
  $vars[] = "membership_id";
  return $vars;
}
add_filter( 'query_vars', 'g2c2_2016_add_query_vars_filter' );



?>