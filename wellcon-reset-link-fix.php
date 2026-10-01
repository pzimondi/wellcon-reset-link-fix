<?php
/**
 * Plugin Name: WellCON Reset Link Fix
 * Description: Maps an email in MemberPress reset links (?action=reset_password&u=) to the username so invite links work on single site.
 */
add_action( 'init', function () {
	if ( ( $_GET['action'] ?? '' ) !== 'reset_password' || empty( $_GET['u'] ) ) {
		return;
	}
	$u = str_replace( ' ', '+', wp_unslash( $_GET['u'] ) ); // '+' in email arrives as a space
	if ( strpos( $u, '@' ) === false ) {
		return; // already a username
	}
	$user = get_user_by( 'email', $u );
	if ( $user ) {
		$_GET['u'] = $_REQUEST['u'] = $user->user_login;
	}
}, 0 );
