<?php
/*
Plugin Name: G2C2 GMaps integration
Description: Google maps integration for G2C2 site.  Relies on Geo my WP and BBPress xprofile.
Author: Green Chemistry Network
Author URI: http://www.greenchemistrynetwork.org
*/
if ( ! class_exists( 'G2C2_Maps' ) ) {

	class G2C2_Maps {


		// Function is always executed. Will create 1 Implementation object.
		static public function setup() {
			static $Inst = null;
			if ( null === $Inst ) {
	    			$Inst = new G2C2_Maps();
			}
			return $Inst;
		}

		// Function set up the api hook.
		private function __construct() {
			$this->_options = null;
			$this->init_actions();
			$this->init_filters();
		}

		public function init_actions() {
			//add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

		}

		function init_filters() {
			add_filter( 'gmw_map_elements', array( $this, 'format_gmap_infobox' ) );
		}

		function format_gmap_infobox($elements) {

			foreach( $elements as $map) {
				$results = $map['form']['results'];
				foreach( $results as $result ) {

					$id = $result->id;
					
					$org_name = xprofile_get_field_data("Organisation name", $id);
					$display_name = $result->display_name;
					if( empty($org_name) ) {
						if ( $bracpos = strpos($display_name, "(") ) {
							$org_name = substr($display_name, $bracpos + 1, -1);
							xprofile_set_field_data("Organisation name", $id, $org_name);
						} else {
							$org_name = "--";
						}
					}
					$url = "/membership-directory/profile/".$result->user_login;
					$address = $result->address;
					$result->info_window_content = <<<EOT
<div class="gmw-fl-infow-window-wrapper wppl-fl-info-window"> 
<div class="thumb wppl-info-window-thumb"></div> 
<div class="content wppl-info-window-info">
<table> 
<tr><td>
<span class="wppl-info-window-permalink">
<a href="$url">$org_name</a>
</span>
</td></tr> 
<tr><td><span>Address: </span>$address</td></tr> 
</table>
</div> 
</div>
EOT;
					unset($result->user_pass);
					unset($result->user_email);
					unset($result->user_registered);
					unset($result->user_status);
					unset($result->id);
				}
			}
			//var_dump($elements);
			return $elements;
		}


	}
}
G2C2_Maps::setup();
?>