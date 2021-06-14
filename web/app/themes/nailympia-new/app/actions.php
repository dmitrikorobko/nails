<?php


namespace App;

use Sober\Controller\Controller;
use WC_AJAX;

class Ajax extends Controller
{
    public function __construct()
    {

        add_action('wp_ajax_nopriv_register_user', [$this,'register_user']);
        add_action('wp_ajax_register_user', [$this,'register_user']);

        add_action('wp_ajax_submit_dropzonejs', [$this, 'dropzonejs_upload']);
        add_action('wp_ajax_nopriv_submit_dropzonejs', [$this, 'dropzonejs_upload']);

        add_action('wp_ajax_user_nominations_form', [$this, 'user_nominations_form']);
        add_action('wp_ajax_nopriv_user_nominations_form', [$this, 'user_nominations_form']);

        add_action('wp_ajax_select_participant', [$this, 'select_participant']);
        add_action('wp_ajax_nopriv_select_participant', [$this, 'select_participant']);

        add_action('wp_ajax_judge_admin_form', [$this, 'judge_admin_form']);
        add_action('wp_ajax_nopriv_judge_admin_form', [$this, 'judge_admin_form']);

        add_action('wp_ajax_set_score', [$this, 'set_score']);
        add_action('wp_ajax_nopriv_set_score', [$this, 'set_score']);

        add_action('wp_ajax_select_nomination', [$this, 'select_nomination']);
        add_action('wp_ajax_nopriv_select_nomination', [$this, 'select_nomination']);



    }


    function set_score() {
        $post_id = (int)$_POST['post_id'];
        $score = (int)$_POST['score'];

        if ($post_id && $score) {
            update_field('score', $score, $post_id);
            wp_send_json([

                'result' => '<strong>' . $score . '</strong>'
            ]);
        }
    }



    function judge_admin_form() {

//        print_r($_POST);
//
//        die();

        $judges = $_POST['judge'];
        $user_id = (int)$_POST['user_id'];
        $participant = (int)$_POST['participant'];
        $nomination = $_POST['nomination'];
        $participant_user = get_userdata($participant);

        if ($judges) {
            foreach ($judges as $judge) {

                $judge_id = (int)$judge['judge'];
                $judging_criteria = (int)$judge['criteria'];

                $judge_user = get_userdata($judge_id);
                $judging_criteria_post = get_post($judging_criteria);

                $post_id = wp_insert_post([
                    'post_type' => 'score',
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                    'post_title'    => $participant_user->display_name . ' - ' . $judge_user->display_name. ' - ' . $judging_criteria_post->post_title

                ]);

                update_field('participant', $participant, $post_id);
                update_field('nomination', $nomination, $post_id);
                update_field('judge', $judge_id, $post_id);
                update_field('judging_criteria', $judging_criteria, $post_id);

                $judging_criteria_user = get_field('judging_criteria',  $judge_user) ?? [];
                $judging_criteria_user[] = $judging_criteria;

                $nominatios = get_field('nomination',  $judge_user) ?? [];
                $nomination_user[] = $nominatios;

                update_field('judging_criteria', $judging_criteria_user, $judge_user);
                update_field('nomination', $nomination_user, $judge_user);

               // update_field('judge', $judge_id, $judging_criteria);
            }
        }

    }



    function  select_participant() {
        $user_id = (int)$_GET['user_id'];


        $nominations = get_field('nominations', 'user_' . $user_id);


        if ($nominations) {
            $data .= '<label><strong>Nomination</strong>';
            $data .= '<select name="nomination" class="form-control">';
            $data .= '<option value="">Select</option>';



            foreach ($nominations as $i => $value) {

                $nomiantion = get_post($value['nomination']);
                $data .= '<option value="'.$nomiantion->ID.'">'.$nomiantion->post_title.'</option>';

            }


            $data .= '</select>';


        } else {
            $msg = 'No nominations';
        }

        wp_send_json([
            'msg' => $msg,
            'data' => $data
        ]);


    }


