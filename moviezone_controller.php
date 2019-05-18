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
			default:
				$this->handleSelectMoviesNewReleaseRequest();
				break;
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
}
