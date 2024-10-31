<?php
/*
Plugin Name: multilang Comment
Plugin URI: https://plus.google.com/+BharatDangarphpdeveloper
Description: Plugin provide functionality for comment in multilang
Author: Bharat Dangar
Version: 1.0
Author URI: https://plus.google.com/+BharatDangarphpdeveloper
*/

// define plugin defaults
function brtcmt_add_defaults() {
	$tmp = get_option('brtcmt_options');
		if(($tmp['brtcmt_default_options_db']=='1')||(!is_array($tmp))) {
		$arr = array(	"lang_select" => "true",
				"toggle_switch_place" => "comment_form_top",
				"brtcmt_default_options_db" => "",
				"comment_switch_txt" => "Click this button or press <strong>Ctrl+G</strong> to toggle between multilang and English"
		);
		update_option('brtcmt_options', $arr);
	}
}
register_activation_hook(__FILE__, 'brtcmt_add_defaults' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function brtcmt_delete_plugin_options() {
	delete_option('brtcmt_options');
}
register_uninstall_hook(__FILE__, 'brtcmt_delete_plugin_options');

function brtcmt_init(){
	register_setting( 'brtcmt_plugin_options', 'brtcmt_options' );
}
add_action( 'admin_init', 'brtcmt_init' );

// Add menu page
function brtcmt_add_options_page() {
	add_options_page('multilang Comment Options Page', 'multilang Comment', 'manage_options', __FILE__, 'brtcmt_options_form');
}
add_action( 'admin_menu', 'brtcmt_add_options_page' );

function brtcmt_enqueue_scripts() {
	if( is_singular() && comments_open() ) {
  wp_enqueue_script( 'google-jsapi', '//www.google.com/jsapi', array(), '', false );
  wp_enqueue_script( 'multilang-comment-js', plugins_url( '/brtcmt.js' , __FILE__ ), array(), '', false );
  	}
}
add_action( 'wp_enqueue_scripts', 'brtcmt_enqueue_scripts' );

// echo mrcmlang variable in head
function brtcmt_lang_var() {
	$options = get_option('brtcmt_options');
	$language = $options['lang_select'];
?>
<script type="text/javascript">      
        var mrcmlang = <?php echo $language; ?>;
</script>
<?php
}
add_action( 'wp_print_scripts', 'brtcmt_lang_var' );


// Plugin options form
function brtcmt_options_form() {
	?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>multilang Comment Plugin Options</h2>

		<form method="post" action="options.php">
			<?php settings_fields('brtcmt_plugin_options'); ?>
			<?php $options = get_option('brtcmt_options'); ?>

			<table class="form-table">

				<tr valign="top">
					<th scope="row">Default Language</th>
					<td>
						<label><input name="brtcmt_options[lang_select]" type="radio" value="hi" <?php checked('true', $options['lang_select']); ?> /> Hindi </label><br />

						<label><input name="brtcmt_options[lang_select]" type="radio" value="en" <?php checked('false', $options['lang_select']); ?> /> English </label><br />
					</td>
				</tr>

				<tr>
					<th scope="row">Transliteration Controller Title</th>
					<td>
						<input type="text" size="45" name="brtcmt_options[comment_switch_txt]" value="<?php echo $options['comment_switch_txt']; ?>" />
					</td>
				</tr>
				
				
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
<hr />
<p style="margin-top:15px;font-size:14px;">If you have found this plugin is useful, please consider making a <a href="https://plus.google.com/+BharatDangarphpdeveloper" target="_blank">Visit</a>. Thank you!</p>
	</div>
<?php	
}


// Display a Settings link on the main Plugins page
function brtcmt_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {
		$brtcmt_links1 = '<a href="'.get_admin_url().'options-general.php?page=multilang-comment/multilang-comment.php">'.__('Settings').'</a>';
		$brtcmt_links2 = '<a href="https://plus.google.com/+BharatDangarphpdeveloper" title="multilang Comment plugin support Contact" target="_blank">'.__('Support').'</a>';
		array_unshift( $links, $brtcmt_links1, $brtcmt_links2 );
	}

	return $links;
}
add_filter('plugin_action_links', 'brtcmt_plugin_action_links', 10, 2 );

// Donate link on manage plugin page
function brtcmt_pluginspage_links( $links, $file ) {

$plugin = plugin_basename(__FILE__);

// create links
if ( $file == $plugin ) {
return array_merge(
$links,
array( '<a href="https://plus.google.com/+BharatDangarphpdeveloper" target="_blank" title="Author">Find Author</a>'
 )
);
			}
return $links;

	}
add_filter( 'plugin_row_meta', 'brtcmt_pluginspage_links', 10, 2 );
