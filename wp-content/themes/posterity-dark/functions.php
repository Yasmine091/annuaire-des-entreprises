<?php
// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

function posterity_dark_style(){
    global $wp_styles;

    //get current user.css dependencies
    $user_css_deps = $wp_styles->registered['posterity-a13-user-css']->deps;

    //register child theme style.css and add it with dependencies for user.css, to be sure it will be loaded after all other style files
    //it is useful for doing easier style overwrites
    wp_register_style('posterity-dark-style', get_stylesheet_directory_uri(). '/style.css', $user_css_deps, wp_get_theme()->get('Version') );

    //add child theme style.css as also needed for user.css
    array_push($wp_styles->registered['posterity-a13-user-css']->deps, 'posterity-dark-style');
}
//register it later then parent theme styles
add_action('wp_enqueue_scripts', 'posterity_dark_style', 27);