<?php
/*
  Plugin Name: GMW Add-on - Xprofile Fields
  Plugin URI: http://www.geomywp.com
  Description: Integrate Xprofile fields with GEO my WP. let the users of your site add their location in the registration form and add/update it from the "Edit Profile" page.
  Author: Eyal Fitoussi
  Version: 1.3.1
  Author URI: http://www.geomywp.com
  Text Domain: GMW-XF
  Domain Path: /languages/
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) )
    exit;

//load text domain
function gmw_xf_load_textdomain() {
	load_plugin_textdomain( 'GMW-XF', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'gmw_XF_load_textdomain' );

//look for necessary plugins and versions
if ( !class_exists( 'GEO_my_WP' ) || !GEO_my_WP::gmw_check_addon( 'friends' ) || !class_exists( 'BuddyPress' ) || ( class_exists( 'BuddyPress' ) && BP_VERSION < '2.0' ) ) {

	function gmw_xf_deactivated_admin_notice() {

		echo '<div class="error"><p>';	  
		if ( !class_exists( 'GEO_my_WP' ) ) {
			_e( 'Xprofile Fields add-on requires GEO my WP plugin version 2.4 or higher in order to work.', 'GMW-XF' );		 
		} elseif ( !GEO_my_WP::gmw_check_addon( 'friends' ) ) {		
			_e( "Xprofile Fields add-on requires GEO my WP's Members Locator add-on to be activated in order to work.", "GMW-XF" );		
		} elseif ( !class_exists( 'BuddyPress' ) || ( class_exists( 'BuddyPress' ) && BP_VERSION < '2.0' ) ) {
			_e( 'GEO Xprofile Fields add-on requires Buddypress plugin version 2.0 or higher in order to work.', 'GMW-XF' );
		}
		echo '</p></div>';
	}
	return add_action( 'admin_notices', 'gmw_xf_deactivated_admin_notice' );
}

/**
 * GMW_Xprofile_Fields
 */
class GMW_Xprofile_Fields {

