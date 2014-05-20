<?php

function share_buttons_add_my_stylesheet() {
    wp_register_style( 'share-buttons-style', get_stylesheet_directory_uri() . '/share-buttons.css' );
    wp_enqueue_style( 'share-buttons-style' );
    wp_register_script( 'share-buttons-script', get_stylesheet_directory_uri() . '/share-buttons.js', array('jquery'));
    wp_enqueue_script( 'share-buttons-script' );
}
add_action( 'wp_enqueue_scripts', 'share_buttons_add_my_stylesheet' );

require('share-buttons.php');

function sharing_func( $atts ) {
	extract( shortcode_atts( array(
		'url' => '',
		'what' => '',
                'displaywhat' => '',
                'style' => ''
	), $atts ) );

	return all_share_buttons($url, $what, $displaywhat, $style);
}
add_shortcode( 'share-buttons', 'sharing_func' );

?>
