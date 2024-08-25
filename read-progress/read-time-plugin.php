<?php

/*
Plugin Name: Read Time Progress Bar
Plugin URI: https://www.jonsimmons.co
Description: So readers can get a sense of how far they are through a given article
Author: Jon Simmons
Author URI: https://www.jonsimmons.co
version: 1.001
*/

/* 

https://stackoverflow.com/questions/9141885/how-to-load-javascript-in-wordpress-plugin

*/

add_action('wp_enqueue_scripts','ava_test_init');

function ava_test_init() {
    wp_enqueue_script( 'read-progress-bar-js', plugins_url( '/js/read-progress-bar.js', __FILE__ ));
     wp_register_style( 'namespace', '/wp-content/plugins/read-progress-plugin/css/style-read-progress-bar.css' );
    wp_enqueue_style( 'namespace' );
}



?>
