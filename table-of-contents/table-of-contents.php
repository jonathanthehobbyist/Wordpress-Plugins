<?php
/**
 * Plugin Name: Table of contents
 * Description: Adds a table of contents to pages and posts that use a newly installed template file called Table of Contents Template
 * Author: Jon Simmons
 */

//Add 3 files 1) ADDED template-tableofcontents.php in the active theme directory which calls 2) ADDED singular-tableofcontents.php in the active theme directory which needs 3) sidebar-tableofcontents.php in the active theme directory

// Hook the function to the WordPress 'init' action
add_action('init', 'mta_add_template_file');

add_action( 'widgets_init', 'table_of_contents_sidebar' );

function mta_add_template_file() {
    // Define the source template file path (inside the plugin folder)
    $source_template = plugin_dir_path(__FILE__) . 'templates/template-tableofcontents.php';

    // Define the destination path (inside the active theme folder)
    //This one must load into the active theme directory, all others can be called from the plugin directory
    $destination_template = get_stylesheet_directory() . '/templates/template-tableofcontents.php';

    // Check if the template already exists in the theme directory
    if (!file_exists($destination_template)) {

        // Copy the file from the plugin folder to the theme folder
        copy($source_template, $destination_template);
    }

    //Global variable
    //$plugin_template_path = plugins_url ('templates/singlar-tableofcontents.php',__FILE__);
    define('table_of_contents_dir', plugin_dir_path(__FILE__));

        //DELETE by 9.01.24

    //adding other files, will need the conditional to check if they exist
   // $source_singular = plugin_dir_path(__FILE__) . 'templates/singular-tableofcontents.php';
   // $destination_singular = get_stylesheet_directory() . '/singular-tableofcontents.php';
    //copy($source_singular, $destination_singular);

	//adding other files, will need the conditional to check if they exist
    //$source_sidebar = plugin_dir_path(__FILE__) . '/sidebar-tableofcontents.php';
    //$destination_sidebar = get_stylesheet_directory() . '/sidebar-tableofcontents.php';
   // copy($source_sidebar, $destination_sidebar);

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

