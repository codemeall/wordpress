<?php
function email_shortcode( $atts, $content = null ){

	$atts = shortcode_atts(
		array(

			'email' => ''

			), $atts
	);

	global $wpdb;
	$search = $_POST['search'];
	  	$sql = "SELECT * FROM myplugin WHERE tag = '".$atts['email']."'";
	$result = $wpdb->get_results($sql) or die(mysql_error());

	$mail = "<form action='' method='post'>";
	$i=1;
	
	foreach( $result as $results ) {
		 $mail .= "<p>Here is My mail <i>". $results->email."</i></p>"."  "."";
		 $mail .= "<input name='tags".$i."' placeholder='Put a tag here..' value='".$results->tag."'' type='text'>";
		 $mail .= "<input class='ajax-btn' data-id='".$results->id."' type='submit' name='submit[]' value='Submit'>";
		 $i++;
						        
        }
   	 $mail .= "</form>";
   $hi = "am from shortcode";


   return $mail;
}
add_shortcode( 'My_Plugin_Code', 'email_shortcode' );

/*Example Shortcode*/
/*[My_Plugin_Code email=info]*/
?>