    public function select_nomination() {

        $nomination_id = $_GET['nomination_id'];
        $criteries = get_field('judging_criteria', $nomination_id);

        $data = '<br><table class="table">';

        $data .= '<tr>';
        $data .= '<th>Criteria</th><th>Judge</th>';
        $data .= '</tr>';

        if ($criteries)
            foreach ($criteries as $criteria_id) {
                $criteria = get_post($criteria_id);
                $loop++;

               // $selected = in_array($criteria_id, get_field('judging_criteria'));

                $data .= '<tr>';
                $data .= '<td><input type="hidden" value="'.$criteria->ID.'" name="judge['.$loop.'][criteria]">'.$criteria->post_title.'</td>
                          <td>'.wp_dropdown_users( ['echo' => false, 'class'=>'form-control','role'=>'judge', 'name' => 'judge['.$loop.'][judge]', 'show_option_none'   => 'Select',] ).'</td>';
                $data .= '</tr>';


            }

        $data .= '</table>';

        wp_send_json([
            
            'data' => $data
        ]);


    }


    public function user_nominations_form() {


//        print_r($_FILES);
//        die();

//        require_once ABSPATH . 'wp-admin/includes/image.php';
//        require_once ABSPATH . 'wp-admin/includes/file.php';
//        require_once ABSPATH . 'wp-admin/includes/media.php';
//
//
//        foreach (['file', 'file2'] as $i) {
//            foreach ($_FILES[$i] as $section=>$file)
//                foreach ($file as $key=>$val)
//                    $files[$key][$section] = $val;
//
//
//            foreach ($files  as $section=>$file) {
//
//                if (!$file['name'])
//                    continue;
//
//                $ids[$section][$i] = (media_handle_sideload( $file, $post_id ));
//            }
//
//        }

//        print_r($ids);
//          die();




        $user_id = (int)$_POST['user_id'];
        $data =  $_POST['data'];

        $nominations = get_field('nominations', 'user_' . $user_id);
        $nominations_updated = $nominations;

        foreach ($nominations as $i => $value) {

            $nomination_id = $value['nomination'];

            foreach ($data as $key => $value) {

                //$keys[] = $nomination_id;

                if ($nomination_id === (int)$key) {
                    $nominations_updated[$i]['gallery'] = [ (int)$value['image']];
                    $nominations_updated[$i]['video'] = (int)$value['video'];
                }

            }

        }

       update_field('nominations',$nominations_updated, 'user_' . $user_id);


        wp_send_json($nominations_updated);
    }


    public function dropzonejs_upload() {


        if ( !empty($_FILES) ) {
            $files = $_FILES;
            foreach($files as $file) {
                $newfile = array (
                    'name' => $file['name'],
                    'type' => $file['type'],
                    'tmp_name' => $file['tmp_name'],
                    'error' => $file['error'],
                    'size' => $file['size']
                );

                $_FILES = array('upload'=>$newfile);
                foreach($_FILES as $file => $array) {
                    $newupload =  $this->insert_attachment($file);
                    wp_send_json([
                            'id' => $newupload,
                            'src' => wp_get_attachment_image_url($newupload, 'medium')
                        ]
                    );
                }
            }
        }





        die();
    }



