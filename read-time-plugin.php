<?php

/*
Plugin Name: Read Time Progress Bar
Plugin URI: https://www.jonsimmons.co
Description: So readers can get a sense of how far they are through a given article
Author: Jon Simmons
Author URI: https://www.jonsimmons.co
version: 1.0.0
*/

/*  ----------- ENQUEUE SCRIPTS & STYLES ----------  */

function read_progress_enqueue_styles() {
    // Register the style
    wp_enqueue_style(
        'style-read-progress-bar', // Handle for the stylesheet
        plugin_dir_url(__FILE__) . 'css/style-read-progress-bar.css', // Path to the stylesheet
        array(), // Dependencies (if any)
        '1.0.0', // Version number (optional)
        'all' // Media type (optional, e.g., 'all', 'screen', 'print')
    );

    wp_enqueue_script(
        'read-progress-bar-js', // Handle for the stylesheet
        plugin_dir_url(__FILE__) . 'js/read-progress-bar.js', // Path to the stylesheet
        array(), // Dependencies (if any)
        '1.0.0', // Version number (optional)
        'all' // Media type (optional, e.g., 'all', 'screen', 'print')
    );

    $options = get_option( 'readprogress_options' );

    // Validate
    $read_progress_color = isset( $options['readprogress_field_pill'] ) ? $options['readprogress_field_pill'] : '';
    $read_progress_height = isset( $options['readprogress_field_height'] ) ? $options['readprogress_field_height'] : '';

    // Pass variables
     wp_localize_script( 'read-progress-bar-js', 'readProgressScriptData', array(
                        'readProgressColor' => $read_progress_color,
                        'readProgressHeight' => $read_progress_height,
                    ));
}

add_action('wp_enqueue_scripts', 'read_progress_enqueue_styles');


/*  ----------- SETTINGS PAGE ----------  */

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function readprogress_settings_init() {
    // Register a new setting for "read_progress" page.
    register_setting( 'readprogress', 'readprogress_options' );

    // Register a new section in the "readprogress" page.
    add_settings_section(
        'readprogress_section_developers',
        __( 'Settings', 'readprogress' ), 'readprogress_section_developers_callback',
        'readprogress'
    );

    // HEX field
    add_settings_field(
        'readprogress_field_pill', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Hex color', 'readprogress' ),
        'readprogress_field_pill_cb',
        'readprogress',
        'readprogress_section_developers',
        array(
            'label_for'         => 'readprogress_field_pill',
            'class'             => 'readprogress_row',
            'readprogress_custom_data' => 'custom',
        )
    );

    // Height Field
    add_settings_field(
        'readprogress_field_height', // Field ID
        __( 'Progress Bar Height', 'readprogress' ),  // LAbel
        'readprogress_field_height_cb', // Callback func to display input field
        'readprogress', // Page slug
        'readprogress_section_developers', // Section slug
        array(
            'label_for' => 'readprogress_field_height',
            'class' => 'readprogress_row',
            'readprogress_custom_data' => 'custom',
        )
    );
}

/**
 * Register our readprogress_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'readprogress_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */


/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function readprogress_section_developers_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Enter a hex color', 'readprogress' ); ?></p>
    <?php
}

/**
 * Pill field callbakc function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function readprogress_field_pill_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()

     $options = get_option( 'readprogress_options' );
    $read_progress_color = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : ''; // Get the current value
    ?>

    <input 
        type="text" 
        id="<?php echo esc_attr( $args['label_for'] ); ?>" 
        name="readprogress_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
        value="<?php echo esc_attr( $read_progress_color ); ?>" 
        data-custom="<?php echo esc_attr( $args['readprogress_custom_data'] ); ?>">

    <p class="description">
        <?php esc_html_e( 'Add a HEX color to be used as the background of the current / selected li:a section in the waypoint side menu', 'read_progress' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( 'No hashtag necessary', 'read_progress' ); ?>
    </p>
    <?php
    // Pass the value to JavaScript
    ?>
    <script type="text/javascript">
        window.readProgressColor = <?php echo json_encode( $read_progress_color ); ?>;
        console.log('Background Color Value:', readProgressColor); // Now the value is available in JS
    </script>


    <?php
}

function readprogress_field_height_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'readprogress_options' );
    $progress_bar_height = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : ''; // Get the current value
    ?>

    <input 
        type="text" 
        id="<?php echo esc_attr( $args['label_for'] ); ?>" 
        name="readprogress_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
        value="<?php echo esc_attr( $progress_bar_height ); ?>" 
        data-custom="<?php echo esc_attr( $args['readprogress_custom_data'] ); ?>">

    <p class="description">
        <?php esc_html_e( 'Enter the height of the progress bar in pixels (e.g., 5)', 'readprogress' ); ?>
    </p>
    <?php
}

/**
 * Add the top level menu page.
 */
function readprogress_options_page() {
    add_menu_page(
        'Read Progress Plugin', // on settings page: title
        'Read Progress', // Title on left menu
        'manage_options',
        'readprogress',
        'readprogress_options_page_html'
    );
}


/**
 * Register our readprogress_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'readprogress_options_page' );


/**
 * Top level menu callback function
 */
function readprogress_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'readprogress_messages', 'readprogress_message', __( 'Settings Saved', 'readprogress' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'readprogress_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "readprogress"
            settings_fields( 'readprogress' );
            // output setting sections and their fields
            // (sections are registered for "readprogress", each field is registered to a specific section)
            do_settings_sections( 'readprogress' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

?>
