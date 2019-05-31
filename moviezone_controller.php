<?php
/*-------------------------------------------------------------------------------------------------
@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_config.php');

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
	public function loadLeftNavPanel()
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

			case 'CMD_MOVIES_SELECT_ALL':
				$this->handleSelectAllMoviesRequest();
				break;
			case 'LEFT_NAV':
				$this->loadLeftNavPanel();
				break;
			case 'CMD_MOVIE_SELECT_NEW_RELEASE':
				$this->handleSelectMoviesNewReleaseRequest();
				break;
			case 'CMD_MOVIE_FILTER':
				$this->handleFilterMovieRequest();
				break;
			case 'CMD_SELECT_ACTORS':
				$this->handleSelectActorsRequest();
				break;
			case 'CMD_SELECT_DIRECTORS':
				$this->handleSelectDirectorsRequest();
				break;
			case 'CMD_SELECT_GENRES':
				$this->handleSelectGenresRequest();
				break;
			case 'CMD_SELECT_CLASSIFICATIONS':
				$this->handleSelectClassificationsRequest();
				break;
			case 'CMD_HOME_PAGE':
				$this->showHomePage();
				break;
			case 'CMD_CONTACT_PAGE':
				$this->showContactPage();
				break;
			case 'CMD_MOVIE_SELECT_NEW_RELEASE_LEFT':
				$this->handleSelectMoviesNewReleaseRequestLeft();
				break;
			case 'CMD_SIGN_UP':
				$this->showSignUpPage();
				break;
			case 'CMD_TECHZONE':
				$this->showTechzonePage();
				break;
			case 'CMD_LOG_IN':
				$this->showLogIn();
				break;
			case 'CMD_CUSTOMER_LOGIN':
				$this->handleCustomerLogin();
				break;
			case 'CUSTOMER_DASHBOARD';
				$this->showMoviesForAccount();
				break;
			case 'CMD_CHECKOUT':
				$this->handleCheckout();
				break;
			default:
				$this->handleSelectMoviesNewReleaseRequest();
				break;
		}
	}

	public function handleCustomerLogin()
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

		$result = $this->model->handleCustomerLogin($user);

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

	private function showMoviesForAccount()
	{
		$movies = $this->model->selectAllMovies();
		if ($movies != null) {
			$this->view->showMoviesForAccount($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleCheckout()
	{
		$condition = array();
		$condition['movie_id']  = $_REQUEST['movie_id'];
		$movies = $this->model->filterMovies($condition);
		if ($movies != null) {
			$this->view->showMoviesforCheckout($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectAllMoviesRequest()
	{
		$movies = $this->model->selectAllMovies();
		if ($movies != null) {
			$this->view->showMovies($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectMoviesNewReleaseRequest()
	{
		$movies = $this->model->selectNewReleaseMovies();
		if ($movies != null) {
			$this->view->showNewMovies($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectMoviesNewReleaseRequestLeft()
	{
		$movies = $this->model->selectNewReleaseMovies();
		if ($movies != null) {
			$this->view->showNewMoviesForLeftCol($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
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

	private function handleSelectDirectorsRequest()
	{
		$directors = $this->model->selectDirectors();
		if ($directors != null) {
			$this->view->showDirectors($directors);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectGenresRequest()
	{
		$genres = $this->model->selectGenres();
		if ($genres != null) {
			$this->view->showGenres($genres);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	private function handleSelectClassificationsRequest()
	{
		$classifications = $this->model->selectClassifications();
		if ($classifications != null) {
			$this->view->showClassifications($classifications);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	public function handleFilterMovieRequest()
	{
		$condition = array();
		if (!empty($_REQUEST['actor'])) {
			$condition['star1']  = $_REQUEST['actor'];
			$condition['star2']  = $_REQUEST['actor'];
			$condition['star3']  = $_REQUEST['actor'];
			$condition['costar1']  = $_REQUEST['actor'];
			$condition['costar2']  = $_REQUEST['actor'];
			$condition['costar3']  = $_REQUEST['actor'];
		} else if (!empty($_REQUEST['director'])) {
			$condition['director'] = $_REQUEST['director'];
		} else if (!empty($_REQUEST['genre'])) {
			$condition['genre'] = $_REQUEST['genre'];
		} else if (!empty($_REQUEST['classification'])) {
			$condition['classification'] = $_REQUEST['classification'];
		}
		$movies = $this->model->filterMovies($condition);
		if ($movies != null) {
			$this->view->showMovies($movies);
		} else {
			$error = $this->model->getError();
			if (!empty($error)) {
				$this->view->showError($error);
			}
		}
	}

	public function showHomePage()
	{
		print file_get_contents('html/home.html');
	}

	public function showContactPage()
	{
		print file_get_contents('html/contact.html');
	}

	public function showSignUpPage()
	{
		print file_get_contents('html/sign-up.html');
	}

	public function showTechzonePage()
	{
		print file_get_contents('html/techzone.html');
	}

	public function showLogIn()
	{
		print file_get_contents('html/login.php');
	}
}
