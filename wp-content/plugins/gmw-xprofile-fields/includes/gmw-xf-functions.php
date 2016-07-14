<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * GMW_Xprofile_Fields
 */
class GMW_XF_Functions {

	/**
	 * __construct function.
	 */
	public function __construct() {
		
		$this->settings      = get_option( 'gmw_options' );
		$this->old_fields    = array();
		$this->onew_fields 	 = array();
		$this->last_activity = ( BP_VERSION < '2.0' ) ? get_user_meta( get_current_user_id(), 'last_activity' ) : bp_get_user_last_activity( get_current_user_id() );
		$this->xf_settings   = $this->settings['xprofile_fields'];
					
		//add location to user at first login
		if ( is_user_logged_in() && ( !isset( $this->last_activity ) || empty( $this->last_activity ) ) ) {
			self::update_xprofile_location( get_current_user_id() );
		}
		
		add_filter( 'bp_before_registration_submit_buttons' , array( $this, 'fields_autofill'  		   ) );	
		add_action( 'xprofile_data_before_save'				, array( $this, 'data_before_save' 		   ), 22, 1 );
		add_action( 'xprofile_data_after_save'				, array( $this, 'data_after_save'  		   ), 23, 1 );
		add_action( 'xprofile_updated_profile'				, array( $this, 'update_xprofile_location' ), 5 );
		add_action( 'gmw_fl_after_location_deleted'			, array( $this, 'delete_location' 		   ), 10, 1 );
	}
			
	/**
	 * Add address autofill and autocomplete on registration
	 * @version 1.0
	 * @author Eyal Fitoussi
	 */
	public function fields_autofill() {
		
		if ( !isset( $this->xf_settings['autofill'] ) )
			return;
		
		wp_enqueue_script(  'gmw-xf-autofill' );
		wp_localize_script( 'gmw-xf-autofill', 'rFields', $this->xf_settings['address_fields'] );
	}
	
	/**
	 * get old fields before data being saved
	 * @param unknown_type $fields
	 */
	public function data_before_save( $fields )  {
		$this->old_fields[$fields->field_id] = xprofile_get_field_data( $fields->field_id, $fields->user_id );
	}
	
	/**
	 * Get new fields after data beign saved
	 * @param unknown_type $fields
	 */
	public function data_after_save( $fields )  {
		$this->new_fields[$fields->field_id]  = $fields->value;
	}
	
