<?php
/*-------------------------------------------------------------------------------------------------
@Module: index.php
This server-side module provides main UI for the application (admin part)

@Modified by: Ethan Humphries
@Date: 19/04/2019
-------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_main.php');
?>

<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/moviezone_admin.css">
	<script src="js/ajax.js"></script>
	<script src="js/moviezone.js"></script>
	<script>
    //simply goes back to index file index.php
    function login_btnCancelClicked() {
        window.location.replace('../index.php');
    }
    //send ajax request to ask for server-side authentication
    function login_btnOKClicked() {
        var formData = new FormData(document.login);
        makeAjaxPostRequest('moviezone_admin_main.php', 'CMD_LOGIN', formData, success);
    }
    //handle the server response.
    function success(data) {
        if (data == '_OK_') { //ERR_SUCCESS == '_OK_' 
            loadDashboard();
        } else {
            document.getElementById('admin_rightcol').innerHTML = data;
        }
    }
</script>
</head>

<body>
	<header>
		<?php $controller->loadTopNavPanel() ?>
	</header>
	<!-- left navigation area -->
	<div id="admin_leftcol">
		<?php $controller->showLogInLeftNav() ?>
	</div>
	<!-- right area -->
	<div id="admin_rightcol">

		<?php
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

		if (isset($_SESSION['authorised'])) {
			$controller->showDasboard();
			$controller->loadLeftNav();
			die(); //and terminate
		} else {
			$controller->showLogInPage();
		}
		//otherwise, show the below login page
		?>

	</div>
	<!-- footer area -->
	<footer>Copyright &copy; WebDev-II (e.humphries.13@student.scu.edu.au) </footer>
</body>

</html>