    function register_user(){

        /*
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        */
        
        $success = false;
        $message = '';

        //Default 
        $user_name = stripcslashes($_POST['email']);
        $user_email = stripcslashes($_POST['email']);
        $user_pass = stripcslashes($_POST['password1']);
        $user_nice_name = strtolower($_POST['email']);
        $user_role = stripcslashes($_POST['user-type']);
        if($_POST['name']){
            $user_display_name = stripcslashes($_POST['name']);   
            $user_first_last =  $this->parse_name(stripcslashes($_POST['name']));
        }

        
        $user_phone = stripcslashes($_POST['phone']);
        $reg_address = stripcslashes($_POST['address']);
        $reg_country = stripcslashes($_POST['country']);
        $reg_city = stripcslashes($_POST['city']);
        $reg_postcode = stripcslashes($_POST['postcode']);


        $is_participant = ($user_role == "participant") ? true : false;
        $is_judge = ($user_role == "judge") ? true : false;
        $is_sponsor = ($user_role == "sponsor") ? true : false;

        //Participant
        if($is_participant){
            $devision = stripcslashes($_POST['catRadios']);
            $team = stripcslashes($_POST['team']);
            $invoice_for =  stripcslashes($_POST['invoiceFor']);
            $total_price =  stripcslashes($_POST['total-price']);
            if($invoice_for != 'private'){
                $company_name = stripcslashes($_POST['invoiceCompany']);
                $company_reg_nr = stripcslashes($_POST['reg']);
                $company_vat = stripcslashes($_POST['vat']);
                $company_country = stripcslashes($_POST['invoiceCountry']);
                $company_full_address = stripcslashes($_POST['invoiceAddressInfo']);
            }
            $all_nominations = [];

            foreach($_POST as $key => $value) {
                if (strpos($key, 'online-') === 0) {
                    array_push($all_nominations, $value);
                }
                if (strpos($key, 'offline-') === 0) {
                    array_push($all_nominations, $value);
                }
            }

        }

        //Participant & Judge
        if($is_participant || $is_judge){
            $represent_country = stripcslashes($_POST['countryRepresent']);
        }
        

        // Judge 

        if($is_judge){
            $company_name = stripcslashes($_POST['company']);
            $regalia = stripcslashes($_POST['regalia']);
        }

        //Sponsor (invoicing)
        if($is_sponsor){
            
            $user_display_name = stripcslashes($_POST['invoiceCompany']);
            $user_first_last =  $this->parse_name(stripcslashes($_POST['invoiceCompany']));
            $invoice_for =  stripcslashes($_POST['invoiceFor']);

            $sponsor_package_id =  stripcslashes($_POST['packageRadios']);


            $total_price =  get_field('field_60819d6393b13', $sponsor_package_id);

            $company_name = stripcslashes($_POST['invoiceCompany']);
            $company_reg_nr = stripcslashes($_POST['reg']);
            $company_vat = stripcslashes($_POST['vat']);
            $company_country = stripcslashes($_POST['country']);
            $add_temp = $_POST['city'] . ' ' . $_POST['postcode'];
            $company_full_address = stripcslashes($add_temp);

        }

        $user_data = array(
            'user_login' => $user_name,
            'user_email' => $user_email,
            'user_pass' => $user_pass,
            'user_nicename' => $user_nice_name,
            'display_name' => $user_display_name,
            'role' => $user_role,
            'first_name' => $user_first_last[0],
            'last_name' => $user_first_last[1],
            
        );

        
        $user_id = wp_insert_user($user_data);

            if (!is_wp_error($user_id)) {

                if($is_participant) {
                    $this->add_participant($user_id, $devision, $represent_country, $all_nominations, $team);

                    if($invoice_for == 'private'){
                        $this->add_invoice_data($invoice_for, $user_id, $reg_address, $reg_city, $reg_country, $reg_postcode, '', '', '', $total_price);
                    } else {
                        $this->add_invoice_data($invoice_for, $user_id, $company_full_address, '', $company_country, '', $company_name, $company_reg_nr, $company_vat, $total_price);
                    }

                    $profile_image_id = $this->insert_attachment('profileImage', 'user_'.$user_id.'', 'field_60813af2e4e0e');
                }

                if($is_judge){
                    $this->add_judge($user_id, $represent_country, $company_name, $regalia);

                    $profile_image_id = $this->insert_attachment('profileImage', 'user_'.$user_id.'', 'field_60813af2e4e0e');
                }

                if($is_sponsor){
                    $this->add_invoice_data($invoice_for, $user_id, $company_full_address, '', $company_country, '', $company_name, $company_reg_nr, $company_vat, $total_price);
                    $this->add_sponsor($user_id, $sponsor_package_id);
                    $logo_id = $this->insert_attachment('companyLogo', 'user_'.$user_id.'', 'field_608199fdbbf29');
                }

                $this->add_additional_user_data($user_id, $reg_address, $reg_city, $reg_country, $reg_postcode, $user_phone);

                $success = true;
                $message = "Registrasion success";
            } else {
                if (isset($user_id->errors['existing_user_login'])) {
                $message = 'User name already exixts.';
                } else {
                $message = $user_id->get_error_message();
                }
            }

        wp_send_json([
                'success' => $success,
                'message' => $message,
                'username' => $user_name
            ]
        );
        

        wp_die();
    }

    private function insert_attachment( $file_handler,$acf_id='', $acf_field='' ) {
        
        if ( $_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK ) {
            return false; 
        }
    
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    
        $attach_id = media_handle_upload( $file_handler, 0 );

        if ($acf_id)
            update_field($acf_field, $attach_id, $acf_id);

        return $attach_id;
    }

    private function parse_name($full_name) {
            $parts = explode(" ", $full_name);

            if (count($parts) > 2) {
                $last = array_pop($parts);
                return [implode(" ", $parts), $last];
            }

            return [$parts[0], $parts[1]];
    }
    
