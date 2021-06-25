<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'walker', 'actions']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);




function shortcode_invoice_url( $atts ) {

    // Assign default values
    $user_default_value = "";

    extract( shortcode_atts( array(
        'user' => $user_default_value,
    ), $atts ) );

    $userObject = get_user_by('login', $user);

    if($userObject) {
        $user_id = $userObject->ID;
        $acf_user = 'user_'.$user_id.'';

        $invoiceObject = get_field('field_60819a5fbfc6c', $acf_user);

        $url = get_permalink($invoiceObject);

        $html = '<a href="'. $url  .'">Your invoice</a>';

    } else {
        $html = '<p>No username lolololo</p>';
    }

    return $html;
}

add_shortcode( 'invoice_url', 'shortcode_invoice_url' );

/*
add_filter( 'um_template_tags_patterns_hook', 'my_template_tags_patterns', 10, 1 );
add_filter( 'um_template_tags_replaces_hook', 'my_template_tags_replaces', 10, 1 );

function my_template_tags_patterns( $search ) {
	$search[] = '{invoice_link}';
	return $search;
}
function my_template_tags_replaces( $replace ) {

    $user_email = um_user( 'user_email' );
    $userObject = get_user_by('login', $user_email);

    if($userObject) {
        $user_id = $userObject->ID;
        $acf_user = 'user_'.$user_id.'';

        $invoiceObject = get_field('field_60819a5fbfc6c', $acf_user);

        $url = get_permalink($invoiceObject);

        $html = '<a href="'. $url  .'">Your invoice</a>';

    } else {
        $html = '<p>No username lolololo</p>';
    }

	$replace[] = $html;
	return $replace;
}

*/

add_filter( 'sliced_email_header', 'sliced_custom_email_header' );
function sliced_custom_email_header() {

	$email_header = "<!DOCTYPE html><html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><title>" . get_bloginfo( 'name' )  . "</title></head>
    

    <body style='background: #f2f2f2;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;'>

    <div style='max-width: 560px;padding: 20px;background: #ffffff;border-radius: 5px;margin:40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666;'>

	<div style='color: #444444;font-weight: normal;'>
		<div style='text-align: center;font-weight:600;font-size:26px;padding: 10px 0;border-bottom: solid 3px #eeeeee;'>". get_bloginfo( 'name' ) ."</div>
		
		<div style='clear:both'></div>
	</div>
    <div style='padding: 0 30px 30px 30px;border-bottom: 3px solid #eeeeee;'>
    ";

    

	return $email_header;
}


add_filter( 'sliced_email_footer', 'sliced_custom_email_footer' );
function sliced_custom_email_footer() {

	$settings = get_option( 'sliced_emails' );
	
	$email_footer = '
       </div> 
       <div style="color: #999;padding: 20px 30px">

		<div style="">'.  __('Thank you!','sage') .'</div>
		<div style=""><a href="'. get_bloginfo( 'url' ) .'" style="color: #3ba1da;text-decoration: none;">'. get_bloginfo( 'name' ) . '</a> '. __('Team','sage') .'</div>
		
	    </div>
       
       </div> </body></html>
    ';


	return $email_footer;
}

function create_invoice($user_id, $tax, $total) {
            $acf_user = 'user_'.$user_id.'';

            $user_info = get_userdata($user_id);
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            $user_role = $user_info->roles[0];
            

            if($tax == true){
                $tax = 'on';
            }

            $args = array(
                'post_title'      => $first_name . ' ' . $last_name,
                'post_content'    => 'Description here',
                'post_status'     => 'publish',
                'post_type'       => 'sliced_invoice',
            );
            $invoice_id = wp_insert_post( $args );
            
            /**
             * 2) now let's attach some extra pieces of information.
             * These are stored as post metas:
             */
            // MOST IMPORTANT, the user ID of the client the invoice is associated with:
            update_post_meta( $invoice_id, '_sliced_client', $user_id ); // example: user ID "1"
            
            // invoice created date:
            update_post_meta( $invoice_id, '_sliced_invoice_created', time() ); // example: now
            
            // invoice due date:
            update_post_meta( $invoice_id, '_sliced_invoice_due', date('U', strtotime('+5 days')) ); // example: Dec. 31, 2018
            
            // invoice number:
            update_post_meta( $invoice_id, '_sliced_invoice_number', sliced_get_next_invoice_number() );
            Sliced_Invoice::update_invoice_number( $invoice_id ); // advance invoice number for the next time
            
            // automatically enable your chosen payment methods:
            $payment_methods = sliced_get_accepted_payment_methods();
            update_post_meta( $invoice_id, '_sliced_payment_methods', array_keys($payment_methods) );

            $line_items = [];
            
            $nominations = [];
            
            if($user_role == 'participant'){

                if( have_rows('field_608164444c690', $acf_user) ):

                        // loop through the rows of data
                    while ( have_rows('field_608164444c690', $acf_user) ) : the_row();
        
                        $nomination_id = get_sub_field('nomination');
                        $nomination_title = get_the_title($nomination_id);
                        $temp_array = array(
                            'qty' => '1',
                            'title' => $nomination_title,
                            'amount' => '',
                            'taxable' => $tax,
                        );
                        $nominations[] = $nomination_title;
                        //array_push($line_items, $temp_array);
                
                    endwhile;
                
                else :
                
                
                endif;

            }

            $invoice_description = implode("\n",$nominations);

            $total_array = array(
                'qty' => '1',
                'title' => __('Total','sage'),
                'amount' => $total,
                'taxable' => $tax,
                'description' => $invoice_description
            );
            array_push($line_items, $total_array);

            update_post_meta( $invoice_id, '_sliced_items', $line_items );

            $SN = new Sliced_Notifications();
            $SN->send_the_invoice($invoice_id);

            return $invoice_id;
        
}

