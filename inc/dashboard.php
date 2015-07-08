<?php
/**
 * flux Dashboard Hacks
 *
 * @package flux
 */

/**
 * Update Email Address for WordPress
 */
	// AUTO-DETECT THE SERVER
	function rdm_filter_wp_mail_from($email){
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
	add_filter("wp_mail_from", "rdm_filter_wp_mail_from");

    // FROM EMAIL NAME
    function rdm_filter_wp_mail_from_name($from_name){
        return "Web Master";
    }
    add_filter("wp_mail_from_name", "rdm_filter_wp_mail_from_name");

/**
 * Add Site Logo to login screen
 */
