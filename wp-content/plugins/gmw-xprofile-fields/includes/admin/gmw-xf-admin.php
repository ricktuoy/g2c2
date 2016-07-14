<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) 
	exit; 

/**
 * GMW_XF_Admin class
 */
class GMW_XF_Admin {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		add_filter( 'gmw_admin_settings', array( $this, 'settings_init' ) );
		
		//main settings
		add_action( 'gmw_main_settings_xprofile_address_fields', array( $this, 'xprofile_address_fields' ), 1, 3 );
	}
	
	 /**
	 * Display Xprofile fields as dropdown
	 * @version 1.0
	 * @author Eyal Fitoussi
	 */
	protected function display_xprofile_fields($value, $gmw_options ) {
		global $bp;
		global $field;
	
		if ( bp_is_active( 'xprofile' ) ) { 
			if (function_exists( 'bp_has_profile' ) ) {
				if (bp_has_profile( 'hide_empty_fields=0' ) ) {
				
					echo '<select name="gmw_options[xprofile_fields][address_fields]['.$value.']">';
						echo '<option value="">'.__('N/A', 'GMW-XF').'</option>';
						while ( bp_profile_groups () ) {
							bp_the_profile_group (); 
							
							while ( bp_profile_fields () ) {
								bp_the_profile_field(); ?>
								<?php if ( bp_get_the_profile_field_type() != 'datebox'  ) {  ?>	
									<option value="<?php bp_the_profile_field_id(); ?>" <?php if ( isset( $gmw_options['xprofile_fields']['address_fields'][$value] ) && $gmw_options['xprofile_fields']['address_fields'][$value] == bp_get_the_profile_field_id() ) echo 'selected="selected"'; ?>><?php bp_the_profile_field_name(); ?></option>
								<?php } 
							}
						}
						
					echo '</select>';
		
				}
			} 
		}
	}
	
	public function xprofile_address_fields( $gmw_options, $section, $option ) { 
		?>
		<div id="gmw-xprofile-fields-wrapper">
			<div class="gmw-single-xprofile-fields" <?php if ( !isset( $gmw_options['xprofile_fields']['xf_use'] ) || $gmw_options['xprofile_fields']['xf_use'] != 'single' ) echo 'style="display:none"'; ?>>
				<?php echo _e( 'Full Address: ','GMW-XF' ); ?>&#32;<?php self::display_xprofile_fields( 'address', $gmw_options ); ?>
			</div>
			<div class="gmw-multiple-xprofile-fields" <?php if ( !isset( $gmw_options['xprofile_fields']['xf_use'] ) || $gmw_options['xprofile_fields']['xf_use'] != 'multiple' ) echo 'style="display:none"'; ?>>
				<?php $fieldsArray = array('street','apt','city','state','zipcode','country'); ?>
				<?php foreach ($fieldsArray as $key => $value ) : ?>
					<span class="title"><?php echo _e( ucwords($value), 'GMW-XF' ); ?>&#32;: <?php self::display_xprofile_fields( $value, $gmw_options ); ?><br />
				<?php endforeach; ?>
			</div>
		</div>		
		<script>
		jQuery(document).ready(function($) {
			if ( $('input[name="gmw_options[xprofile_fields][xf_use]"]:checked').val() == 'disabled' ) {
				$('#gmw-xprofile-fields-wrapper').closest('tr').hide(); 
				$('.setting-xf_autocomplete').closest('tr').hide();
				$('.setting-autofill').closest('tr').hide(); 
			}
			if ( $('input[name="gmw_options[xprofile_fields][xf_use]"]:checked').val() == 'multiple' ) {
				$('.setting-xf_autocomplete').closest('tr').hide();
			}
			
			$('.setting-xf_use').change(function() {
				if ( $(this).val() == 'disabled' ) {
					$('#gmw-xprofile-fields-wrapper').closest('tr').hide(); 
					$('.setting-xf_autocomplete').closest('tr').hide(); 
					$('#gmw-xprofile-fields-wrapper div').hide();
					$('.setting-autofill').closest('tr').hide();
				} else {
					if ( $('#gmw-xprofile-fields-wrapper').closest('tr').is(':hidden') ) {
						$('#gmw-xprofile-fields-wrapper').closest('tr').show(); 
						$('.gmw-'+$(this).val()+'-xprofile-fields').slideToggle();
						$('.setting-autofill').closest('tr').show();

						if ( $(this).val() == 'single' ) $('.setting-xf_autocomplete').closest('tr').show(); 
					} else {
						$('#gmw-xprofile-fields-wrapper div').slideToggle();
						$('.setting-xf_autocomplete').closest('tr').toggle();
					}
				}
			});
		});
		</script>
		<?php 	
	}
	
	/**
	 * addon settings page function.
	 *
	 * @access public
	 * @return $settings
	 */
	public function settings_init( $settings ) {

		$settings['xprofile_fields'] = array(
				
				__( 'GEO Xprofile Fields', 'GMW-XF' ),
				array(
						'my_location_tab' => array(
								'name'       => 'my_location_tab',
								'std'        => '',
								'label'      => __( 'Location Tab - Logged-in User', 'GMW-XF' ),
								'desc'       => __( "This feature controls the \"Location\" tab of the logged in user when viewing his own profile page. You can choose to either display the location tab or you can completly disable it.", 'GMW-XF' ),
								'type'  	 => 'radio',
								'options'	 => array(
										'enabled'	=> __( 'Enabled', 'GMW-XF' ),
										'disabled'	=> __( 'Disabled','GMW-XF' ),
								)
						),
						'xf_use'	=> array(
								'name'       => 'xf_use',
								'std'        => '',
								'label'      => __( 'Xprofile Fields Integration', 'GMW-XF' ),
								'desc'       => __( 'Two ways you can use this feature: <br />
										1)Create one address field where users can add their location by entering athe full address.<br />
										2)Create multiple profile fields (you do not have to create all of them): street, apt, city,state, zipcode, country.<br />
										First you will need to create the address xprofile fields using Buddypress. Once done so you will need to choose the xprofile for each of the address fields using the select dropdown menus.', 'GMW-XF' ),
								'type'       => 'radio',
								'attributes' => array(),
								'options'	 => array(
										'disabled' 	=> __( 'Disabled', 'GMW-XF' ),
										'single' 	=> __( 'Single Address Field', 'GMW-XF' ),
										'multiple' 	=> __( 'Multiple Address Fields', 'GMW-XF' ),
								)
						),
						'address_fields' => array(
								'name'       => 'address_fields',
								'std'        => '',
								'label'      => __( 'Address Fields', 'GMW-XF' ),
								'desc'       => __( "Choose an xprofile field for each address field which you'd like to use.", 'GMW-XF' ),
								'type'       => 'function',
								'function'	 => 'xprofile_address_fields',
								'attributes' => array(),

						),
						'xf_autocomplete' => array(
								'name'        => 'xf_autocomplete',
								'std'         => '',
								'label'       => __( 'Google Address Autocomplete', 'GMW-XF' ),
								'cb_label'    => __( 'Yes', 'GMW-XF' ),
								'desc'        => __( 'Use Google Places address autocomplete on the address field. This feature can only be used when choosing "Single address field" above.', 'GMW-XF' ),
								'type'		  => 'checkbox',

						),
						'autofill'	=>	array(
								'name'        => 'autofill',
								'std'         => '',
								'label'       => __( 'Google Address Autofill', 'GMW-XF' ),
								'cb_label'    => __( 'Yes', 'GMW-XF' ),
								'desc'        => __( 'While first visiting the registration form the browser will try to get the user current location and if found it will autofill the address fields.', 'GMW-XF' ),
								'type'		  => 'checkbox',

						),
				),
		);

		if ( GMW_VERSION >= '2.5' ) {
			
			$settings['xprofile_fields'][1]['my_location_tab'] = array(
					'name'       => 'my_location_tab',
					'std'        => '',
					'label'      => __( 'Location Tab - Logged-in User', 'GMW-XF' ),
					'desc'       => __( "This feature controls the \"Location\" tab of the logged in user when he views his own profile page. You can choose to display the location form, map showing his location or you can completly disable the Location tab.", 'GMW-XF' ),
					'type'  	 => 'radio',
					'options'	 => array(
							'enabled'	=> __( 'Location Form', 'GMW-XF' ),
							'map'		=> __( 'Map', 			'GMW-XF' ),
							'disabled'	=> __( 'Disabled', 		'GMW-XF' ),
					)
			);
			
		}
		
		return $settings;
	}
}
new GMW_XF_Admin;