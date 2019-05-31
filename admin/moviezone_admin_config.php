<?php

//modify suit your A2 database)
//define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=");
//mysql:host=infotech.scu.edu.au
define('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=moviezone_db");
define('DB_USER', "ehumph13");
define('DB_PASS', "25011993");
define('MSG_ERR_CONNECTION', "Open connection to the database first");



//request command messages for client-server communication using AJAX
define('CMD_REQUEST', 'request'); //the key to access submitted command via POST or GET
define('CMD_SHOW_TOP_NAV', 'cmd_show_top_nav'); //create and show top navigation panel
define('CMD_MOVIES_SELECT_ALL', 'CMD_MOVIES_SELECT_ALL');
define('CMD_MOVIE_SELECT_NEW_RELEASE', 'CMD_MOVIE_SELECT_NEW_RELEASE');
define('CMD_MOVIE_FILTER', 'CMD_MOVIE_FILTER'); //filter cars by submitted parameters

//define error messages
define('errSuccess', 'SUCCESS'); //no error, command is successfully executed
define('errAdminRequired', "Login as admin to perform this task");

require_once('moviezone_admin_db.php');
require_once('moviezone_admin_model.php');
require_once('moviezone_admin_view.php');
require_once('moviezone_admin_controller.php');

/*Perform session checking, if already logged in then just put user through
	  otherwise, show login dialog */
$php_version = phpversion();
if (floatval($php_version) >= 5.4) {
    if (session_status() == PHP_SESSION_NONE) { //need the session to start
        session_start();
    }
} else {
    if (session_id() == '') {
        session_start();
    }
}

/*We use 'authorised' keyword to identify if the user hasn't logged in
        if the keyword has not been set check if this is the login session then continue
        if not simply terminate (a good security practice to check for eligibility 
        before execute any php code)
      */
// if (empty($_SESSION['authorised'])) {
//     //no authorisation so check if user is trying to log in		
//     if (empty($_REQUEST[CMD_REQUEST]) || ($_REQUEST[CMD_REQUEST] != CMD_ADMIN_LOGIN)) {
//         //if no request or request is not login request
//         die();
//     }
// }

?>