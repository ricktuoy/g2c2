<?php
/*
Plugin Name: G2C2 Custom Post Types
Description: Custom Post Types for the G2C2 members site.
Author: Green Chemistry Network
Author URI: http://www.greenchemistrynetwork.org
*/
defined('ABSPATH') or die("No script kiddies please!");

add_action( 'init', 'g2c2_cpt' );

function g2c2_cpt() {
//Create custom post types

register_post_type( 'memberblog', array(
  'labels' => array(
    'name' => 'Members Blog',
    'singular_name' => 'Members Blog Post',
   ),
  'description' => 'Blog posts only visible in the members area',
  'public' => true,
  'has_archive' => true,
  'supports' => array( 'title', 'editor', 'custom-fields',  'author', 'comments' )
));

register_post_type( 'event', array(
  'labels' => array(
    'name' => 'Events',
    'singular_name' => 'Event',
   ),
  'description' => 'Dated listings of networking events or funding.',
  'public' => true,
  'has_archive' => false,
  'supports' => array( 'title', 'editor', 'custom-fields', 'author', 'comments' )
));

register_post_type( 'resource', array(
  'labels' => array(
    'name' => 'Educational Resources',
    'singular_name' => 'Educational Resource',
   ),
  'description' => 'Links to external resources for Green Chemistry education and outreach',
  'public' => true,
  'has_archive' => false,
  'supports' => array( 'title', 'editor', 'custom-fields', 'comments' )
));

register_post_type( 'feature', array(
  'labels' => array(
    'name' => 'Homepage Features',
    'singular_name' => 'Homepage Feature',
   ),
  'description' => 'Linked hero images for the public homepage',
  'public' => true,
  'has_archive' => false,
  'supports' => array( 'title', 'custom-fields' )
));

//   If "Post Type Icons" is installed, set the icons.
//   http://boyn.es/category/post-type-icons/

if(function_exists("pti_set_post_type_icon")) {
  pti_set_post_type_icon( 'event' , 'calendar-o' );
  pti_set_post_type_icon( 'resource' , 'book' );
  pti_set_post_type_icon( 'feature' , 'newspaper-o' );
  pti_set_post_type_icon( 'memberblog' , 'lock' );
}

//   If "Advanced Custom Fields" is installed, define the fieldsets for the custom post types.
//   http://www.advancedcustomfields.com/

if(function_exists("register_field_group"))
{
  register_field_group(array (
    'id' => 'acf_events',
    'title' => 'events',
    'fields' => array (
      array (
        'key' => 'field_53b1c6aa0e2aa',
        'label' => 'Instructions - Networking Events',
        'name' => '',
        'type' => 'message',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_53b1c3f59f194',
              'operator' => '==',
              'value' => 'Networking',
            ),
          ),
          'allorany' => 'all',
        ),
        'message' => 'Enter full description of event in the WYSIWYG editor below, including any images or links. Titles for networking/conference events should include the event date.',
      ),
      array (
        'key' => 'field_53b1c786468e5',
        'label' => 'Instructions - Funding Opportunities',
        'name' => '',
        'type' => 'message',
        'instructions' => 'Enter full description of event in the WYSIWYG editor, including any images or links. Titles for networking/conference events should include the event date.',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_53b1c3f59f194',
              'operator' => '==',
              'value' => 'Funding',
            ),
          ),
          'allorany' => 'all',
        ),
        'message' => 'Enter full description of funding opportunity in the WYSIWYG editor below, including any images or links.',
      ),
      array (
        'key' => 'field_53b1c3f59f194',
        'label' => 'Type',
        'name' => 'g2c2-event_type',
        'type' => 'select',
        'instructions' => 'Type of event. "Networking" events will show on the Networking & Conferences page. "Funding" events will show on the Funding Opportunities page.',
        'required' => 1,
        'choices' => array (
          'Networking' => 'Networking',
          'Funding' => 'Funding',
        ),
        'default_value' => '',
        'allow_null' => 0,
        'multiple' => 0,
      ),
      array (
        'key' => 'field_53b1c4769f195',
        'label' => 'Event date',
        'name' => 'g2c2-event_date',
        'type' => 'date_picker',
        'instructions' => 'Start date of the conference/event, or deadline of the funding opportunity.',
        'required' => 0,
        'date_format' => 'yymmdd',
        'display_format' => 'dd/mm/yy',
        'first_day' => 1,
      ),
      array (
        'key' => 'field_53b1c4e49f196',
        'label' => 'Calendar widget text',
        'name' => 'g2c2-event_widgetText',
        'type' => 'text',
        'instructions' => 'Short description to appear in the calendar widget on homepage and relevant page.',
        'required' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => 50,
      ),
      array (
        'key' => 'field_g2c2_event_url',
        'label' => 'Registration URL',
        'name' => 'g2c2-event_registrationURL',
        'type' => 'text',
        'instructions' => 'URL of page to register for the event (e.g. SurveyMonkey)',
        'required' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => 250,
      ),
      array (
        'key' => 'field_53b1c5689f197',
        'label' => 'Short description',
        'name' => 'g2c2-event_shortDescription',
        'type' => 'text',
        'instructions' => 'Single sentence for minimized view on relevant page.',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => 140,
      ),
      array (
        'key' => 'field_53b30c967151f',
        'label' => 'Featured',
        'name' => 'g2c2-event_featured',
        'type' => 'true_false',
        'instructions' => 'Select to display an advert on the relevant events page.',
        'required' => 0,
        'message' => '',
        'default_value' => 0,
      ),
      array (
        'key' => 'field_53b30cce95868',
        'label' => 'Advert',
        'name' => 'g2c2-event_advert',
        'type' => 'image',
        'instructions' => 'Upload the advert image for the event.',
        'conditional_logic' => array (
          'status' => 1,
          'rules' => array (
            array (
              'field' => 'field_53b30c967151f',
              'operator' => '==',
              'value' => '1',
            ),
          ),
          'allorany' => 'all',
        ),
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'event',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'acf_after_title',
      'layout' => 'no_box',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'custom_fields',
        2 => 'featured_image',
        3 => 'categories',
        4 => 'tags',
      ),
    ),
    'menu_order' => 0,
  ));
  register_field_group(array (
    'id' => 'acf_resources',
    'title' => 'resources',
    'fields' => array (
      array (
        'key' => 'field_53b1c86fa38ea',
        'label' => 'Type',
        'name' => 'g2c2-resource_type',
        'type' => 'select',
        'instructions' => 'Type of resource',
        'required' => 1,
        'choices' => array (
          'Online resource' => 'Online resource',
          'University course' => 'University course',
        ),
        'default_value' => 'Online resource',
        'allow_null' => 0,
        'multiple' => 0,
      ),
      array (
        'key' => 'field_53b1c80aa38e9',
        'label' => 'Description',
        'name' => 'g2c2-resource_description',
        'type' => 'text',
        'instructions' => 'Short description of the resource.',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => 100,
      ),
      array (
        'key' => 'field_53b1c89da38eb',
        'label' => 'Link',
        'name' => 'g2c2-resource_link',
        'type' => 'text',
        'instructions' => 'Link to external resource, including http://',
        'required' => 1,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_53b1c8c1a38ec',
        'label' => 'Image',
        'name' => 'g2c2-resource_image',
        'type' => 'image',
        'instructions' => 'Upload an image to illustrate the resource. Minimum size 360px wide, 170px high.',
        'required' => 1,
        'save_format' => 'url',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'resource',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'acf_after_title',
      'layout' => 'no_box',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'the_content',
        2 => 'excerpt',
        3 => 'custom_fields',
        4 => 'comments',
        5 => 'revisions',
        6 => 'slug',
        7 => 'author',
        8 => 'format',
        9 => 'featured_image',
        10 => 'categories',
        11 => 'tags',
        12 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
}

  // Customize login page
  function my_login_logo_url() {
    return home_url();
  }
  add_filter( 'login_headerurl', 'my_login_logo_url' );

  function my_login_logo_url_title() {
    return 'Green Chemistry Network';
  }
  add_filter( 'login_headertitle', 'my_login_logo_url_title' );

  // Add custom login styles
  function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/g2c2-login.css' );
  }
  add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

}
