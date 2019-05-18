<?php 
/*-------------------------------------------------------------------------------------------------
@Module: index.php
This server-side module provides main UI for the application (admin part)

@Modified by: Ethan Humphries
@Date: 19/04/2019
-------------------------------------------------------------------------------------------------*/
require_once('moviezone_main.php');
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/moviezone.css">
	<script src="js/ajax.js"></script>
	<script src="js/moviezone.js"></script>
</head>

<body>
<div id="wrapper">
	<header>
	<div id="id_topnav">			
		<?php $controller->loadTopNavPanel()?>
		</div>
	</header>
	<!-- left navigation area -->
	<div id="leftcol">
		<!-- load the navigation panel by embedding php code -->
		<?php $controller->loadLeftNavPanel()?>
	</div>
	<!-- right area -->	
	<div id="rightcol">
	</div>
	<!-- footer area -->
	<footer>Copyright &copy; WebDev-II (e.humphries.13@student.scu.edu.au) </footer>
</div>
</body>
</html>