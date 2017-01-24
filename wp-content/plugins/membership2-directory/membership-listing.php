<?php
/*
Plugin Name: Membership Directory
Description: Lists all active memberhips (extends Membership2 plugin)
Author: Rick Taylor
Version: 0.0.1
License: GPL2
Text Domain: simple-membership-directory

Copyright 2016  Rick Taylor  (email: richtbiscuit@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! class_exists( 'Simple_Membership_Directory' ) ) {

	class Simple_Membership_Directory {

		/* 
		 * variables 
		 */
		public $plugin_path;
		public $template_url;
		public $allowed_search_vars;
		protected $api = null;
		private $members = array();
		private $memberships = array();
		private $member_ids = array();
		private static $page_title = "Membership directory";
		private static $page_name = "membership-directory";
		private static $page_query_var_prefix = "members-directory";

		// Function is always executed. Will create 1 Implementation object.
		static public function setup() {
    		static $Inst = null;
    		if ( null === $Inst ) {
        			$Inst = new Simple_Membership_Directory();
    		}
    		return $Inst;
		}

		private function get_memberships() {
			if( empty( $this->memberships ) ) {
				$memberships = $this->api->list_memberships();
				foreach ( $memberships as $membership ) {
					$this->memberships[$membership->id] = $membership;
				}
			}
			return $this->memberships;
		}

		private function get_members() {
			if( empty( $this->members ) ) {
				$memberships = $this->get_memberships();
				foreach ( $memberships as $membership_id=>$membership ) {
					$this->members[$membership_id] = array();
					$subs = $membership->get_subscriptions();
					$i = 0;
					foreach ( $subs as $sub ) {
						if ( $sub->status == MS_Model_Relationship::STATUS_ACTIVE ) {
							$member = $sub->get_member();
							#if ( $member->is_normal_user() ) {
								// the user listing loop
								$user = $member->get_user();
								$uid = $user->ID;
								#print $uid;
								#print $membership_id;
								$user->counter = ++$i;
								#print "<br />";
								$this->members[$membership_id][$uid] = $user;
							#}
						}
					}
				}
			}
			return $this->members;
		}

		// Function set up the api hook.
		private function __construct() {

    		add_action( 'ms_init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

		}

    	// Function is only run when Membership2 is present + active.
   		public function init( $api ) {
    		$this->api = $api;
    		// The main init code should come here now!
    		add_shortcode( 'membershipdirectory', array( $this, 'shortcode_callback' ) );
    		add_filter( 'body_class', array( $this, 'body_class' ) );
    		wp_register_style( 'membershipdirectory', plugins_url( '/static/css/styles.css', __FILE__ ) );
    		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
    		//add_filter( 'query_vars', array( $this, 'load_query_vars' ) );
    		add_filter( 'the_content', array( $this, 'content_filter' ) );
    		add_filter( 'query_vars', array( $this, 'query_vars' ) );
    		add_filter( 'generate_rewrite_rules', array( $this, 'custom_endpoint') );
    		add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allow_paras' ) ); 
    		//self::add_rewrite_rules();
    	}

    	static public function add_rewrite_rules() {
    		add_rewrite_rule( '^'.self::$page_name.'/profile/(.+?)/?$',
			  	'index.php?pagename='.self::$page_name.'&'.self::$page_query_var_prefix.'-user-login=$matches[1]' );
    	}

		function query_vars( $query_vars ) {
		    $query_vars[] = self::$page_query_var_prefix.'-user-login';
		    return $query_vars;
		}


    	function content_filter($content) {
    		$post_name = $GLOBALS['post']->post_name;
			$member_login = get_query_var(self::$page_query_var_prefix."-user-login");
			if($member_login) {
				//return $member_id;
				return $this->get_detail_html($member_login);
			}
			if ($post_name == self::$page_name) {
			    return $this->get_directory_html();
			}
			// otherwise returns the database content
  			return $content;
		}
		/**
    	function load_query_vars($vars) {
    		if( isset($vars['members-directory-user-id']) && is_numeric($vars['members-directory-user-id']) ) {
    			$id = $vars['members-directory-user-id'];
    			$user_data = get_userdata( $user->ID );
	    		$vars["member-logo"] = xprofile_get_field_data("Logo", $id);
	    		$vars["member-organisation"] = xprofile_get_field_data("Organisation name", $id);
	    		$vars["member-description"] = xprofile_get_field_data("Description", $id);
	    		$vars["member-description-image"] = xprofile_get_field_data("Photo", $id); 
	    		$vars["member-contact-name"] = $user_data->display_name; 
	    		$vars["member-contact-email"] = $user_data->email;
	    	}
	    	return $vars;
    	}
    	**/

    	function enqueue_styles() {
    		wp_enqueue_style( 'membershipdirectory' );
    	}

    	// Add other event handlers and helper functions.
    	// You can use $this->api in other functions to access the API object.


		/**
		 * Make plugin ready for translation
		 *
		 * @access public
		 * @since 1.0
		 * @return none
		 */
		function load_text_domain() {
			load_plugin_textdomain( 'simple-membership-directory', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
		}

		/**
		 * Get the plugin path.
		 *
		 * @access public
		 * @since 1.0
		 * @return string
		 */
		function plugin_path() {
			if ( $this->plugin_path ) return $this->plugin_path;

			return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get the template url
		 * @access public
		 * @since 1.3
		 * @return string
		 */
		function template_url() {
			if ( $this->template_url ) return $this->template_url;

			return $this->template_url = trailingslashit( apply_filters( 'smd_template_url', 'simple-membership-directory' ) );
		}

		/**
		 * Add body class
		 *
		 * @access public
		 * @since 1.0
		 * @param  array $c all generated WordPress body classes
		 * @return array
		 */
		function body_class( $c ) {
		    if( is_user_listing() ) {
		        $c[] = 'membershipdirectory';
		    }
		    return $c;
		}

		function get_detail_html( $login ) {
			global $member_info;
			$member_info = new StdClass();
			
			$user_data = get_user_by("login", $login );
			
			$id = $user_data->ID;
			$member_info->description = wpautop(xprofile_get_field_data("Description", $id));
			$image = content_url(xprofile_get_field_data("Photo", $id)); 
			$member_info->description_image_src = $image;
			$member_info->organisation = xprofile_get_field_data("Organisation name", $id);
			$member_info->job_role = xprofile_get_field_data("Role", $id);
			$member_info->display_name = $user_data->display_name; 
			$member_info->location = xprofile_get_field_data("Location", $id);
			$member_info->email = $user_data->user_email;
			ob_start();
			smd_get_template_part( 'content', 'memberdetail' );
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}

		function filter_wp_kses_allow_paras( $allowed_html ) { 
            if ( ! isset( $allowed_html[ "p" ] ) ) { 
                $allowed_html[ "p" ] = array(); 
            } 
            $allowed_html[ "p" ] = array_merge( 
                $allowed_html[ "p" ],  
                array_fill_keys( array( 
                  'style',  
                  'class',  
 				), true ) 
			); 
		    return $allowed_html; 
		}

		/**
		 * Callback for the shortcode
		 *
		 * @access public
		 * @since 1.0
		 * @param  array $atts shortcode attributes
		 * @param  string $content shortcode content, null for this shortcode
		 * @return string
		 */
		function shortcode_callback( $atts, $content = null ) {
			return $this->get_directory_html();
		}

		function get_directory_html() {
			global $user, $membership;
			$members = $this->get_members();
			$memberships = $this->get_memberships();
			
			$raw_memberships = $memberships;
			$memberships = apply_filters( 'smd_memberships', $memberships, $members);
			
			$members = apply_filters( 'smd_members', $members, $memberships, $raw_memberships);
			$memberships_order = array_keys($memberships);
			$memberships_order = apply_filters( 'smd_memberships_order', $memberships_order, $memberships);
			ob_start();
			foreach ( $memberships_order as $ship_id ) {
				$membership = $memberships[$ship_id];
				
				$users = $members[$ship_id];
				
				smd_get_template_part( 'header', 'membership' );
				if ( empty( $users ) ) {
					smd_get_template_part( 'none', 'author' );
				} else {
					foreach ( $users as $user ) {
						smd_get_template_part( 'content', 'author' );					
					}
				}
				smd_get_template_part( 'footer', 'membership' );
			}
			// Output the content.
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}

		static function install() {

		    global $wpdb;

		    // the menu entry...
		    delete_option("member_directory_page_title");
		    add_option("member_directory_page_title", self::$page_title, '', 'yes');
		    // the slug...
		    delete_option("member_directory_page_name");
		    add_option("member_directory_page_name", self::$page_name, '', 'yes');
		    // the id...
		    delete_option("member_directory_page_id");
		    add_option("member_directory_page_id", '0', '', 'yes');

		    $the_page = get_page_by_title( self::$page_title );

		    if ( ! $the_page ) {
		        // Create post object
		        $_p = array();
		        $_p['post_title'] = self::$page_title;
		        $_p['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
		        $_p['post_status'] = 'publish';
		        $_p['post_type'] = 'page';
		        $_p['comment_status'] = 'closed';
		        $_p['ping_status'] = 'closed';
		        $_p['post_category'] = array(1); 
		        // Insert the post into the database
		        $the_page_id = wp_insert_post( $_p );
		    } else {
		        // the plugin may have been previously active and the page may just be trashed...

		        $the_page_id = $the_page->ID;

		        //make sure the page is not trashed...
		        $the_page->post_status = 'publish';
		        $the_page_id = wp_update_post( $the_page );

		    }

		    delete_option( 'member_directory_page_id' );
		    add_option( 'member_directory_page_id', $the_page_id );
		    self::add_rewrite_rules();
		    flush_rewrite_rules();
		}

		static function remove() {

		    global $wpdb;

		    $the_page_title = get_option( "member_directory_page_title" );
		    $the_page_name = get_option( "member_directory_page_name" );

		    //  the id of our page...
		    $the_page_id = get_option( 'member_directory_page_id' );
		    if( $the_page_id ) {

		        wp_delete_post( $the_page_id ); // this will trash, not delete

		    }

		    delete_option("member_directory_page_title");
		    delete_option("member_directory_page_name");
		    delete_option("member_directory_page_id");
		    flush_rewrite_rules();
		}

	}
}

Simple_Membership_Directory::setup();



/**
 * Get template part
 *
 * @access public
 * @since 1.0
 * @param mixed $slug
 * @param string $name (default: '')
 * @return null
 */
function smd_get_template_part( $slug, $name = '' ) {
	$smd = Simple_Membership_Directory::setup();
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/simple-user-listing/slug-name.php
	if ( $name ){
		$template = locate_template( array ( "{$slug}-{$name}.php", "{$smd->template_url()}{$slug}-{$name}.php" ) );
	}
	
	if ( !$template && $name && file_exists( $smd->plugin_path() . "/templates/{$slug}-{$name}.php" ) ){
		$template = $smd->plugin_path() . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/simple_user_listing/slug.php
	if ( !$template ){
		$template = locate_template( array ( "{$slug}.php", "{$smd->template_url()}{$slug}.php" ) );
	}

	if ( $template ){
		load_template( $template, false );
	}


}

/**
 * Is membership directory post/page?
 * Won't be true on archives
 *
 * @access public
 * @since 1.0
 * @return boolean
 */
function is_membership_directory() {
	global $post;

	$listing = false;

	if( is_singular() && isset($post->post_content) && has_shortcode( $post->post_content, 'membershipdirectory' ) ) {
		$listing = true;
	}

	return apply_filters( 'smd_is_membership_directory', $listing );
}


register_activation_hook(__FILE__, array( 'Simple_Membership_Directory', 'install') ); 
register_deactivation_hook(__FILE__, array( 'Simple_Membership_Directory', 'remove') ); 

