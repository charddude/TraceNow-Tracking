// Tracking JQuery call

function submit_me(){
		jQuery.post(the_ajax_script.ajaxurl, jQuery('#theForm').serialize()
		,
		function(response_from_tracking_function){
			jQuery("#response_area").html(response_from_tracking_function);
			}
		);
		
		jQuery('#theForm').find('input[type=text]').val('Consignment No');
		

		/*var img = $('<img id="dynamic">'); //Equivalent: $(document.createElement('img'))
		img.attr('deliverysignature', responseObject.imgurl);
		img.appendTo('#imagediv');*/
		
		jQuery("#imagediv").append("<img id='theImg' src='http://resources.tracenow.net/" + consignment.find("deliverysignature").text() + "'/>");
		
		
}