	/**
	 * Update user's location using Xprofile fields
	 * @version 1.0
	 * @author Eyal Fitoussi
	 */
	public function update_xprofile_location( $user_id ) {
	
		$changed = array();

		foreach ( $this->old_fields as $key => $value ) {
			if ( $value != maybe_unserialize( $this->new_fields[$key] ) ) $changed[] = $key;
		}

		global $wpdb;
		$mem_loc = $wpdb->get_col( $wpdb->prepare( "SELECT `member_id` FROM `wppl_friends_locator` WHERE `member_id` = %d", $user_id ) );
		/*
		 * Get location when using single address field
		 */
		if ( $this->xf_settings['xf_use'] == 'single' ) {
			
			// if no address fields changed stop the script
			if  ( !in_array( $this->xf_settings['address_fields']['address'], $changed ) && !empty( $this->last_activity ) && !empty( $mem_loc ) ) 
				return;

			$address = $address_apt = xprofile_get_field_data( $this->xf_settings['address_fields']['address'], $user_id );
			
			//geocode the address
			$returned_address = GEO_my_WP::geocoder( $address );			
			$street 		  = $returned_address['street'];
			$apt 			  = $returned_address['apt'];
			$city 			  = $returned_address['city'];
		/*
		 * otherwise multiple address fields
		*/
		} else {
			
			$addressArray = $this->xf_settings['address_fields'];
			unset( $addressArray['address'] );
			
			$idsArray = array();
			foreach ( $addressArray as $key => $value ) {
				if ( !empty( $value ) ) {
					$idsArray[] = $value;
				}
			}
			
			/* if no address fields changed stop the script */
			if ( count( array_intersect( $changed, $idsArray ) ) == 0 && !empty( $this->last_activity ) && !empty( $mem_loc ) ) 
				return;
		
			if ( !empty( $this->xf_settings['address_fields']['street'] ) )  $street = xprofile_get_field_data(  $this->xf_settings['address_fields']['street'],  $user_id );
			if ( !empty( $this->xf_settings['address_fields']['apt'] ) ) 	 $apt = xprofile_get_field_data( 	 $this->xf_settings['address_fields']['apt'], 	  $user_id );
			if ( !empty( $this->xf_settings['address_fields']['city'] ) ) 	 $city = xprofile_get_field_data( 	 $this->xf_settings['address_fields']['city'], 	  $user_id );
			if ( !empty( $this->xf_settings['address_fields']['state'] ) )   $state = xprofile_get_field_data( 	 $this->xf_settings['address_fields']['state'],   $user_id );
			if ( !empty( $this->xf_settings['address_fields']['zipcode'] ) ) $zipcode = xprofile_get_field_data( $this->xf_settings['address_fields']['zipcode'], $user_id );
			if ( !empty( $this->xf_settings['address_fields']['country'] ) ) $country = xprofile_get_field_data( $this->xf_settings['address_fields']['country'], $user_id );
	
			/* set the full address into "full address" profile fields */
			$address 	 = $street . ' ' . $city . ' ' . $state . ' ' . $zipcode . ' ' . $country;
			$address_apt = $street . ' ' . $apt . ' ' . $city . ' ' . $state . ' ' . $zipcode . ' ' . $country;
			
			if ( !empty( $this->xf_settings['address_fields']['address'] ) ) {
				xprofile_set_field_data( $this->xf_settings['address_fields']['address'], $user_id, $address );
			}
			
			//geocode the address
			$returned_address = GEO_my_WP::geocoder( $address );			
		}
		
		if ( !empty( $returned_address['lat'] ) && !empty( $returned_address['lng'] ) ) {
				
			global $wpdb;

			$location = array(
					'gmw_street'			=> $street,
					'gmw_apt'				=> $apt,
					'gmw_city' 				=> $city,
					'gmw_state' 			=> $returned_address['state_short'],
					'gmw_state_long' 		=> $returned_address['state_long'],
					'gmw_zipcode'			=> $returned_address['zipcode'],
					'gmw_country' 			=> $returned_address['country_short'],
					'gmw_country_long'		=> $returned_address['country_long'],
					'gmw_address'			=> $address_apt,
					'gmw_formatted_address' => $returned_address['formatted_address'],
					'gmw_lat'               => $returned_address['lat'],
					'gmw_long'				=> $returned_address['lng'],
					'gmw_map_icon'			=> ( isset($_POST['gmw_map_icon']) ) ? $_POST['gmw_map_icon'] : '_default.png',
			);

			$location = apply_filters( 'gmw_xf_location_before_updated', $location, $user_id );
			/*
			 * Add location to database
			*/
			$wpdb->replace( 'wppl_friends_locator', array(
					'member_id'			=> $user_id,
					'street'			=> $location['gmw_street'],
					'apt'				=> $location['gmw_apt'],
					'city' 				=> $location['gmw_city'],
					'state' 			=> $location['gmw_state'],
					'state_long' 		=> $location['gmw_state_long'],
					'zipcode'			=> $location['gmw_zipcode'],
					'country' 			=> $location['gmw_country'],
					'country_long'	 	=> $location['gmw_country_long'],
					'address'			=> $location['gmw_address'],
					'formatted_address' => $location['gmw_formatted_address'],
					'lat'				=> $location['gmw_lat'],
					'long'				=> $location['gmw_long'],
					'map_icon'			=> $location['gmw_map_icon']
			));

			$args = array(
					'location'  => apply_filters( 'gmw_xf_address_activity_update', $location['gmw_address'], $location, $this->settings ),
					'user_id'	=> $user_id
			);
			
			$activity_id = gmw_location_record_activity( $args );

			//delete the address if location was not found
		} else {
			
			global $wpdb;
			
			self::delete_location( $user_id );
			$wpdb->query(
					$wpdb->prepare(
							"DELETE FROM wppl_friends_locator WHERE member_id=%d",$user_id
					)
			);
		}	
	}
	
	/**
	 * Delete xprofile fields when location deleted using location tab
	 * @param $mem_id
	 * @author Eyal Fitoussi
	 */
	public function delete_location( $mem_id ) {
			
		$addressArray = array( 'street', 'apt', 'city', 'state', 'zipcode', 'country', 'address' );
		foreach ( $addressArray as $field ) {
			if ( !empty($this->xf_settings['address_fields'][$field] ) ) xprofile_delete_field_data( $this->xf_settings['address_fields'][$field], $mem_id );
		}
	}
}
new GMW_XF_Functions;
?>