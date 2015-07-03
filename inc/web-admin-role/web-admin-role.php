<?php
/*
Plugin Name: Web Admin Role
Plugin URI:
Description: Creates a user role, Web Admin, for the client. It strips some capabilities to prevent the client from breaking things.
Version: 0.0.1
Author: Todd Miller
Author URI: http://rainydaymedia.net/
Copyright 2015 Todd Miller (email: todd@rainydaymedia.net)
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'after_switch_theme', 'flux_activate_web_admin_role' );
add_action( 'switch_theme', 'flux_deactivate_web_admin_role' );
add_filter( 'editable_roles', 'flux_filter_editable_roles' );

/**
 * Creates the Web Admin role with a subset of the Administrator capabilities
 */
function flux_activate_web_admin_role()
{
    // reset the web admin role to make sure it gets the correct capabilities
    if ( get_role( 'web_admin' ) !== null )
        remove_role( 'web_admin' );

    $caps = array(
            'activate_plugins'       => true,
            'create_users'           => true,
            'delete_others_pages'    => true,
            'delete_others_posts'    => true,
            'delete_pages'           => true,
            'delete_plugins'         => false,
            'delete_posts'           => true,
            'delete_private_pages'   => true,
            'delete_private_posts'   => true,
            'delete_published_pages' => true,
            'delete_published_posts' => true,
            'delete_themes'          => false,
            'delete_users'           => true,
            'edit_dashboard'         => true,
            'edit_files'             => false,
            'edit_others_pages'      => true,
            'edit_others_posts'      => true,
            'edit_pages'             => true,
            'edit_plugins'           => false,
            'edit_posts'             => true,
            'edit_private_pages'     => true,
            'edit_private_posts'     => true,
            'edit_published_pages'   => true,
            'edit_published_posts'   => true,
            'edit_theme_options'     => true,
            'edit_themes'            => false,
            'edit_users'             => true,
            'export'                 => true,
            'import'                 => true,
            'install_plugins'        => true,
            'install_themes'         => false,
            'list_users'             => true,
            'manage_admin_columns'   => true,
            'manage_categories'      => true,
            'manage_links'           => true,
            'manage_options'         => true,
            'moderate_comments'      => true,
            'promote_users'          => true,
            'publish_pages'          => true,
            'publish_posts'          => true,
            'read'                   => true,
            'read_private_pages'     => true,
            'read_private_posts'     => true,
            'remove_users'           => true,
            'switch_themes'          => false,
            'unfiltered_html'        => false,
            'update_core'            => false,
            'update_plugins'         => false,
            'update_themes'          => false,
            'upload_files'           => true
        );

    add_role( 'web_admin', 'Web Admin', $caps );
}

/**
 * Removes the Web Admin role when the theme is deactivated
 */
function flux_deactivate_web_admin_role()
{
    if ( get_role( 'web_admin' ) !== null )
        remove_role( 'web_admin' );
}

/**
 * Reorders the roles array to put Web Admin right before Administrator.
 * Removes the Administrator role if the user is not an admin.
 *
 * @param array $all_roles The WordPress roles array
 * @return array The updated roles array.
 */
function flux_filter_editable_roles( $all_roles )
{
    $roles = array( 'administrator' => $all_roles['administrator'],
                    'web_admin'     => $all_roles['web_admin']
                );

    foreach ( $all_roles as $role => $details ) {
        if ( $role !== 'administrator' && $role !== 'web_admin' ) {
            $roles[$role] = $all_roles[$role];
        }
    }

    // removes the administrator role from the list if the user is not an adminstrator
    if ( !current_user_can( 'administrator' ) )
        unset( $roles['administrator'] );

    return $roles;
}
