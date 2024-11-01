<?php
/* Plugin Name: Zipcode Lockdown
Plugin URI: https://wordpress.org/plugins/zipcode-lockdown
Description: Restrict access to pages based on the user's zipcode.
Version: 1.0
Author: CustomScripts
Author URI: https://customscripts.tech

Copyright 2009-2017  Christopher Buck  (email : support@customscripts.tech)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
  * Init Actions
  *
  */

/**
  * Admin Init Actions
  *
  */

add_action('admin_init', 'cst_zcld_add_metabox');

function cst_zcld_add_metabox(){
    new cst_zcld_metabox();
}

/**
  * Admin Print Styles
  */

add_action('admin_print_styles', 'cst_zcld_enqueue_meta_styling');
function cst_zcld_enqueue_meta_styling(){
        wp_enqueue_style( 'cst_admin_style', plugins_url('/assets/css/lockdown-admin.css',__FILE__), array(), null, false );
}
/** 
  * Constructor
  */
class cst_zcld_metabox{
    /*
     * Constructor that creates the meta box
     */
    public  function  __construct(){
        /**
         * Render and Add form meta box
         */
        add_meta_box('zcld-meta', 'Zipcode Lockdown', array($this, 'cst_zcld_meta_form'), 'page', 'side', 'default');
        /**
         * Save Metabox Data
         */
        add_action('save_post',array($this, 'cst_zcld_save_meta'),1,2);
    }


    /**
     * Render Form for Listing
     */
    function cst_zcld_meta_form() {
        /**
 * Create Metabox Form
 */
    
    /* Get Meta Value */
    function cst_zcld_get_metavalue( $id ){
        $val = get_post_meta( $id, '_cst_zcld_zipcodes', true );
        $val_str = '';
        if (isset($val) && $val != ''){
            $val_str = $val;
        }
        return $val_str;
    }
    /* Nonce Field Name */
    function cst_zcld_textarea_nonce(){
        $field_name = '_cst_zcld_zipcodes';
        wp_nonce_field( $field_name, $field_name . '_nonce' );
    }
    /* Pre-populate Metabox Form Field */
    function cst_zcld_textarea_switch( $id ){
        $val_str = cst_zcld_get_metavalue( $id );
        $textform = '';
        
        if ( $val_str == '' ){
            $textform = '<textarea id="cst-zcld-textarea" name="_cst_zcld_zipcodes" wrap="hard" cols="32" rows="8" placeholder="02215, 03301, 03801"></textarea>';
        } else {
            $textform = '<textarea id="cst-zcld-textarea" name="_cst_zcld_zipcodes" wrap="hard" cols="32" rows="8">' . $val_str . '</textarea>';
        }
        cst_zcld_textarea_nonce();
        return $textform;
    }
        global $post_id;
        ?>
    
        <table class="widefat">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: left;">
                        Enter a comma-separated list of zipcodes to which this page should be restricted. 
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: left;">
                    <?php
                        $text_form = cst_zcld_textarea_switch( $post_id );
                        echo $text_form;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <button type="submit" id="zcld-btn" name="zcld-btn" value="cst_zcld_form_action">Clear All</button>
                    </td>
                </tr>
                <tr>
                    <td id="cst-zcld-lockdown-attribution-wrapper" colspan="2" style="text-align: right;">
                        <div id="cst-zcld-lockdown-cslogo-wrapper">     <a href="http://customscripts.tech"><img id="cst-zcld-lockdown-cslogo" src="<?php echo plugins_url('/assets/images/logo-xsmall.png', __FILE__); ?>" title="Custom web apps, plugins, automation and tutorials" target="_blank"></a>
                        </div>
                        <div id="cst-zcld-lockdown-attribution-div">
                            <span id="cst-zcld-lockdown-attribution">Zipcode Lockdown by CSTech</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php
    }
    
    function cst_zcld_save_meta( $post_id ){
        $field_raw = '';
        $meta = get_post_meta( $post_id, '_cst_zcld_zipcodes', true );
        if ( isset( $meta ) && $meta != '' ){
            $clearout = true;
        } else {
            $clearout = false;
        }
        $output;
        if ( isset( $_POST['_cst_zcld_zipcodes'] ) && $_POST['_cst_zcld_zipcodes'] != '') {
            $field_raw = $_POST['_cst_zcld_zipcodes'];
            $output = sanitize_text_field( $field_raw );
            update_post_meta( $post_id, '_cst_zcld_zipcodes', $output );
        } elseif ( $clearout == true && $_POST['_cst_zcld_zipcodes'] == '' ) {
            update_post_meta( $post_id, '_cst_zcld_zipcodes', null);
        }
                          
    }
}

/**
  * Enqueue Script
  */
add_action ( 'init', 'cst_zcld_enqueue_lockdown_styling' );
function cst_zcld_enqueue_lockdown_styling(){
    wp_enqueue_style( 'cst_zcld_lockdown_style', plugins_url( '/assets/css/lockdown.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'cst_zcld_scripts' );
function cst_zcld_get_zipcodes( $id ){
    $meta = get_post_meta( $id, '_cst_zcld_zipcodes', true );
    if( isset($meta) && $meta != ''){
        $output = $meta;
    } else {
        $output = null;
    }
    return $output;
}
function cst_zcld_get_logo_url(){
    $output = get_custom_logo();
    return $output;
}

function cst_zcld_check_page(){
    $screen = get_current_screen();
    if ( $screen->post_type == 'page' ){
        wp_enqueue_script( 'cst_zipcode_admin', plugins_url('/assets/js/lockdown-admin.js', __FILE__) );
    }
}
add_action('in_admin_header', 'cst_zcld_check_page');
function cst_zcld_scripts(){
    
    $zips = cst_zcld_get_zipcodes( get_the_ID() );
    if($zips != ''){
        wp_enqueue_script('cst_zipcode_lockdown', plugins_url('/assets/js/zipcode-lockdown.js', __FILE__) );
    
        $params = array(
            'page_id' => get_the_ID(),
            'zipcodes' => cst_zcld_get_zipcodes( get_the_ID() ),
            /*'logo' => cst_zcld_get_logo_url(),
            'cslogo' => plugins_url('/assets/images/logo-xsmall.png', __FILE__)*/
        );

        wp_localize_script( 'cst_zipcode_lockdown', 'cst_zcld_params', $params );
    }
}

?>