<?php
/*
Plugin Name: Share Buttons
Description: Share buttons for social sites, with share count.
Version: 1.0
Author: Alistair Buxton
License: GPL2
*/
/*  Copyright 2012 Alistair Buxton <a.j.buxton@gmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/





function social_logo($url, $title, $where, $target) {
    return '<a class="sb-logo" href="'.$url.'" title="'.$title.'"' . ($target ? ' target="_blank"' : '') .'>'.
             '<img class="sb-logo" src="http://dev.drumoff.tv/wp-content/plugins/wordpress-social-login/assets/img/32x32/flat/'.$where.'.png" />'.
           '</a>';
}


function share_button($where, $displaywhere, $what, $displaywhat, $shareurl, $searchurl) {

    return '<div class="sb-main">'.
             social_logo($shareurl, 'Share '.$displaywhat.' on '.$displaywhere, $where, $target=true).
             '<a class="sb-count" href="'.$searchurl.'" title="See what others are saying" target="_blank">'.
               '<div class="sb-count">'.
                 '<span class="sb-'.$where.'-'.$what.'-count sb-count">...</span>'.
               '</div>'.
             '</a>'.
           '</div>';

}

function social_button($url, $where) {
    return '<div class="sb-main">'.
             social_logo($url, $url, $where, false).
           '</div>';
}

function share_button_twitter($url, $what, $displaywhat) {
    return share_button('twitter', 'Twitter', $what, $displaywhat, 'http://twitter.com/share?url=http%3A%2F%2F'.$url.'&via=DrumOffTV', 'http://twitter.com/search?q='.$url.'&src=typd');
}

function share_button_facebook($url, $what, $displaywhat) {
    return share_button('facebook', 'Facebook', $what, $displaywhat, 'http://facebook.com/share.php?u=http%3A%2F%2F'.$url, 'http://facebook.com/search.php/search?q='.$url.'&type=eposts');
}

function share_button_gplus($url, $what, $displaywhat) {
    return share_button('gplus', 'Google+', $what, $displaywhat, 'http://plus.google.com/share?url=http%3A%2F%2F'.$url, 'https://plus.google.com/s/'.$url.'/posts');
}

function all_share_buttons($url, $what, $displaywhat, $style) {
    $url = rawurlencode($url);
    return '<div class="sb-container '.$style.'"><ul><li class="sb-first">'.
             share_button_twitter($url, $what, $displaywhat).
           '</li><li>'.
             share_button_facebook($url, $what, $displaywhat).
           '</li><li>'.
             share_button_gplus($url, $what, $displaywhat).
           '</li></ul></div>'.
           '<script type="text/javascript">kickoff("'.$url.'", "'.$what.'");</script>';
}

function all_social_buttons($style) {
    return '<div class="sb-container '.$style.'"><ul><li>'.
             social_button('http://twitter.com/DrumOffTV', 'twitter').
           '</li><li>'.
             social_button('http://facebook.com/DrumOffTV', 'facebook').
           '</li><li>'.
             social_button('https://youtube.com/DrumOffTV', 'google').
           '</li><li>'.
             social_button('https://plus.google.com/113298069201230335007', 'gplus').
           '</li></ul></div>';
}


function share_buttons_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'share-buttons-style', plugins_url('share-buttons.css', __FILE__) );
    wp_enqueue_style( 'share-buttons-style' );
    wp_register_script( 'share-buttons-script', plugins_url('share-buttons.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'share-buttons-script' );
}
add_action( 'wp_enqueue_scripts', 'share_buttons_add_my_stylesheet' );



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


// Prevent name conflict in Wordpress updates.

add_action( 'plugins_loaded', function(){
    add_filter( 'site_transient_update_plugins', function ( $value ) 
    {
        if( isset( $value->response['share-buttons/share-buttons.php'] ) )
            unset( $value->response['share-buttons/share-buttons.php'] );
        return $value;
    });
});


?>
