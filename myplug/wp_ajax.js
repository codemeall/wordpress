jQuery(document).ready( function($) {
 $('.ajax-btn').click(function(){
	var ab = $(this).prev().val();
	var id = $(this).attr('data-id');
	//alert(datt);
	$.ajax({
		url: my_url.ajax_url,
		type: 'post',
		data: {
			action: 'ajax_fun',
			input_val: ab,
			id: id

		},
		success: function( data ) {
			
			//$('.entry-content').css("background", data);
			alert("Data Updated!");
			   
		}		
	});


 });


});