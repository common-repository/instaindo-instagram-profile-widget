<?php
function sho_data_profile_ig( $atts, $content = "" ) {
    
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

$a = shortcode_atts( array(
        'username' => $decode_ig_profile_wg[user][username],
        'full_name' => $decode_ig_profile_wg[user][full_name],
        'biography' => $decode_ig_profile_wg[user][biography],
        'following_count' => number_format($decode_ig_profile_wg[user][following_count]),
        'follower_count' => number_format($decode_ig_profile_wg[user][follower_count]),
        'profile_pic_url' => $decode_ig_profile_wg[user][profile_pic_url],
        'media_count' => number_format($decode_ig_profile_wg[user][media_count]),
        'external_url' => $decode_ig_profile_wg[user][external_url],
    ), $atts );
    
    
    return $a[$content];

    
}
add_shortcode( 'ig_profile', 'sho_data_profile_ig' );
?>