<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Sliced Invoices Better URL's
 * Plugin URI:        https://slicedinvoices.com/extensions/better-urls/
 * Description:       Change the URL slugs on Invoices and Quotes without touching any code. Requirements: The Sliced Invoices Plugin
 * Version:           1.1.5
 * Author:            Sliced Invoices
 * Author URI:        https://slicedinvoices.com/
 * Text Domain:       sliced-invoices-slugs
 * Domain Path:       /languages
 *
 * -------------------------------------------------------------------------------
 * Copyright 2015-2019 Sliced Apps, Inc.  All rights reserved.
 * -------------------------------------------------------------------------------
 */

// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
	exit;
}

/**
 * Initialize
 */
define( 'SI_URLS_VERSION', '1.1.5' );
define( 'SI_URLS_FILE', __FILE__ );

include( plugin_dir_path( __FILE__ ) . '/updater/plugin-updater.php' ); 

function sliced_slugs_load_textdomain() {
    load_plugin_textdomain( 'sliced-invoices-slugs', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'sliced_slugs_load_textdomain' );


/**
 * Calls the class.
 */
function sliced_call_slugs_class() {
    new Sliced_Slugs();
}
// priority 0 runs before all other extensions (except Secure Invoices), and 
// (most importantly) before we register our CPTs (which is also done on the
// init hook, at priority 1).
add_action( 'init', 'sliced_call_slugs_class', 0 );


/** 
 * The Class.
 */
class Sliced_Slugs {

    /**
     * @var  object  Instance of this class
     */
    protected static $instance;


    public function __construct() {
		
		if ( ! $this->validate_settings() ) {
			return;
		}
	
        add_filter( 'plugin_action_links_sliced-invoices-slugs/sliced-invoices-slugs.php', array( $this, 'plugin_action_links' ) );
        add_filter( 'sliced_quote_option_fields', array( $this, 'sliced_add_quote_options' ), 1 );
        add_filter( 'sliced_invoice_option_fields', array( $this, 'sliced_add_invoice_options' ), 1 );
        add_filter( 'sliced_quote_params', array( $this, 'sliced_new_quote_slug' ) );
        add_filter( 'sliced_invoice_params', array( $this, 'sliced_new_invoice_slug' ) );
        add_action( 'admin_notices', array( $this, 'sliced_slugs_rewrite_remind' ), 999 );
		add_action( 'sliced_flush_rewrite_rules', array( $this, 'sliced_flush_rewrite_rules_function' ) );

    }


    public static function get_instance() {
        if ( ! ( self::$instance instanceof self ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Add links to plugin page
     *
     * @since   2.0.0
     */
    public function plugin_action_links( $links ) {
       $links[] = '<a href="'. esc_url( get_admin_url( null, 'admin.php?page=sliced_invoices_settings&tab=invoices' ) ) .'">' . __( 'Settings', 'sliced-invoices' ) . '</a>';
       return $links;
    }

    /**
     * Add the options fields.
     *
     * @since 1.0.0
     */
    public function sliced_add_quote_options( $options ) {

        $prefix = 'sliced_';

		$options['fields'][] = array(
			'name'      => __( 'Better URLs', 'sliced-invoices-slugs' ),
			'desc'      => '',
			'id'        => 'slugs_title',
			'type'      => 'title',
		);
        $options['fields'][] = array(
            'name'      => __( 'Quote URL Slug', 'sliced-invoices-slugs' ),
            'desc'      => __( 'You can change this from sliced_quote to quotes or estimates (or any other word you like). Must be all lowercase and only underscores, no dashes.', 'sliced-invoices-slugs' ),
            'default'   => 'sliced_quote',
            'id'        => 'new_slug',
            'type'      => 'text',
        );

        return $options;

    }

    /**
     * Add the options fields.
     *
     * @since 1.0.0
     */
    public function sliced_add_invoice_options( $options ) {

        $prefix = 'sliced_';

		$options['fields'][] = array(
			'name'      => __( 'Better URLs', 'sliced-invoices-slugs' ),
			'desc'      => '',
			'id'        => 'slugs_title',
			'type'      => 'title',
		);
        $options['fields'][] = array(
            'name'      => __( 'Invoice URL Slug', 'sliced-invoices-slugs' ),
            'desc'      => __( 'You can change this from sliced_invoice to invoice or bill (or any other word you like). Must be all lowercase.', 'sliced-invoices-slugs' ),
            'default'   => 'sliced_invoice',
            'id'        => 'new_slug',
            'type'      => 'text',
        );

        return $options;

    }



    /**
     * Make the changes.
     *
     * @since 1.0.0
     */
    public function sliced_new_quote_slug( $opts ) {
        $quotes = get_option( 'sliced_quotes' );
        $opts['rewrite']['slug'] = isset( $quotes['new_slug'] ) ? $quotes['new_slug'] : $opts['rewrite']['slug'];
        return $opts;
    }
    public function sliced_new_invoice_slug( $opts ) {
        $invoices = get_option( 'sliced_invoices' );
        $opts['rewrite']['slug'] = isset( $invoices['new_slug'] ) ? $invoices['new_slug'] : $opts['rewrite']['slug'];
        return $opts;
    }


    /**
     * Admin notices
     *
     * @since 1.0.0
     */
    public function sliced_slugs_rewrite_remind( $post_states ) {

        global $pagenow;

        /*
         * Options updated notice
         */
        if ( $pagenow == 'admin.php' && ( isset( $_GET['page'] ) && strpos( $_GET['page'], 'sliced_' ) !== false ) && isset( $_POST['new_slug'] ) && ! empty( $_POST['new_slug'] ) ) {
            /* echo '<div class="error">
                 <p>' . sprintf( __( 'If you have modified the URL slug, please visit the <a href="%s">Permalinks page</a> for the new URL changes to take effect. You simply need to visit the page, which will automatically flush the rewrite rules and make the new changes.', 'sliced-invoices' ), admin_url( 'options-permalink.php' ) ) . '</p>
             </div>';
			*/
			
			// run in background 1 second from now
			wp_schedule_single_event( time() + 1, 'sliced_flush_rewrite_rules' );
        }


    }
	
	/**
     * Background flush rewrite rules
     *
     * @since 1.1.4
     */
	public function sliced_flush_rewrite_rules_function() {
	
		flush_rewrite_rules();
		
	}
	
	
	/**
     * Output requirements not met notice.
     *
     * @since   1.1.5
     */
	public function requirements_not_met_notice() {
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'Sliced Invoices Better URL\'s extension cannot find the required <a href="%s">Sliced Invoices plugin</a>. Please make sure the core Sliced Invoices plugin is <a href="%s">installed and activated</a>.', 'sliced-invoices-slugs' ), 'https://wordpress.org/plugins/sliced-invoices/', admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}
	
	
	/**
     * Validate settings, make sure all requirements met, etc.
     *
     * @since   1.1.5
     */
	public function validate_settings() {
	
		if ( ! class_exists( 'Sliced_Invoices' ) ) {
			
			// Add a dashboard notice.
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

			return false;
		}
		
		return true;
	}


}