   	/**
     * __construct function.
     */
    public function __construct() {
    	
    	define( 'GMW_XF_ITEM_NAME',    'Xprofile Fields' );
    	define( 'GMW_XF_LICENSE_NAME', 'xprofile_fields' );
    	define( 'GMW_XF_VERSION', 	   '1.3.1' 		 	 );
    	define( 'GMW_XF_PATH', 		   untrailingslashit( plugin_dir_path( __FILE__ ) ) );
    	define( 'GMW_XF_URL', 		   untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
    	define( 'GMW_XF_FILE', 		   __FILE__ );
    	
    	$this->gmw_settings = get_option( 'gmw_options' );
    	
    	//include files in admin
    	if ( is_admin() && !defined( 'DOING_AJAX' ) ) {
    		include( 'includes/admin/gmw-xf-admin.php' );
    	}

    	//do some actions
    	add_filter( 'gmw_admin_addons_page', 		array( $this, 'addon_init' 				 		  ) );
    	add_action( 'wp_enqueue_scripts', 			array( $this, 'register_scripts'  		 		  ) );
    	add_action( 'admin_enqueue_scripts', 		array( $this, 'register_scripts'  		 		  ) );
    	add_action( 'gmw_fl_after_location_saved',  array( $this, 'xprofile_location_tab_sync' ), 10, 6 );
    	// add_action( 'bp_init', 					array( $this, 'xf_functions' 						) );
    	
    	if ( class_exists( 'GMW_License' ) ) {
    		new GMW_License( __FILE__, GMW_XF_ITEM_NAME, GMW_XF_LICENSE_NAME, GMW_XF_VERSION, 'Eyal Fitoussi' );
    	}
    	
    	//add Google placess address autocomplete to front and backend
    	if ( isset( $this->gmw_settings['xprofile_fields']['xf_autocomplete'] ) && $this->gmw_settings['xprofile_fields']['xf_use'] == 'single' && !empty( $this->gmw_settings['xprofile_fields']['address_fields']['address'] ) ) {
    		add_action( 'bp_after_profile_field_content', 		 array( $this, 'google_autocomplete' ) );
    		add_filter( 'bp_before_registration_submit_buttons', array( $this, 'google_autocomplete' ) );
    	}
    	
    	//action for frontend only
    	if ( !is_admin() ) {
    		//remove locaiton tab or display a map if needed
    		if ( is_user_logged_in() && isset( $this->gmw_settings['xprofile_fields']['my_location_tab'] ) ) {
    	
    			if ( $this->gmw_settings['xprofile_fields']['my_location_tab'] == 'disabled' ) {
    				bp_core_remove_nav_item('location');
    				add_filter( 'gmw_fl_setup_admin_bar', '__return_false', 10 );
    			} elseif ( $this->gmw_settings['xprofile_fields']['my_location_tab'] == 'map' ) {
    				add_filter( 'gmw_fl_location_tab_mine', '__return_false' );
    			}
    		}
    	}
    	
    	self::functions();	
    }

    /**
     * Include addon function.
     *
     * @access public
     * @return $addons
     */
    public function addon_init( $addons ) {

    	$addons[GMW_XF_LICENSE_NAME] = array(
    			'name'    	=> GMW_XF_LICENSE_NAME,
    			'title'   	=> __( ' GEO Xprofile Fields', 'GMW-XF' ),
    			'version' 	=> GMW_XF_VERSION,
    			'item'	  	=> GMW_XF_ITEM_NAME,
    			'file' 	  	=> GMW_XF_FILE,
    			'author'  	=> 'Eyal Fitoussi',
    			'desc'   	=> __( 'Integrate Xprofile fields with GEO my WP. let the users of your site add a location during registration and add/update the location from the "Edit Profile" page.', 'GMW-XF' ),
    			'license' 	=> true,
    			'image'  	=> ( GMW_VERSION < '2.5' ) ? 'http://geomywp.com/wp-content/uploads/addons-images/xprofile_fields.png' : true,
    			'require' 	=> array(
    					'Buddypress Plugin' => array(
    							'plugin_file' => 'buddypress/bp-loader.php',
    							'link' 		  => 'http://buddypress.org',
    							'version'	  => '2.0'
    					),
    			),
    	);
    	return $addons;
    }
       
    /**
     * Add address autocomplete for GEO my WP 2.5
     * @version 1.0
     * @author Eyal Fitoussi
     */
    public function google_autocomplete( $fields ) {
    	wp_enqueue_script(  'gmw-xf-autocomplete' );
    	wp_localize_script( 'gmw-xf-autocomplete', 'autoComp', 'field_'.$this->gmw_settings['xprofile_fields']['address_fields']['address'] );
    }
    
    /**
     * register scripts function.
     *
     * @access public
     * @return void
     */
    public function register_scripts() {
    	 
    	wp_register_script( 'gmw-xf-autofill', 	   GMW_XF_URL . '/assets/js/autofill.min.js', array( 'jquery' ), GMW_XF_VERSION, true );
    	wp_register_script( 'gmw-xf-autocomplete', GMW_XF_URL . '/assets/js/autocomplete.js', array( 'jquery' ), GMW_XF_VERSION, true );

    	if ( is_admin() && !empty( $_GET['page'] ) && $_GET['page'] == 'bp-profile-edit' ) {
    		     		 
    		wp_enqueue_script( 'google-maps' );
    		wp_enqueue_script(  'gmw-xf-autocomplete' );
    		wp_localize_script( 'gmw-xf-autocomplete', 'autoComp', 'field_'.$this->gmw_settings['xprofile_fields']['address_fields']['address'] );
    	}	 
    }

    /**
     * include frontend functions
     */
    public function functions() {  	
    	
    	//return if field not set
    	if ( !isset( $this->gmw_settings['xprofile_fields']['xf_use'] ) || $this->gmw_settings['xprofile_fields']['xf_use'] == 'disabled' )
    		return;
    	
        include( 'includes/gmw-xf-functions.php' );
    }

    /**
     * Update xprofile fields when location updated using location tab
     * This function placed here since it attached to hook that uses ajax
     * it needs to be loaded in frontend and backend.
     * @param $mem_id
     * @param $returned_address
     * @param $address_apt
     * @param $street
     * @param $apt
     * @param $city
     */
    public function xprofile_location_tab_sync( $mem_id, $location ) {
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['street'] , $mem_id, $location['gmw_street']  );
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['apt']    , $mem_id, $location['gmw_apt'] 	);
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['city']   , $mem_id, $location['gmw_city'] 	);
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['state']	, $mem_id, $location['gmw_state'] 	);
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['zipcode'], $mem_id, $location['gmw_zipcode'] );
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['country'], $mem_id, $location['gmw_country'] );
        xprofile_set_field_data( $this->gmw_settings['xprofile_fields']['address_fields']['address'], $mem_id, $location['gmw_address'] );
    }
}

/**
 *  GMW_Xprofile_Fields Instance
 *
 * @since 1.2
 * @return GMW_Xprofile_Fields Instance
 * @author Eyal Fitoussi
 */
function GMW_XF() {

    //check for xprofile fields component
    if ( !bp_is_active( 'xprofile' ) ) {

        function gmw_xf_deactivated_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( "GEO Xprofle Fields add-on requires Buddypress's Extended Profiles component to be active in order to work.", "GMW-XF" ); ?></p>
            </div>  
            <?php
        }
        //abort the plugin if no component found
        return add_action( 'admin_notices', 'gmw_xf_deactivated_admin_notice' );
    }
    new GMW_Xprofile_Fields();
}
add_action( 'bp_init', 'GMW_XF' );
?>