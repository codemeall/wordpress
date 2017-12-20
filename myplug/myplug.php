<?php  
/*
Plugin Name: My Plugin
Plugin URI: #
Description: This Plugin Extract All Emails of a given web Page
Author: Abdul Aziz
Version: 1.0
Aurthor URI: #
*/

require_once ( plugin_dir_path( __file__ ) . 'email-shortcode.php' );


add_action('admin_menu','my_plugin_page');
function my_plugin_page(){
    add_menu_page('My First Plugin', 'My Plugin', 'administrator', 'my_plugin', 'the_page_function', 'dashicons-email-alt', '4');
}


function the_page_function(){
//code in the setting Page..
?>
    <div class="wrap">
        <h4>Welcome to My Plugin Page</h4>

        <form action="" method="post" id="email_form">
            <label>Enter URI here.</label><br>
            <input name="site" id="form_input" type="text">
            <input type="submit" value="submit" class="button button-primary button-large" id="submit_btn" name="submit">
            <input type="submit" name="get_all" class="button button-primary button-large" id="get_btn" value="Get Emails">
            <input type="text" name="search">
            <input type="submit" name="search_btn" class="button button-primary button-large"  value="Search">
            
        </form>
        <?php
        $i = 0;
        global $wpdb;

            if(isset($_POST['submit'])){
                 
                //$homepage = file_get_contents('http://sizmic.com/contact.php');
                $url=$_POST['site'];
                $homepage = file_get_contents($url);

                 //echo $homepage;
                $html_encoded = htmlentities($homepage);
                //echo $html_encoded;
                //$html_encoded = "mdab.aziz01@gmail.com and mdab_aziz01@yahoo.com";
                preg_match_all('/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i', $html_encoded, $matches);
                   
                //print_r($matches);    
                //echo $url
			        
			        foreach ($matches[0] as $email) {
			        	$wpdb->insert( 
								'myplugin', 
								array( 
								'email' => $email 
									),
								array( 
								'%s'
								));
					}
            }

            if(isset($_POST['get_all'])) {

            	$sql = "SELECT * FROM myplugin";
            	$result = $wpdb->get_results($sql) or die(mysql_error());
            	?>

            	<table class="widefat">
                    <tr>
				        <th>
				            Id
				        </th>
				        <th>
				            Email
				        </th>
				        <th>
				        	Tag
				        </th>
					</tr>
					<form action="" method="post" id="table_form">					   
						<?php
			            	foreach( $result as $results ) {
			            		
						        echo "<tr><td>". $results->id."</td>";
						        echo "<td>".$results->email."</td>";
						        echo "<td><input name='tag[]' placeholder='Put a tag here..' value='".$results->tag."'' type='text'></td></tr>";
						    }
					    ?>
					    <input type="submit" name="update_all" class="button button-primary button-large" id="update_btn" value="Update">

				    </form>
				  
		        </table>
	        <?php
	  		 }

	  		  if (isset($_POST['search_btn'])) {

	  		   	# code...
	  		   	$search = $_POST['search'];
	  		  	$sql = "SELECT * FROM myplugin WHERE tag Like '%$search%'";
            	$result = $wpdb->get_results($sql) or die(mysql_error());
            	?>

            	<table class="widefat">
                    <tr>
				        <th>
				            Id
				        </th>
				        <th>
				            Email
				        </th>
				        <th>
				        	Tag
				        </th>
					</tr>
					<form action="" method="post" id="table_form">					   
						<?php
			            	foreach( $result as $results ) {
			            		
						        echo "<tr><td>". $results->id."</td>";
						        echo "<td>".$results->email."</td>";
						        echo "<td><input name='tag[]' placeholder='Put a tag here..' value='".$results->tag."'' type='text'></td></tr>";
						    }
					    ?>
					    <input type="submit" name="update_all" class="button button-primary button-large" id="update_btn" value="Update">

				    </form>
				  
		        </table>
			<?php
	  		   } 
		  		  if (isset($_POST['update_all'])){
				  			 foreach($_POST['tag'] as $value) {
				  			 	$i++;
							  // do what you want with the $value
				  			 	$wpdb->update( 
									'myplugin', 
									array( 
										'tag' => $value 
									), 
									array( 'id' => $i ), 
									array( 
										'%s'						 
								));
							 }	
				  }
	 		 ?>	
	 		 
    </div>
<?php
}
?>
<?php
function my_ajax(){
	wp_enqueue_script('my-ajax', plugins_url('/wp_ajax.js',__FILE__), array('jquery'), true);
	wp_localize_script('my-ajax', 'my_url', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));
}
add_action('wp_enqueue_scripts','my_ajax');

add_action( 'wp_ajax_ajax_fun', 'ajax_fun' );
add_action( 'wp_ajax_nopriv_ajax_fun', 'ajax_fun' );
function ajax_fun() {
	global $wpdb;
	$tg = $_POST['input_val'];
	$id = $_POST['id'];
 //echo $id;
	$wpdb->update( 
			'myplugin', 
			array( 
				'tag' => $tg 
			), 
			array( 'id' => $id ), 
			array( 
				'%s'						 
		));
 wp_die();
}
?>
