<?php
/*-------------------------------------------------------------------------------------------------
@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_config.php');

class MoviesController
{
	private $model;
	private $view;

	/*Class contructor
	*/
	public function __construct($model, $view)
	{
		$this->model = $model;
		$this->view = $view;
	}
	/*Class destructor
	*/
	public function __destruct()
	{
		$this->model = null;
		$this->view = null;
	}
	/*Loads left navigation panel*/
	public function leftNavPanel()
	{
		$this->view->leftNavPanel();
	}

	/*Loads top navigation panel*/
	public function loadTopNavPanel()
	{
		$this->view->topNavPanel();
	}
	/*Processes user requests and call the corresponding functions
	  The request and data are submitted via POST or GET methods
	*/
	public function processRequest($request)
	{

		switch ($request) {
			case 'CMD_SIGN_UP':
				$this->showSignUpPage();
				break;
			case 'CMD_LOGIN':
				$this->handleLogInRequest();
				break;
			case 'CMD_LEFT_NAV':
				$this->leftNavPanel();
				break;
			case 'CMD_DASHBOARD':
				$this->showDasboard();
				break;
			case 'CMD_ADMIN_LOGIN':
				$this->showLogInPage();
				break;
			case 'CMD_SELECT_ACTORS':
				$this->handleSelectActorsRequest();
				break;
			case 'CMD_SHOW_MOVIES':
				$this->handleSelectMovieRequest();
				break;
			case 'CMD_SELECT_MEMBERS':
				$this->handleSelectMembersRequest();
				break;
			case 'CMD_NEW_MOVIE':
				$this->handleNewMovieRequest();
				break;
			case 'CMD_STOCK_REPORT':
				$this->getStockReport();
				break;
			case 'CMD_ADD_MOVIE':
				$this->handleMovieAddRequest();
				break;
			case 'CMD_SHOW_EDIT_MEMBER_FORM':
				$this->showMemberEditForm();
				break;
			case 'CMD_SHOW_EDIT_MOVIE_FORM':
				$this->showMovieEditForm();
				break;
			default:
				$this->showLogInPage();
				break;
		}
	}

	private function showMemberEditForm()
	{
		if (!empty($_REQUEST['member_id'])) {
			$condition = array();
			$condition['member_id'] = $_REQUEST['member_id'];
			$member = $this->model->getMemberById($condition);
			if ($member != null) {
				$this->view->showMemberAddEditForm($member);
			} else {
				$error = $this->model->getError();
				if (!empty($error)) {
					$this->view->showError($error);
				}
			}
		}
	}

	private function showMovieEditForm()
	{
		if (!empty($_REQUEST['movie_id'])) {
			$condition = array();
			$condition['movie_id'] = $_REQUEST['movie_id'];
			$member = $this->model->getMovieById($condition);
			if ($member != null) {
				$this->view->showMovieAddEditForm($member);
			} else {
				$error = $this->model->getError();
				if (!empty($error)) {
					$this->view->showError($error);
				}
			}
		}
	}

	private function handleSelectActorsRequest()
	{
		$actors = $this->model->selectActors();
		if ($actors != null) {
			$this->view->showActors($actors);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectMovieRequest() {
		$movies = $this->model->selectMovies();
		if ($movies != null) {
			$this->view->showMovies($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function getStockReport()
	{
		$stock = $this->model->getStockReport();
		if ($stock != null) {
			$this->view->showStockReport($stock);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectMembersRequest()
	{
		$members = $this->model->selectAllMembers();
		if ($members != null) {
			$this->view->showMembers($members);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	public function handleNewMovieRequest()
	{
		print file_get_contents('new-movie.php');
	}

	public function showLogInPage()
	{
		print file_get_contents('moviezone_admin_login.php');
	}

	public function showLogInLeftNav()
	{
		print file_get_contents('html/leftnav_home.html');
	}

	public function showDasboard()
	{
		print file_get_contents('html/dashboard.html');
	}

	public function handleLogInRequest()
	{
		//take username and password and perform authentication
		//if successful, initialize the user session
		//echo 'OK';
		$keys = array('username', 'password');
		//retrive submiteed data
		$user = array();
		foreach ($keys as $key) {
			if (!empty($_REQUEST[$key])) {
				//more server side checking can be done here
				$user[$key] = $_REQUEST[$key];
			} else {
				//check required field
				$this->view->showError($key . ' cannot be blank');
				return;
			}
		}

		$result = $this->model->adminLogin($user);

		if ($result) {
			//authorise user with the username to access			
			$_SESSION['authorised'] = $user['username'];
			/*and notify the caller about the successful login
			 the notification protocol should be predefined so
			 the client and server can understand each other
			*/
			$this->notifyClient('_OK_'); //send '_OK_' code to client
		} else {
			//not successful show error to user
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}
	}

	/* Notifies client machine about the outcome of operations
	   This is used for M2M communication when Ajax is used.
	*/
	private function sendJSONData($data)
	{
		//using JSON
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	private function notifyClient($code)
	{
		/*simply print out the notification code for now
		but in the future JSON can be used to encode the
		communication protocol between client and server
		*/
		print $code;
	}

	public function showSignUpPage()
	{
		print file_get_contents('html/sign-up_admin.html');
	}

	private function handleMovieAddRequest()
	{
		$keys = array('ti tle', 'make', 'body', 'year', 'odometer', 'price', 'state');
		//retrive submiteed data
		$moviedata = array();
		foreach ($keys as $key) {
			if (!empty($_REQUEST[$key])) {
				//more server side checking can be done here
				$cardata[$key] = $_REQUEST[$key];
			} else {
				//check required field
				$this->view->showError($key . ' cannot be blank');
				return;
			}
		}

		//we will change it later to actual photo file name if photo upload is OK
		$result = $this->model->addMovie($moviedata);
		if ($result != null)
			$this->notifyClient(ERR_SUCCESS);
		else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}
	}
}
