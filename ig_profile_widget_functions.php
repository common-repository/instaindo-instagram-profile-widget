<?php
add_action('admin_init','ig_profile_widget_styles');

function ig_profile_widget_styles(){
wp_enqueue_style( 'style_ig_counter', plugins_url( 'css/style_ig_counter.css' , __FILE__ ) );
wp_enqueue_style( 'ig-font-awesome.min', plugins_url( 'css/ig-font-awesome.min.css' , __FILE__ ) );
}

function ig_profile_widget()
{
    add_options_page( 'Profile Widget for Insta', 'Profile Widget for Insta', 'administrator', 'ig_profile_widget', 'ig_profile_widget_do_page' );
}

add_action('admin_menu', 'ig_profile_widget');

function ig_profile_widget_do_page()
{
?>

<div class="donate_jamal_plugin">
        <span><?php echo _e("If you're like this plugin, please buy me a cup of coffee :)"); ?></span>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ZQDAXT7NL5WQJ">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
    </div>
    
<h1>Setting Account</h1>
<div>Insert "User ID" Instagram in form below</div>
<div>How To Find Or Get Instagram User ID <a href="https://www.google.com/search?q=find+instagram+id" target="_blank">click here</a></div><br>
<form action="" method="POST">
  <input type="text" maxlength="50%" size="30" name="search" id="search" placeholder="type the user id here..">
  <input type="submit" name="submit" id="submit" value="Submit"> 
</form> 

<?php
session_start();
if(isset($_REQUEST['search'])){
$insta_id_widget = htmlspecialchars($_POST['search']);

$remote_get_ig_profile = wp_remote_get( 'https://i.instagram.com/api/v1/users/'.$insta_id_widget.'/info/' );
$remote_get_body_ig_profile = wp_remote_retrieve_body( $remote_get_ig_profile );
$decode_ig_profile_wg = json_decode($remote_get_body_ig_profile, true); 
$username = $decode_ig_profile_wg[user][username];
$fullname = $decode_ig_profile_wg[user][full_name];
$biography = $decode_ig_profile_wg[user][biography];
$following = $decode_ig_profile_wg[user][following_count];
$follower = $decode_ig_profile_wg[user][follower_count];
$profilepict = $decode_ig_profile_wg[user][profile_pic_url];
$post = $decode_ig_profile_wg[user][media_count];
$external_url = $decode_ig_profile_wg[user][external_url];

if ("" == $username) {
echo "<h1>NOT FOUND</h1>";
} else {

global $wpdb;
$wpdb->update( 
	'wp_insta_profile', 
	array( 
		'insta_id_widget' => $insta_id_widget	// string
	), 
	array( 'id' => 1 )
);

}

}
?>

<?php
global $wpdb;
$tabel = $wpdb->prefix . 'wp_insta_profile';
$get_results = $wpdb->get_results('SELECT insta_id_widget FROM wp_insta_profile WHERE id = 1');

foreach($get_results as $get_result){
$insta_id_widget = $get_result->insta_id_widget;
}

$remote_get_ig_profile = wp_remote_get( 'https://i.instagram.com/api/v1/users/'.$insta_id_widget.'/info/' );
$remote_get_body_ig_profile = wp_remote_retrieve_body( $remote_get_ig_profile );
$decode_ig_profile_wg = json_decode($remote_get_body_ig_profile, true); 
$username = $decode_ig_profile_wg[user][username];
$fullname = $decode_ig_profile_wg[user][full_name];
$biography = $decode_ig_profile_wg[user][biography];
$following = $decode_ig_profile_wg[user][following_count];
$follower = $decode_ig_profile_wg[user][follower_count];
$profilepict = $decode_ig_profile_wg[user][profile_pic_url];
$post = $decode_ig_profile_wg[user][media_count];
$external_url = $decode_ig_profile_wg[user][external_url];
?>

<hr>

<!-- Add icon library -->
<br>
<h1>Use This Widget</h1>
<div>Go to <b>Appearance</b> > Customize in the WordPress Administration Screens and click the <b>Widget</b> menu.</div><br>

<div class="card">
  <h1><?php  echo $username; ?></h1>
  <img src="<?php  echo $profilepict; ?>" style="width:50%">
  <p class="title_ig_counter"><?php  echo $fullname; ?></p>
  <p><?php  echo $biography; ?></p>
  <p><a href="<?php  echo $external_url; ?>" target="_blank"><?php  echo $external_url; ?></a></p>
  <div class="ig_counterdata">
                <ul>
                    <li>
                        <?php  echo number_format($post); ?>
                        <span>Post</span>
                    </li>
                    <li>
                        <?php  echo number_format($follower); ?>
                        <span>Followers</span>
                    </li>
                    <li>
                        <?php  echo number_format($following); ?>
                        <span>Following</span>
                    </li>
                </ul>
            </div>
  <p><a href="https://www.instagram.com/<?php  echo $username; ?>/" target="_blank"><button_ig_counter>Follow!</button_ig_counter></a></p>
</div>

<hr>
<br>
<html>
<head>
	<style type="text/css">
		/* Table */
		body {
			font-family: "lucida Sans Unicode", "Lucida Grande", "Segoe UI", vardana
		}
		.demo-table {
			border-collapse: collapse;
			font-size: 13px;
		}

		.demo-table th, 
		.demo-table td {
			padding: 7px 17px;
		}
		.demo-table .title {
			caption-side: bottom;
			margin-top: 12px;
		}

		.demo-table thead th:last-child,
		.demo-table tfoot th:last-child,
		.demo-table tbody td:last-child {
			border: 0;
		}

		/* Table Header */
		.demo-table thead th {
			border-left: 1px solid #c7ecc7;
			text-transform: uppercase;
		}

		/* Table Body */
		.demo-table tbody td {
			color: #353535;
			border-left: 1px solid #c7ecc7;
		}

		.demo-table tbody tr:nth-child(odd) td {
			background-color: #f4fff7;
		}

		.demo-table tbody tr:nth-child(even) td {
			background-color: #dbffe5;
		}

		.demo-table tbody td:nth-child(4),
		.demo-table tbody td:first-child,
		.demo-table tbody td:last-child {
			text-align: left;
		}

		.demo-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
			transition: all .2s;
		}

		/* Table Footer */
		.demo-table tfoot th {
			border-left: 1px solid #c7ecc7;
		}
		.demo-table tfoot th:first-child {
			text-align: left;
		}
	</style>
