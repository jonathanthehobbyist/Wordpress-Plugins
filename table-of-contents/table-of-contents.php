<?php
/**
 * Plugin Name: Table of contents
 * Description: Adds a table of contents to pages
 * Version: 0.1
 * Author: Jon Simmons
 */

// Hook the function to the WordPress 'init' action
add_action('init', 'mta_add_template_file');
add_action( 'widgets_init', 'table_of_contents_sidebar' );

function mta_add_template_file() {
    // Define the source template file path (inside the plugin folder)
    $source_template = plugin_dir_path(__FILE__) . 'templates/template-tableofcontents.php';

    // Define the destination path (inside the active theme folder)
    $destination_template = get_stylesheet_directory() . '/template-tableofcontents.php';

    //ORGINAL CODE follows next 2 lines:
    // Check if the template already exists in the theme directory
    //if (!file_exists($destination_template)) {

    //DEVELOPEMENT ONLY
    //I want a new version to update every time

        // Copy the file from the plugin folder to the theme folder
        copy($source_template, $destination_template);
    //}  ORIGINAL CODE bracket - when put back original ^^, put back bracket
}

function table_of_contents_sidebar() {
    register_sidebar(
        array(
            'name'          => __( 'Table of Contents Sidebar', 'textdomain' ),
            'id'            => 'table-of-contents-sidebar',
            'description'   => __( 'A table of contents sidebar for Wordpress themes.', 'textdomain' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}

