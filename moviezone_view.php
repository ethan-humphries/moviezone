<?php
/*-------------------------------------------------------------------------------------------------

@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/

class MoviesView {
	/*Class contructor: performs any initialization
	*/
	public function __construct() {		
	}
		
	public function __destruct() {		
	}
	
	public function leftNavPanel() {
		print file_get_contents('html/leftnav.html');
	}
	
	public function topNavPanel() {
		print file_get_contents('html/topnav.html');
	}

	public function showError($error) {
		print "<h2>Error: $error</h2>";
	}
	
	public function showMovies($movie_array) {
		if (!empty($movie_array)) {
			print"<h1>Movies</h1>";
			foreach ($movie_array as $movie) {
				$this->printMovieInHtml($movie);
			}
		}
	}

	public function showMoviesForAccount($movie_array) {
		if (!empty($movie_array)) {
			print"<h1>Movies</h1>";
			foreach ($movie_array as $movie) {
				$this->printMovieForAccount($movie);
			}
		}
	}

	public function showNewMovies($movie_array) {
		if (!empty($movie_array)) {
			print"<h1>New Releases</h1>";
			foreach ($movie_array as $movie) {
				$this->printMovieInHtml($movie);
			}
		}
	}

	public function showMoviesForCheckout($movie_array) {
		if (!empty($movie_array)) {
			print"<h1>New Releases</h1>";
			foreach ($movie_array as $movie) {
				$this->printCheckedOutMovies($movie);
			}
		}
	}

	public function showNewMoviesForLeftCol($movie_array) {
		$i = 0;
		if (!empty($movie_array)) {
			print"<span style='float:left;'>logged-in<br></span><br><br><h1>Checkout</h1>";
			foreach ($movie_array as $movie) {
				if($i < 2) {
				$this->printMovieInHtml($movie);
				$i++;
				}
			}
		}
	}

	private function printCheckedOutMovies($movie){
		if (empty($movie['photo'])) {
			$photo = "default.jpg";
		} else {
			$photo = $movie['thumbpath'];
		}
		$title = $movie['title'];
		$tagline = $movie['tagline'];	
		$year = $movie['year'];
		$dvdStock = $movie['numDVD'];
		$bluRayStock = $movie['numBluRay'];
		$movieId = $movie['movie_id'];
		print "
			<p>This module is currently being built and has not yet been completed. You have chosen the following movies to be booked/purchased:</p>
			<form id='joinform' name='joinform' method='' action=''>
			<fieldset>
			<legend>Movie $movieId Information:</legend>
			<img src='img/movies/$photo' alt='photo' class='moviePoster' height='150' width='105'>
				<label for='title'>Title:</label>
				<input type='text' name='title' size='45' value='$title' disabled=''> 
				</div><div>
				<label for='year'>Year:</label>
				<input type='text' name='year' size='4' value='$year' disabled=''>
				</div><div>
				<label for='tagline'>Tag line:</label>
				<input type='text' name='tagline' size='60' value='$tagline' disabled=''>
				</div><div><br>$dvdStock DVD's are available and $bluRayStock BluRay's are available<br></div></fieldset>
			</form>
		";
		}
	
	private function printMovieInHtml($movie) {
		
		if (empty($movie['photo'])) {
			$photo = "default.jpg";
		} else {
			$photo = $movie['thumbpath'];
		}
		$title = $movie['title'];
		$tagline = $movie['tagline'];
		$genre = $movie['genre'];		
		$year = $movie['year'];
		$director = $movie['director'];
		$classification = $movie['classification'];		
		$starring = $movie['star1'] . ' ' . $movie['star2'] . ' ' . $movie['star3'] . ' ' . $movie['costar1'] . ' ' . $movie['costar2'] . ' ' . $movie['costar3'];
		$rentalPeriod = $movie['rental_period'];
		$studio = $movie['studio'];
		$rentalPriceDVD = $movie['DVD_rental_price'];
		$purchasePriceDVD = $movie['DVD_purchase_price'];
		$bluRayPriceRental = $movie['BluRay_rental_price'];
		$bluRayPricePurchase = $movie['BluRay_purchase_price'];
		$dvdStock = $movie['numDVD'];
		$bluRayStock = $movie['numBluRay'];
		$plot = $movie['plot'];
		$photo = $movie['thumbpath'];

		print "
		<p>
		<fieldset>
			<legend>$title</legend>
				<div class='movie_card'>	
						<img src= 'img/movies/$photo' alt='photo' class='moviePoster' style = 'max-height: 170px;'>
					<div class='content'>
						<b><span class = 'movieHeading'>$rentalPeriod</span><br>
						<b><span class = 'movieHeading'>Genre:</span> $genre</b><br>
						<span class = 'movieHeading'>Year:</span> $year<br>
						<span class = 'movieHeading'>Director:</span> $director<br>
						<span class = 'movieHeading'>Classification:</span> $classification<br>
						<span class = 'movieHeading'>Starring:</span> $starring<br>
						<span class = 'movieHeading'>Studio:</span> $studio<br> 
						<span class = 'movieHeading'>Tagline:</span> $tagline<br><br> $plot <br><br>
						<span class = 'movieHeading'>Rental:</span> DVD - $$rentalPriceDVD BlueRay - $$bluRayPriceRental<br>
						<span class = 'movieHeading'>Purchase:</span> DVD - $$purchasePriceDVD BlueRay - $$bluRayPricePurchase<br>
						<span class = 'movieHeading'>Avaliability:</span> DVD - $dvdStock BlueRay - $bluRayStock<br>
					</div>
				</div>
		</fieldset></p>";
	}	

	private function printMovieForAccount($movie) {
		
		if (empty($movie['photo'])) {
			$photo = "default.jpg";
		} else {
			$photo = $movie['thumbpath'];
		}
		$movie_id = $movie['movie_id'];
		$title = $movie['title'];
		$tagline = $movie['tagline'];
		$genre = $movie['genre'];		
		$year = $movie['year'];
		$director = $movie['director'];
		$classification = $movie['classification'];		
		$starring = $movie['star1'] . ' ' . $movie['star2'] . ' ' . $movie['star3'] . ' ' . $movie['costar1'] . ' ' . $movie['costar2'] . ' ' . $movie['costar3'];
		$rentalPeriod = $movie['rental_period'];
		$studio = $movie['studio'];
		$rentalPriceDVD = $movie['DVD_rental_price'];
		$purchasePriceDVD = $movie['DVD_purchase_price'];
		$bluRayPriceRental = $movie['BluRay_rental_price'];
		$bluRayPricePurchase = $movie['BluRay_purchase_price'];
		$dvdStock = $movie['numDVD'];
		$bluRayStock = $movie['numBluRay'];
		$plot = $movie['plot'];
		$photo = $movie['thumbpath'];

		print "
		<p>
		<fieldset>
			<legend>$title</legend>";
			if($dvdStock == 0  && $bluRayStock == 0) {
				print "<button disabled =''>Out of stock</button>";
			} else {
				print"<button onclick='rentMovie($movie_id)'>Rent/Buy</button>";
			}
			print"<br><br><div class='movie_card'>	
						<img src= 'img/movies/$photo' alt='photo' class='moviePoster' style = 'max-height: 170px;'>
					<div class='content'>
						<b><span class = 'movieHeading'>$rentalPeriod</span><br>
						<b><span class = 'movieHeading'>Genre:</span> $genre</b><br>
						<span class = 'movieHeading'>Year:</span> $year<br>
						<span class = 'movieHeading'>Director:</span> $director<br>
						<span class = 'movieHeading'>Classification:</span> $classification<br>
						<span class = 'movieHeading'>Starring:</span> $starring<br>
						<span class = 'movieHeading'>Studio:</span> $studio<br> 
						<span class = 'movieHeading'>Tagline:</span> $tagline<br><br> $plot <br><br>
						<span class = 'movieHeading'>Rental:</span> DVD - $$rentalPriceDVD BlueRay - $$bluRayPriceRental<br>
						<span class = 'movieHeading'>Purchase:</span> DVD - $$purchasePriceDVD BlueRay - $$bluRayPricePurchase<br>
						<span class = 'movieHeading'>Avaliability:</span> DVD - $dvdStock BlueRay - $bluRayStock<br>
					</div>
				</div>
		</fieldset></p>";
	}	

	public function showActors($actors_array) {
		if (!empty($actors_array)) {
			print "<select id ='id_actor' style = 'min-width: 100px;'>";
			foreach ($actors_array as $actors_array) {
				$actor = $actors_array['actor_name'];
				print "<option value = '$actor'>$actor</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'movieFilterChanged()' >Search</button>";
		}
	}

	public function showDirectors($directors_array) {
		if (!empty($directors_array)) {
			print "<select id ='id_director' style = 'min-width: 100px;'>";
			foreach ($directors_array as $directors_array) {
				$director = $directors_array['director'];
				print "<option value = '$director'>$director</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'movieFilterChanged()' >Search</button>";
		}
	}

	public function showGenres($genres_array) {
		if (!empty($genres_array)) {
			print "<select id ='id_genre' style = 'min-width: 100px;'>";
			foreach ($genres_array as $genres_array) {
				$genre = $genres_array['genre'];
				print "<option value = '$genre'>$genre</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'movieFilterChanged()' >Search</button>";
		}
	}

	public function showClassifications($classifications_array) {
		if (!empty($classifications_array)) {
			print "<select id ='id_classification' style = 'min-width: 100px;'>";
			foreach ($classifications_array as $classifications_array) {
				$classification = $classifications_array['classification'];
				print "<option value = '$classification'>$classification</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'movieFilterChanged()' >Search</button>";
		}
	}
}
?>