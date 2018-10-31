<?php
   /*
   Plugin Name: Howdy No!
   Plugin URI: https://bhotzel.com/plugins/howdy-no/
   Description: This plugin will remove "Howdy" before your user name.
   Version: 1.0
   Author: Brandon Hotzel
   Author URI: https://bhotzel.com/plugins/howdy-no/
   License: GPL2
   */


if (is_admin()) {
	function wp_change_howdy() {
	    add_options_page('Howdy No!', 'Howdy No!', 'manage_options',  basename(__FILE__), 'wp_replace_howdy');
	}
	add_action('admin_menu', 'wp_change_howdy');
}

function wp_replace_howdy(){
	if(isset($_POST['howdyreplacetext'])){
		$nonce = $_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce, 'php-the-howdy-update' ) ) {
            die('security error');
        }
		$howdyreplacetext = $_POST['howdyreplacetext'];
		update_option( 'wp_howdyreplacetext', $howdyreplacetext );

	}

	$wp_howdyreplacetext=get_option('wp_howdyreplacetext');
	?>	
    <div class="bootstrap-wrapper">
    	<form action="" method="post">
	    	<?php wp_nonce_field('php-the-howdy-update'); ?>
	      	<div class="row" style="margin:0px;margin-top:20px;">
	      		<h2 class="hndle ui-sortable-handle">Replace Howdy with another Word</h2>
		        <div class="form-horizontal" style="margin-top:40px;"> 
		          <div class="form-group">       
		            <label for="replace_howdy_text" class="control-label col-xs-2">What word do you want to replace howdy with?</label>
                      
		            <div class="col-xs-8">
		              <input class="form-control" type="text" id="replace_howdy_text" placeholder="Write a word" name ='howdyreplacetext' value= '<?php echo $wp_howdyreplacetext ; ?>' />
		            </div>
		          </div>
		        </div>
	    	</div>
	    	<div class="form-group">
	    		<div class="col-xs-10">
	    			<input style="float:right; margin-right:40%;" type="submit" value="Save Changes" class="button-primary control-label col-xs-2" id="submit" name="submit" />
	    		</div>
	    	</div>
    	</form>
    </div>
	<?php
}
function replace_the_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $howdyreplacetext = get_option('wp_howdyreplacetext') ;
    $newtitle = str_replace( 'Howdy', $howdyreplacetext, $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
//add_filter( 'admin_bar_menu', 'replace_the_howdy',25 );

if ( get_option('wp_howdyreplacetext')) {
	add_filter( 'admin_bar_menu', 'replace_the_howdy',25 ); 
}