</head>
<body>
<h1>Custom Your Design With Shortcodes</h1>
<div>How to use <b>Shortcode</b> in wordpress <a href="https://www.google.com/search?q=how+to+use+shortcode+in+wordpress" target="_blank">click here</a></div><br>
    <br>
	<table class="demo-table">
		<thead>
			<tr>
				<th>DATA</th>
				<th>Shortcodes</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php  echo $username; ?></td>
				<td>[ig_profile]username[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo $fullname; ?></td>
				<td>[ig_profile]full_name[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo $biography; ?></td>
				<td>[ig_profile]biography[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo number_format($following); ?></td>
				<td>[ig_profile]following_count[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo number_format($follower); ?></td>
				<td>[ig_profile]follower_count[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo $profilepict; ?></td>
				<td>[ig_profile]profile_pic_url[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo number_format($post); ?></td>
				<td>[ig_profile]media_count[/ig_profile]</td>
			</tr>
			<tr>
				<td><?php  echo $external_url; ?></td>
				<td>[ig_profile]external_url[/ig_profile]</td>
			</tr>
		</tbody>
	</table>
</body>
</html>

<?php
}

require_once plugin_dir_path(__FILE__) . 'ig_profile_widget.php';
require_once plugin_dir_path(__FILE__) . 'ig_profile_shortcode.php';
?>