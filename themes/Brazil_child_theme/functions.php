<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 15 );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

add_action( 'wp_enqueue_scripts', 'wpse26822_script_fix' );
function wpse26822_script_fix()
{
    wp_dequeue_script( 'parent_theme_script_handle' );
    wp_enqueue_script( 'child_theme_script_handle', get_stylesheet_directory_uri() . '/assets/js/child.js', array( 'jquery' ) );
}


?>