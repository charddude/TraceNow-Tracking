<?php
 /*
 Plugin Name: TraceNow Tracking
 Plugin URI: http://www.titandesign.co.uk
 Description: A simple parcel tracking plugin for Codeway TraceNow.
 Version: 4.0
 Author: Richard King
 Author URI: http://www.titandesign.co.uk/
 
 License: GPL-2.0+
 License URI: http://www.opensource.org/licenses/gpl-license.php 
 */
 

 
 // ENQUEUE AND LOCALISE SCRIPTS
 

 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'ajax.js', array( 'jquery' ) );
 
 wp_enqueue_style( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'style.css' );
 
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 
 
 
 // THE TRACKING FUNCTION
 
 if( !class_exists( 'WP_Http' ) )
    include_once( ABSPATH . WPINC. '/class-http.php' );
	
 
 function tracking_function(){ 
 
 	//if ( isset( $_POST['consignmentNumber'] ) && '1' == $_POST['consignmentNumber'] ) {
		
		$consignmentNumber = $_POST['consignmentNumber'];
		
  		$url = ('http://services.tracenow.net/TraceNowAccess.asmx/GetConsignment?consignmentNumber=' .($consignmentNumber) .'&memberGuid=d5dbffb4-0336-44bf-b72c-00fb9aaac759');
		
		$args = array(
					
					'method' => 'GET',
					
					'timeout' => 45,
					
					'redirection' => 5,
					
					'httpversion' => '1.1',
					
					'content-type' => 'application/x-www-form-urlencoded',
					
					'body' => array(),
					
					'headers' => array(),
					
					'blocking' => true,
					
					'cookies' => array(),
					
					'connection' => 'close',
					
    				);
					
		$response = wp_remote_get( $url, $args );
		
		if ( is_wp_error( $response ) ) {
		
   				$error_message = $response->get_error_message();
				
  					 echo "Something went wrong: $error_message";
					 
				} else {
						/*
						 //create new document object
 							$dom_object = new DOMDocument();
						 //load xml file
							$dom_object->load( $response );
 
							$item = $dom_object->getElementsByTagName("item");
 
							foreach( $item as $value )
 								{
								 $consigns = $value->getElementsByTagName("consignment");
								 $consignment  = $consigns->item(0)->nodeValue;
 
								 $consignmentnumbers = $value->getElementsByTagName("consignmentnumber");
								 $consignmentnumber  = $consignmentnumbers->item(0)->nodeValue;
 
								 $customerrefs = $value->getElementsByTagName("customerref");
								 $customerref  = $customerrefs->item(0)->nodeValue;

								 $itemcounts = $value->getElementsByTagName("itemcount");
								 $itemcount  = $itemcounts->item(0)->nodeValue;

								 $names = $value->getElementsByTagName("name");
								 $name  = $names->item(0)->nodeValue;

								 $address1s = $value->getElementsByTagName("address1");
								 $address1  = $address1s->item(0)->nodeValue;
								
								 $address2s = $value->getElementsByTagName("address2");
								 $address2  = $address2s->item(0)->nodeValue;

								 $towns = $value->getElementsByTagName("town");
								 $town  = $towns->item(0)->nodeValue;

								 $countys = $value->getElementsByTagName("county");
								 $county  = $countys->item(0)->nodeValue;
								
								 $postcodes = $value->getElementsByTagName("postcode");
								 $postcode  = $postcodes->item(0)->nodeValue;
								
								 $countrys = $value->getElementsByTagName("country");
								 $country  = $countrys->item(0)->nodeValue;
								
								 $recipients = $value->getElementsByTagName("recipient");
								 $recipient  = $recipients->item(0)->nodeValue;
								
								 $statuss = $value->getElementsByTagName("status");
								 $status  = $statuss->item(0)->nodeValue;
								
								 $collecteds = $value->getElementsByTagName("collected");
								 $collected  = $collecteds->item(0)->nodeValue;
								
								 $delivereds = $value->getElementsByTagName("delivered");
								 $delivered  = $delivereds->item(0)->nodeValue;
								
								 $collectioncodes = $value->getElementsByTagName("collectioncode");
								 $collectioncode  = $collectioncodes->item(0)->nodeValue;
								
								 $deliverycodes = $value->getElementsByTagName("deliverycode");
								 $deliverycode  = $deliverycodes->item(0)->nodeValue;
							
								 $commentss = $value->getElementsByTagName("comments");
								 $comments  = $commentss->item(0)->nodeValue;
								
								 $createds = $value->getElementsByTagName("created");
								 $created  = $createds->item(0)->nodeValue;
								
								 $deliverylatitudes = $value->getElementsByTagName("deliverylatitude");
								 $deliverylatitude  = $deliverylatitudes->item(0)->nodeValue;

								 $deliverylongitudes = $value->getElementsByTagName("deliverylongitude");
								 $deliverylongitude  = $deliverylongitudes->item(0)->nodeValue;
								
								 $deliverysignatures = $value->getElementsByTagName("deliverysignature");
								 $deliverysignature  = $deliverysignatures->item(0)->nodeValue;
								
								 $deliveryimages = $value->getElementsByTagName("deliveryimage");
								 $deliveryimage  = $deliveryimages->item(0)->nodeValue;
								 
						echo '<h3>Consignment Details</h3>' .  '$consignment - $consignmentnumber - $customerref - $itemcount - $name - $address1 - $address2 - $town - $county - $postcode - $country - $recipient - $status - $collected - $delivered - $collectioncode - $deliverycode - $comments - $created - $deliverylatitude - $deliverylongitude - $deliverysignature - $deliveryimage - <br>';
						} */
						
						
						echo '<h3>Consignment Details</h3>' . '<pre>' . print_r($response['body'], true) . '</pre>';// this is passed back to the javascript function
						
						die();
					
						
						
 				} // end if	
 		//} // end if				
 }
 
 
 
 // THE AJAX ADD ACTIONS
 
 
 add_action( 'wp_ajax_the_ajax_hook', 'tracking_function' );
 
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'tracking_function' ); // need this to serve non logged in users


				
 // ADD TRACKING FORM TO THE PAGE
 
 function tracenow_frontend(){
 
 $the_form = '
 
 <form id="theForm" method="POST">
 
 <input id="consignmentNumber" name="consignmentNumber" value="Consignment No" type="text" />
 
 <input name="action" type="hidden" value="the_ajax_hook" /> <!-- this puts the action the_ajax_hook into the serialized form -->
 
 <input id="submit_button" value="Track" type="button" onClick="submit_me();" />
 
 </form>
 
 <div id="response_area">
 
 	Your tracking details will appear here
	
 <div id="imagediv">
 
 </div>
 
 
 </div>';// END DIV RESPONSE AREA
 
 return $the_form;
 
 }
 
 add_shortcode("tn_ajax_frontend", "tracenow_frontend");
 
 