    private function add_sponsor($user_id,  $sponsor_package_id){
        $user = 'user_'.$user_id.'';
        $package_object = get_post($sponsor_package_id);
        update_field( 'field_609540d373261', $package_object, $user);
    }

    private function add_judge($user_id, $country, $company, $regalia){

        $user = 'user_'.$user_id.'';

        update_user_meta( $user_id, '_sliced_client_business', $company );
        update_field( 'field_6081a017220dd', $regalia, $user);
        update_field( 'field_608e8353b5a19', $country, $user);
    }

    private function add_participant($user_id, $devision, $country, $all_nominations, $team){
        $user = 'user_'.$user_id.'';
        $devision_object =  get_post( $devision );
        
        $nominations_array = [];

        foreach($all_nominations as $nomination){
            $temp_array = [];
            $nomination_object = get_post( $nomination);
            $gallery_active = get_field( "field_608edebfd54c9", $nomination );
            $video_active = get_field( "field_608eded8d54ca", $nomination );
            $online_contest_url_active = get_field( "field_608edee0d54cb", $nomination );

            $temp_array = array(
                'field_6081664d82734' => $nomination_object,
                'field_60816812e7ea5' => $gallery_active,
                'field_608168e9562ae' => $video_active,
                'field_60816945c3988' => $online_contest_url_active
            );

            array_push($nominations_array, $temp_array);
        }

        if(!empty($team)){
            $team_object = $this->add_create_team($team, $user_id);
            update_field( 'field_609192499a8f9', $team_object, $user );
        }
        

        update_field( 'field_60819af1f75d0', $devision_object, $user ); 

        update_field( 'field_608e8353b5a19', $country, $user);
        update_field( 'field_608164444c690', $nominations_array, $user );
        

    }

    private function add_create_team($team, $user_id){
        $user_object = get_user_by('id', $user_id);
        $selected_team = get_page_by_title($team, OBJECT, 'team');

        if($selected_team == null) {
            $selected_team = get_post($team);
        }

        if($selected_team == null) {
            $team_id = wp_insert_post([
                'post_status' => 'publish',
                'post_type' => 'team',
                'post_title' => $team,
            ]);
            $selected_team = get_post($team_id);
        } 

        $row = array(
            'field_6091aaf7dbefe'   => $user_object
        );
        
        add_row('field_6091aaa2dbefd', $row, $selected_team->ID);

        return $selected_team;
        
    }

    private function add_additional_user_data($user_id, $address, $city, $country, $postcode, $phone){
        $user = 'user_'.$user_id.'';

        update_field( 'field_608077a57dc79', $address, $user);
        update_field( 'field_608078bc7dc7a', $city, $user);
        update_field( 'field_608078c47dc7b', $country, $user);
        update_field( 'field_608078fb7dc7c', $postcode, $user);
        update_field( 'field_6080792b7dc7d', $phone, $user);

    }
    
    private function add_invoice_data($type, $user_id, $address, $city, $country, $postcode, $company_name, $reg, $vat, $total) {

        $client = '';
        $client_address = 'Address: ' . $address . ', City: ' . $city . ', Country: ' . $country . ', Postcode: ' . $postcode;
        $other_info = '';
        $tax = false;

        if($type == 'private') {
            $user_info = get_userdata($user_id);
            $first_name = $user_info->first_name;
            $last_name = $user_info->last_name;
            $client_address = 'Address: ' . $address . ', City: ' . $city . ', Country: ' . $country . ', Postcode: ' . $postcode;

            $client = $first_name . ' ' . $last_name;
            $other_info = 'personal client';
        } else {
            $client = $company_name;
            if($type == 'eu-legal'){
                $tax = false;
                $other_info = 'VAT: ' . $vat;
            }else{
                $other_info = 'Reg. nr.: ' . $reg;
            }
            $client_address = 'Address: ' . $address . ', Country: ' . $country;
        }

        update_user_meta( $user_id, '_sliced_client_business', $client );
        update_user_meta( $user_id, '_sliced_client_address', $client_address  );
        update_user_meta( $user_id, '_sliced_client_extra_info', $other_info );

        $invoice_id = create_invoice($user_id, $tax, $total);
        $invoice_object = get_post( $invoice_id  );
        $user = 'user_'.$user_id.'';

        update_field( 'field_60819a5fbfc6c', $invoice_object, $user );
    
    }


}

new Ajax();


