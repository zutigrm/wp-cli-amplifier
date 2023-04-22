<?php
/**
 * Plugin Name: Cli Amplifier
 * Description: Useful collection of extended wp cli custom commands to help with various tasks that will help with maintaining the website
 * Version: 1.0
 * Author: Aleksej Vukomanovic
 * License: GPLv2 or later
 */

 if (!defined('ABSPATH')) {
    exit;
}

if ( ! defined( 'WCA_COMMANDS' ) ) {
    define( 'WCA_COMMANDS', 'commands/' );
}

// commands list
$commands = [
    'change-author',
    'change-post-status',
    'delete-trashed-posts',
    'regenerate-featured-images',
    'remove-shortcode-from-content',
    'update-image-alt-tags',
    'update-post-slugs',
];

/**
 * Include file for a custom wp cli command
 * 
 * @param $command_name string command file name
 */
function wca_include_command( $command_name )
{
    require_once WCA_COMMANDS . "$command_name.php";
}

/**
 * include the array of command names
 * 
 * @param $comamnds array
 */
function wca_include_commands( $commands )
{
    foreach ( $commands as $command )
    {
        wca_include_command( $command );
    }
}

if (defined('WP_CLI') && WP_CLI) {
    // include all commands php files
    wca_include_commands( $commands );

    // register commands
    WP_CLI::add_command( 'ca', 'Change_Author_WP_CLI_Command' );
    WP_CLI::add_command( 'ppd', 'PPD_WP_CLI_Command' );
    WP_CLI::add_command( 'dtp', 'Delete_Trashed_Posts_WP_CLI_Command' );
    WP_CLI::add_command( 'brfi', 'Bulk_Regenerate_Featured_Images_WP_CLI_Command' );
    WP_CLI::add_command( 'brsc', 'Bulk_Remove_Shortcodes_WP_CLI_Command' );
    WP_CLI::add_command( 'buiat', 'Bulk_Update_Empty_Image_Alt_Tags_WP_CLI_Command' );
    WP_CLI::add_command( 'bus', 'Bulk_Update_Post_Slugs_WP_CLI_Command' );
}