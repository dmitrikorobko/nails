<?php
// Exit if accessed directly
if ( ! defined('ABSPATH') ) { exit;
}


/**
 * Calls the class.
 */
function sliced_call_better_url_updater_class() {
    new Sliced_Better_Url_Updater();
}
add_action('sliced_loaded', 'sliced_call_better_url_updater_class', 1);    


class Sliced_Better_Url_Updater {

	private $store_url 	= 'http://slicedinvoices.com';
	private $name 		= 'Better URL Extension';
	private $version 	= SI_URLS_VERSION;
	private $slug 		= 'better_urls';

	private $key_name 		= 'better_urls_license_key';
	private $status_name 	= 'better_urls_license_status';
    
    private $license_key = '';
    private $license_status = '';

    public function __construct() {

  		if ( ! class_exists( 'Sliced_Plugin_Updater', false ) ) {
			// 	// load our custom updater
			include( plugin_dir_path( __FILE__ ) . '/class-base-updater.php' );
		}

    	// retrieve our license key from the DB
		$licenses = get_option( 'sliced_licenses' );

		if ( isset( $licenses[ $this->key_name ] ) ) {
			$this->license_key = trim( $licenses[ $this->key_name ] );
		}
		if ( isset( $licenses[ $this->status_name ] ) ) {
			$this->license_status = trim( $licenses[ $this->status_name ] );
		}

        add_filter( 'sliced_licenses_option_fields', array( $this, 'license_field' ), 1 );
		add_action( 'admin_init', array( $this, 'plugin_updater' ), 0 );
		add_action( 'admin_init', array( $this, 'activate_license' ) );
		add_action( 'admin_init', array( $this, 'deactivate_license' ) );
    }


	public function plugin_updater() {
		// setup the updater
		new Sliced_Plugin_Updater( $this->store_url, SI_URLS_FILE, array(
				'version'   => $this->version, // current version number
				'license'   => $this->license_key, // license key (used get_option above to retrieve from DB)
				'item_name' => $this->name, // name of this plugin
				'author'    => 'Sliced Invoices', // author of this plugin
			)
		);

	}


	public function license_field( $options ) {
		$options['fields'][] = array(
			'name'        => $this->name,
			'desc'        => __( 'Enter the License Key for this extension', 'sliced-invoices-slugs' ),
			'default'     => '',
			'id'          => $this->key_name,
			'type'        => 'text',
			'after_field' => array( $this, 'after_field' ),
			'default'     => $this->license_key,
		);

		return $options;
	}

	public function after_field( $args, $field ) {
		if ( empty( $this->license_key ) ) {
			return;
		}

		$status = '';
		if ( $this->license_status ) {
			$status = 'valid' === $this->license_status ? 'active' : $this->license_status;
			$status = '<span class="license-status license-'. $status .'">' . sprintf( esc_html__( 'License: %s', 'sliced-invoices-slugs' ), $status ) . '</span>';
		}

		$nonce = wp_nonce_field( 'sliced_license_nonce', 'sliced_license_nonce_' . $this->slug, false, false );

		$id = $this->slug . ( 'valid' === $this->license_status ? '_license_deactivate' : '_license_activate' );

		$label = 'valid' === $this->license_status
			? esc_html__( 'Deactivate License', 'sliced-invoices-slugs' )
			: esc_html__( 'Activate License', 'sliced-invoices-slugs' );

		printf(
			'<p>%1$s%2$s<input type="submit" class="button-secondary" name="%3$s" value="%4$s"/></p>',
			$status,
			$nonce,
			$id,
			$label
		);

	}

	public function activate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST[ $this->slug . '_license_activate'], $_POST[ $this->key_name ] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( 'sliced_license_nonce', 'sliced_license_nonce_' . $this->slug ) ) {
				return; // get out if we didn't click the Activate button
			}

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => sanitize_text_field( $_POST[ $this->key_name ] ),
				'item_name'  => urlencode( $this->name ), // the name of our product in EDD
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );


			// make sure the response came back okay
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "valid" or "invalid"
			$licenses = get_option( 'sliced_licenses' );
			$licenses[ $this->key_name ]    = trim( $api_params['license'] );
			$licenses[ $this->status_name ] = trim( $license_data->license );

			update_option( 'sliced_licenses', $licenses );

			$this->license_key    = $licenses[ $this->key_name ];
			$this->license_status = $licenses[ $this->status_name ];
			//wp_redirect( admin_url( 'admin.php?page=sliced_licenses' ) );
			//exit;
		}
	}

	public function deactivate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST[ $this->slug . '_license_deactivate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( 'sliced_license_nonce', 'sliced_license_nonce_' . $this->slug ) ) {
				return; // get out if we didn't click the Activate button
			}

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $this->license_key,
				'item_name'  => urlencode( $this->name ), // the name of our product in EDD
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			$licenses = get_option( 'sliced_licenses' );
			$licenses[ $this->status_name ] = trim( $license_data->license );

			$this->license_status = $licenses[ $this->status_name ];

			// $license_data->license will be either "deactivated" or "failed"
			if ( $license_data->license == 'deactivated' ) {
				update_option( 'sliced_licenses', $licenses );
				//wp_redirect( admin_url( 'admin.php?page=sliced_licenses' ) );
			//exit;
			}

		}
	}
	

}

/************************************
* this illustrates how to check if
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

// function edd_sample_check_license() {

// 	global $wp_version;

// 	$license = trim( get_option( 'sliced_better_urls_license_key' ) );

// 	$api_params = array(
// 		'edd_action' => 'check_license',
// 		'license' => $license,
// 		'item_name' => urlencode( SLICED_BETTER_URLS ),
// 		'url'       => home_url()
// 	);

// 	// Call the custom API.
// 	$response = wp_remote_post( EDD_SAMPLE_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

// 	if ( is_wp_error( $response ) )
// 		return false;

// 	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

// 	if( $license_data->license == 'valid' ) {
// 		echo 'valid'; exit;
// 		// this license is still valid
// 	} else {
// 		echo 'invalid'; exit;
// 		// this license is no longer valid
// 	}
// }
