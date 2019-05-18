<?php

//modify suit your A2 database)
//define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=");
//mysql:host=infotech.scu.edu.au
define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=moviezone_db");
define ('DB_USER', "ehumph13");
define ('DB_PASS', "25011993");
define ('MSG_ERR_CONNECTION', "Open connection to the database first");


//request command messages for client-server communication using AJAX
define ('CMD_REQUEST','request'); //the key to access submitted command via POST or GET
define ('CMD_SHOW_TOP_NAV', 'cmd_show_top_nav'); //create and show top navigation panel
define ('CMD_MOVIES_SELECT_ALL', 'CMD_MOVIES_SELECT_ALL');
define ('CMD_MOVIE_SELECT_NEW_RELEASE', 'CMD_MOVIE_SELECT_NEW_RELEASE');
define ('CMD_MOVIE_FILTER', 'CMD_MOVIE_FILTER'); //filter cars by submitted parameters

//define error messages
define ('errSuccess', 'SUCCESS'); //no error, command is successfully executed
define ('errAdminRequired', "Login as admin to perform this task");

require_once('moviezone_db.php');
require_once('moviezone_model.php');
require_once('moviezone_view.php');
require_once('moviezone_controller.php');

?>
