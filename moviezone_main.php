<?php
/*-------------------------------------------------------------------------------------------------

@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_config.php'); 

/*initialize the model and view
*/
$model = new MoviesModel();
$view = new MoviesView();
$controller = new MoviesController($model, $view);
/*interacts with UI via GET/POST methods and process all requests
*/
if (!empty($_REQUEST[CMD_REQUEST])) { //check if there is a request to process
	$request = $_REQUEST[CMD_REQUEST];	
	$controller->processRequest($request);
}
?>