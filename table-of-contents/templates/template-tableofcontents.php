<?php
/**
 * Template Name: Table of Contents Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

//original call
//get_template_part( 'singular-tableofcontents' );

//new
//installed into active theme directory, so calling out to plugin directory
include WP_PLUGIN_DIR . '/table-of-contents/templates/singlar-tableofcontents.php';


