<?php
add_action('widgets_init','widget_ig_profile_styles');

function widget_ig_profile_styles(){
wp_enqueue_style( 'widget_ig_profile_styles', plugins_url( 'css/style_ig_counter.css' , __FILE__ ) );
wp_enqueue_style( 'widget_ig_profile_styles', plugins_url( 'css/ig-font-awesome.min.css' , __FILE__ ) );
}

class ig_profile_widget extends WP_Widget {
          function ig_profile_widget() {
                    $widget_ops = array(
                    'classname' => 'ig_profile_widget',
                    'description' => 'widget for instagram profile'
          );

          $this->WP_Widget(
                    'ig_profile_widget',
                    'Profile Widget For Insta',
                    $widget_ops
          );
}

function form($instance) {
	$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'text_domain' );
	?>
	<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title') ); ?>">
	<?php esc_attr_e( 'Title:', 'text_domain' ); ?>
	</label> 
	
	<input 
		class="widefat" 
		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
		type="text" 
		value="<?php echo esc_attr( $title ); ?>">
	</p>
	<?php
}

function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

	return $instance;
}

          function widget($args, $instance) { // widget sidebar output
                    extract($args, EXTR_SKIP);
                    echo $before_widget; // pre-widget code from theme
                    
          if ( ! empty( $instance['title'] ) ) {
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
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
<div class="card">
  <hr>
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

<?php
                    echo $after_widget; // post-widget code from theme
          }
}

add_action(
          'widgets_init',
          create_function('','return register_widget("ig_profile_widget");')
);
?>