// 'init' is a good place to hook into.
// The Sliced Invoices plugin will be fully loaded by this point:
//add_action( 'init', 'create_invoice' );

add_action('um_after_account_general', 'account_additional_fields', 100);
 
function account_additional_fields(){
    $custom_fields = [
        "field_6080792b7dc7d" => __('Phone','sage'),
    ];

    if(is_user_role('judge')){  
        $custom_fields['field_6081a017220dd'] = __('Description', 'sage');
    }

    foreach ($custom_fields as $k => $title) {

        $field_object = get_field_object($k);
        
        $field_type = $field_object['type'];

        $fields[ $k ] = array(
            'title' => $title,
            'metakey' => $k,
            'type' => $field_object['type'],
            'label' => $title,
        );
        apply_filters('um_account_secure_fields', $fields, get_current_user_id());
 
        $val = get_field($k, 'user_'.get_current_user_id() ) ? get_field($k, 'user_'.get_current_user_id() ) : '';
        
        $input = '';

        if($field_type == 'textarea') {
            $input = '<textarea class="um-form-field valid" name="'.$k.'" id="user_'.$k.'" " rows="8">'.$val.'</textarea>';
        } else {
            $input = '<input class="um-form-field valid " type="'. $field_object['type'] .'" name="'.$k.'" id="user_'.$k.'" value="'.$val.'" placeholder="'.$title.'" data-validate="" data-key="'.$k.'">';
        }

        $html = '<div class="um-field um-field-text  um-field-'.$k.' um-field-text um-field-type_text" data-key="'.$k.'">
                <div class="um-field-label">
                    <label for="user_'.$k.'">'.$title.'</label>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area">

                    '. $input .'
                </div>
            </div>';
        echo $html; ?>
        
        <?  
    }

    
}


// action : um_account_pre_update_profile
// function name: account_additional_fields_update
add_action('um_account_pre_update_profile', 'account_additional_fields_update', 100);
 
function account_additional_fields_update(){
    $fields = ['field_6080792b7dc7d'];
    if(is_user_role('judge')){
        array_push($fields, 'field_6081a017220dd');
    }
    foreach( $fields as $f ){
        update_field( $f, $_POST[$f], 'user_'.get_current_user_id() );
    }
}

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

function is_user_role($is_role){
    $user_id = get_current_user_id();
    $user_meta=get_userdata($user_id);
    $user_roles=$user_meta->roles;
    $user_role = $user_roles[0];

    return ($user_role == $is_role) ? true : false;
}

/*
add_action( 'um_after_account_page_load', 'my_after_account_page_load', 10 );
function my_after_account_page_load() {
    acf_form_head();
}*/


add_filter( 'ajax_query_attachments_args', 'wpb_show_current_user_attachments' );
 
function wpb_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts
') ) {
        $query['author'] = $user_id;
    }
    return $query;
} 


function users_set_columns( $columns ) {

    unset( $columns['account_status'] );
    unset( $columns['posts'] );
    unset( $columns['name'] );
    unset( $columns['email'] );
    $columns['user_id'] = 'User ID';
    $columns['nominations'] = 'Nominations';
    return $columns;
}

add_filter( 'manage_users_columns', 'users_set_columns' );


add_action('manage_users_custom_column',  'user_id_column', 10, 3);
add_action('manage_users_custom_column',  'user_nominations_column', 10, 3);

function user_id_column($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
	if ( 'user_id' == $column_name )
		return $user_id;
    return $value;
}


function user_nominations_column($value, $column_name, $user_id) {
    //$user = get_userdata( $user_id );

	if ( 'nominations' == $column_name ){
        if( have_rows('field_608164444c690', 'user_'.$user_id.'') ):
            $result = "";
            while ( have_rows('field_608164444c690', 'user_'.$user_id.'')) : the_row();
                $nomination_id = get_sub_field('field_6081664d82734');


                $result .= get_field('number', $nomination_id). '. - ' . get_field('type', $nomination_id) . ' - ' . get_the_title($nomination_id) . '<br>';
            endwhile;
            return $result;
        else :
            // no rows found
        endif;
    }
    return $value;
}