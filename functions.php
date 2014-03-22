<?php

function my_login_stylesheet() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_stylesheet_directory_uri() . '/style-login.css'; ?>" type="text/css" media="all" />
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'drumoff.tv';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function responsive_child_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'responsive-child-style-extra', get_stylesheet_directory_uri() . '/style-extra.css' );
    wp_enqueue_style( 'responsive-child-style-extra' );
    wp_register_style( 'share-buttons-style', get_stylesheet_directory_uri() . '/share-buttons.css' );
    wp_enqueue_style( 'share-buttons-style' );
    wp_register_script( 'share-buttons-script', get_stylesheet_directory_uri() . '/share-buttons.js', array('jquery'));
    wp_enqueue_script( 'share-buttons-script' );
}
add_action( 'wp_enqueue_scripts', 'responsive_child_add_my_stylesheet' );

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
