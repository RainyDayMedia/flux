<?php
/**
 * flux Dashboard Hacks
 *
 * @package flux
 */

/*-----------------------------------------------------------------------------------*/
/* Update Email Address for WordPress
/* ----------------------------------------------------------------------------------*/
// AUTO-DETECT THE SERVER
add_filter("wp_mail_from", "flux_filter_wp_mail_from");
function flux_filter_wp_mail_from($email){
	// START OF CODE LIFTED FROM WORDPRESS CORE
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
		$sitename = substr( $sitename, 4 );
	}
	// END OF CODE LIFTED FROM WORDPRESS CORE
	$myfront = "web-master@";
	$myback = $sitename;
	$myfrom = $myfront . $myback;
	return $myfrom;
}

// FROM EMAIL NAME
add_filter("wp_mail_from_name", "flux_filter_wp_mail_from_name");
function flux_filter_wp_mail_from_name($from_name){
    return "Web Master";
}

/*-----------------------------------------------------------------------------------*/
/* PREVENT USERS FROM BEING REMOVED/DELETED BY ID
/* ----------------------------------------------------------------------------------*/
	// DONT DELETE ME BRO
add_action('delete_user', 'flux_cant_delete_me');
function flux_cant_delete_me( $id ){
	$cant_delete_ids = array( 1, 2 );

	if ( in_array( $id, $cant_delete_ids ) )
		wp_die( 'OOPs seems you are attempting an operation that is not possible.');
}

/*-----------------------------------------------------------------------------------*/
/* REMOVE PERSONAL OPTIONS FROM PROFILE PAGE
/* ----------------------------------------------------------------------------------*/

// removes the `profile.php` admin color scheme options
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

if ( ! function_exists( 'flux_remove_personal_options' ) ) {

    // removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
  function flux_remove_personal_options( $subject ) {
    $subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
    return $subject;
  }

  function flux_profile_subject_start() {
    ob_start( 'flux_remove_personal_options' );
  }

  function flux_profile_subject_end() {
    ob_end_flush();
  }
}
add_action( 'admin_head-profile.php', 'flux_profile_subject_start' );
add_action( 'admin_footer-profile.php', 'flux_profile_subject_end' );

class RDM_User_Caps {

    // add some filters
  function RDM_User_Caps(){
    add_filter( 'editable_roles', array(&$this, 'editable_roles'));
    add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }

    // remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }

    // don't allow users to edit or delete unless they are an admin
  function map_meta_cap( $caps, $cap, $user_id, $args ){

    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }

}

$flux_user_caps = new RDM_User_Caps();
