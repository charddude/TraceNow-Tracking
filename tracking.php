<?php
 /*
 Plugin Name: TraceNow Tracking
 Plugin URI: http://www.titandesign.co.uk
 Description: A simple parcel tracking plugin for Codeway TraceNow.
 Version: 2
 Author: Richard King
 Author URI: http://www.titandesign.co.uk/
 
 License: GPL-2.0+
 License URI: http://www.opensource.org/licenses/gpl-license.php 
 */
 
// Create tracking nonce
 
 function tracking_nonce(){
 		 $nonce = wp_create_nonce( 'tracking_function' );
 }
 
 // enqueue and localise scripts
 
 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'ajax.js', array( 'jquery' ) );
 wp_enqueue_style( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'style.css' );
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 
 
 // THE AJAX ADD ACTIONS
 
 add_action( 'wp_ajax_the_ajax_hook', 'tracking_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'tracking_function' ); // need this to serve non logged in users
 
 
 // THE FUNCTION
 
 function tracking_function(){ 
 
 if( !class_exists( 'WP_Http' ) )
    include_once( ABSPATH . WPINC. '/class-http.php' );
		$host = $_SERVER['HTTP_HOST'] . $url;
		$consignmentNumber = $_GET['name'];
 		$memberGuid = $_POST['d5dbffb4-0336-44bf-b72c-00fb9aaac759'];
		$response = wp_remote_post( $url = ('http://services.tracenow.net/TraceNowAccess.asmx/GetConsignment'), array(
											'method' => 'POST',
											'timeout' => 45,
											'redirection' => 5,
											'httpversion' => '1.1',
											'blocking' => true,
											'headers' => array(),
											'body' => array( 'consignmentNumber' => $consignmentNumber, 'memberGuid' => $memberGuid ),
											'cookies' => array()
    									   )
									);
		if ( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
  					 echo "Something went wrong: $error_message";
				} else {
						echo 'Consignment details: ' .  urldecode( $_GET[ 'body' . data ] );// this is passed back to the javascript function
 				}
				
 }
				
 // ADD Tracking FORM TO THE PAGE
 
 function tracenow_frontend(){
 $the_form = '
 <form id="theForm">
 <input id="consignmentNumber" name="consignmentNumber" value="Consignment No" type="text" />
 <input name="action" type="hidden" value="the_ajax_hook" /> <!-- this puts the action the_ajax_hook into the serialized form -->
 <input name="memberGuid" type="hidden" value="" />
 <input id="submit_button" value ="Track" type="button" onClick="submit_me();" />
 </form>
 <div id="response_area">
 	Your tracking details will appear here
 </div>';
 return $the_form;
 }
 add_shortcode("tn_ajax_frontend", "tracenow_frontend");
 ?>
