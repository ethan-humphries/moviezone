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
			case 'CMD_DELETE_MOVIE_BY_ID':
				$this->handleMovieDeleteRequest();
				break;
			case 'CMD_DELETE_MEMBER_BY_ID':
				$this->handleMemberDeleteRequest();
				break;
			case 'CMD_EDIT_MOVIE':
				$this->handleEditMovieRequest();
				break;
			case 'CMD_EDIT_MEMBER':
				$this->handleEditMemberRequest();
				break;
			default:
				$this->showLogInPage();
				break;
		}
	}

	// params += '&member_id=' + member_id;
    // params += '&surname=' + surname;
    // params += '&other_name=' + other_name;
    // params += '&password=' + password;
    // params += '&occupation=' + occupation;
    // params += '&contact_method=' + contact_method;
    // params += '&email=' + email;
    // params += '&mobile=' + mobile;
    // params += '&landline=' + landline;

	private function handleEditMemberRequest() {
		$condition =  array();
		$response = null;
		if (!empty($_REQUEST['member_id'])) {
			$condition['member_id'] = $_REQUEST['member_id'];
			$condition['surname'] = $_REQUEST['surname'];
			$condition['other_name'] = $_REQUEST['other_name'];
			$condition['password'] = $_REQUEST['password'];
			$condition['occupation'] = $_REQUEST['occupation'];
			$condition['contact_method'] = $_REQUEST['contact_method'];
			$condition['email'] = $_REQUEST['email'];
			$condition['mobile'] = $_REQUEST['mobile'];
			$condition['landline'] = $_REQUEST['landline'];
			$response = $this->model->editMember($condition);
		}
		if ($response != null) {
			$this->view->showError('Record edited');
		} else {
			$error = $this->model->getError();
			if ($this->model->getError() == 'SQLSTATE[HY000]: General error') {
				$error = 'Member Updated';
			}
			$this->view->showError($error);
		}
	}

	private function handleEditMovieRequest() {
		$condition =  array();
		$response = null;
		if (!empty($_REQUEST['movie_id'])) {
			$condition['movie_id'] = $_REQUEST['movie_id'];
			$condition['DVD_rental_price'] = $_REQUEST['DVD_rental_price'];
			$condition['DVD_purchase_price'] = $_REQUEST['DVD_purchase_price'];
			$condition['numDVD'] = $_REQUEST['numDVD'];
			$condition['BluRay_rental_price'] = $_REQUEST['BluRay_rental_price'];
			$condition['BluRay_purchase_price'] = $_REQUEST['movie_id'];
			$condition['numBluRay'] = $_REQUEST['numBluRay'];
			$response = $this->model->editMovie($condition);
		}
		if ($response != null) {
			$this->view->showError('Record edited');
		} else {
			$error = $this->model->getError();
			if ($this->model->getError() == 'SQLSTATE[HY000]: General error') {
				$error = 'Movie Updated';
			}
			$this->view->showError($error);
		}
	}

	private function handleMovieDeleteRequest()
	{
		$condition = array();
		if (!empty($_REQUEST['movie_id'])) {
			$condition['movie_id'] = $_REQUEST['movie_id'];
			//call the dbAdapter function
			$response = $this->model->deleteById($condition);
			if ($response != false) {
				$this->view->showError('Record deleted');
			} else {
				$error = $this->model->getError();
				if ($this->model->getError() == 'SQLSTATE[HY000]: General error') {
					$error = 'Movie Deleted';
				}
				$this->view->showError($error);
			}
		}
	}

	private function handleMemberDeleteRequest()
	{
		$condition = array();
		if (!empty($_REQUEST['member_id'])) {
			$condition['member_id'] = $_REQUEST['member_id'];
			//call the dbAdapter function
			$result = $this->model->deleteById($condition);
			if ($result != null) {
				$error = $this->model->getError();
				if ($error != null)
					$this->view->showError($error);
			} else {
				$error = $this->model->getError();
				if ($this->model->getError() == 'SQLSTATE[HY000]: General error') {
					$error = 'Member Deleted';
				}
				$this->view->showError($error);
			}
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

	private function handleSelectMovieRequest()
	{
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
