<?php
/*
Plugin Name: G2C2 MailChimp integration
Description: MailChimp integration for the G2C2 members site.
Author: Green Chemistry Network
Author URI: http://www.greenchemistrynetwork.org
*/
include('lib/MailChimp.php'); 



use \DrewM\MailChimp\MailChimp;


if ( ! class_exists( 'G2C2_Mailchimp' ) ) {

	class G2C2_Mailchimp {

		static $OPTION_NAME = "g2c2_mailchimp";
		static $SETTINGS_SECTION_PAGE = "g2c2_mailchimp";
		static $SETTINGS_SECTION_ID  = "g2c2_mailchimp";

		// Function is always executed. Will create 1 Implementation object.
		static public function setup() {
			static $Inst = null;
			if ( null === $Inst ) {
	    			$Inst = new G2C2_Mailchimp();
			}
			return $Inst;
		}

		// Function set up the api hook.
		private function __construct() {
			$this->_api = null;
			$this->_options = null;
			$this->init_actions();
		}

		public function init_actions() {
			//add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			add_action( 'admin_init', array( $this, 'admin_init') );
			add_action( 'admin_menu', array( $this, 'admin_add_page') );

		}

		function admin_init() {
			register_setting($this::$OPTION_NAME, $this::$OPTION_NAME, array($this, 'validate_options'));
			add_settings_section( $this::$SETTINGS_SECTION_ID, 
				" ", 
				array( $this, 'admin_settings_section_html'), 
				$this::$SETTINGS_SECTION_PAGE) ;
		}

		function admin_add_page() {
			add_options_page('MailChimp settings', 'MailChimp integration', 'manage_options', 'g2c2_mailchimp', array( $this, 'options_page'));
		}

		function options_page() {
			?>
			<div>
			<h2>Mailchimp settings</h2>
				<form action="options.php" method="post">
				<?php settings_fields( $this::$OPTION_NAME ); ?>
				<?php do_settings_sections( $this::$SETTINGS_SECTION_PAGE ); ?>
				<?php submit_button(); ?>
				</form>
			</div>
			<?php
		}

		function admin_settings_section_html() {
			$options = $this->get_options();
			?>
			<label for ='<?php echo self::$OPTION_NAME ?>_api_key'>API key:
			<input id='<?php echo self::$OPTION_NAME ?>_api_key' 
				name='<?php echo self::$OPTION_NAME ?>[api_key]' 
				size='80' type='text' 
				value='<?php echo $options['api_key'] ?>' />
			</label>
			<?php 
		}

		function validate_options($input) {
			$options = $this->get_options();
			try {
				$api = new MailChimp( $input['api_key'] );
				$result = $api->get('lists');
				if( !$api->success() ) {
					throw new Exception("Mailchimp API error: ".$api->getLastError());	
				}
				$options['api_key'] = $input['api_key'];
			} catch (Exception $e) {
				add_settings_error(self::$OPTION_NAME, 'invalid-api-key', $e->getMessage(), 'error');
				$options['api_key'] = '';
			}
			$this->_options = null; // clear cache
			return $options;
		}

		function get_options() {
			if( $this->_options === null ) {
				$this->_options = get_option( $this::$OPTION_NAME );
			}
			return $this->_options;
		}

		function get_api() {
			if( !$this->have_initialised_api() ) {
				$key = $this->get_api_key();
				if(!$key) {
					$this->_api = false;
				} else {
					$this->_api = MailChimp( $this->get_api_key() );
				}
			}
			return $this->_api;
		}

		function have_api_key() {
			$options = $this->get_options();
			return ( isset( $options['api_key']) && $options['api_key'] != '' );
		}

		function get_api_key() {
			$options = $this->get_options();
			if( $this->have_api_key() ) {
				return $options['api_key'];
			}
		}

		function have_initialised_api() {
			return ( null !== $this->_api );
		}


	}
}

G2C2_Mailchimp::setup();
?>