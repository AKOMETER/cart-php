<?php

session_set_cookie_params(time()+(30 * 60),'/','localhost',false,true);
ini_set ( 'display_errors', 1 );
$date = new DateTime('NOW', new DateTimeZone('Africa/Lagos'));

    
if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
		$id = hash( 'sha256', session_id() );
	} else {
		if(session_id() == '') {
			session_start();
			$id = hash( 'sha256', session_id() );
		}
	}
}

define( 'AJAX_TOKEN', $id );

if ( !defined ( 'SITEURL' ) )
	define ( 'SITEURL', 'http://localhost/JD/' );
if ( !defined ( 'ABSPATH' ) )
	define ( 'ABSPATH', dirname ( __FILE__) . '/' );
if ( !defined ( 'MULTIPATH' ) )
	define ( 'MULTIPATH', 'http://localhost/JD/res/' );
if ( !defined ( 'APPSHORTNAME' ) )
    define ( 'APPSHORTNAME', 'JDPC' );
if ( !defined ( 'APPFULLNAME' ) )
    define ( 'APPFULLNAME', 'Justice, Development and Peace Commission' );
if ( !defined ( 'APPTITLE' ) )
    define ( 'APPTITLE', 'Empowering humanity for a better tomorrow' );
    
function is_ajax( $token ) {
    if ( empty ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) || isset ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] !== 'XMLHttpRequest') { 
        return false;
    }
    else {
        if( defined( 'AJAX_TOKEN' ) && AJAX_TOKEN == $token )
            return true;
        else
            return false;
    }
}

function is_ajax2( $token ) {
        if( defined( 'AJAX_TOKEN' ) && AJAX_TOKEN == $token )
            return true;
        else
            return false;
}

$pagedata = pathinfo($_SERVER['REQUEST_URI']);
?>

