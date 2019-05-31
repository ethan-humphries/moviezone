<?php
/*-------------------------------------------------------------------------------------------------

@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/

class MoviesView
{
	/*Class contructor: performs any initialization
	*/
	public function __construct()
	{ }

	public function __destruct()
	{ }

	public function leftNavPanel()
	{
		print file_get_contents('html/leftnav.html');
	}

	public function topNavPanel()
	{
		print file_get_contents('html/topnav.html');
	}

	public function showError($error)
	{
		print "<h2>Result: $error</h2>";
	}


	public function showActors($actors_array)
	{
		if (!empty($actors_array)) {
			print "<select id ='id_actor' name='star' style = 'min-width: 100px;'>
			<option value='blank' selected=''>Select...</option>";
			foreach ($actors_array as $actors_array) {
				$actor = $actors_array['actor_name'];
				print "<option value = '$actor'>$actor</option>";
			}
			print "</select> &nbsp";
		}
	}

	public function showStockReport($stock)
	{
		if (!empty($stock)) {
			print "<table>
			<tr>
			<th>Movie Title</th>
			<th>DVDInStock</th>
			<th>BlueRayInStock</th>
			</tr>";
			foreach ($stock as $stock) {
				$title = $stock['title'];
				$dvdStock = $stock['DVDInStock'];
				$bluRayStock = $stock['BluRayInStock'];
				print "<tr> <td> $title </td><td> $dvdStock </td><td>$bluRayStock </td> </tr>";
			}
			print "</table> &nbsp";
		}
	}

	public function showMembers($members_array)
	{
		if (!empty($members_array)) {
			print "<select onchange='updateMemberForm(value)' name='member' id='id_member' style = 'min-width: 100px;'>";
			foreach ($members_array as $member) {
				$memberId = $member['member_id'];
				$memberName = $member['surname'];
				$otherName = $member['other_name'];
				$userName = $member['username'];
				print "<option value = '$memberId'>$otherName $memberName - $userName</option>";
			}
			print "</select> &nbsp";
			print "<p>Choose a member to begin...</p>";
		}
	}

	public function showMovies($movies_array)
	{
		if (!empty($movies_array)) {
			print "<select onchange='updateMovieForm(value)' id ='movie_id' style = 'min-width: 100px;'>";
			foreach ($movies_array as $movie) {
				$title = $movie['title'];
				$year = $movie['year'];
				print "<option value = " . $movie['movie_id']. ">$title - $year</option>";
			}
			print "</select> &nbsp";
			print "<p>Choose a movie to begin...</p>";
		}
	}

	public function showMemberAddEditForm($member)
	{
		foreach ($member as $member) {
			$this->printEditMemberForm($member);
		}
	}

	public function printEditMemberForm($member)
	{
		$surname = $member['surname'];
		$memberId = $member['member_id'];
		$otherName = $member['other_name'];
		$userName = $member['username'];
		$contactMethod = $member['contact_method'];
		$email = $member['email'];
		$mobile = $member['mobile'];
		$landline = $member['landline'];
		$magazine =  $member['magazine'];
		$street = $member['street'];
		$suburb = $member['suburb'];
		$postcode = $member['postcode'];
		$password =  $member['password'];
		$occupation = $member['occupation'];
		$joinDate = $member['join_date'];

		print "<form name=editmemberform' id='editmemberform' method='post'>
		<input type='hidden' name='action' value='edit_member'>
		<input type='hidden' name='member_id' value='$memberId'>
		<fieldset>
			<legend>Member ID: $memberId</legend>
			<div>
			   <label>Surname:</label>
			   <input type='text' name='surname' size='50' maxlength='50' value='$surname' required=''>
			</div>
			<div>
			   <label>Other Names:</label>
			   <input type='text' name='other_name' size='50' maxlength='60' value='$otherName' required=''>
			</div>
			<div>
			   <label>Username:</label>
			   <input type='text' name='username' size='10' value='$userName' disabled=''>
			   <span style='color: red'>Can't be changed</span> 
			</div>
			<div>
			   <label>Password:</label>
			   <input type='text' name='password' size='10' value='$password'>
			   <span style='color: red'>Must have upper/lower/digit/special characters 
			   (10 chars max)</span>
			</div>                
			<div>
			   <label>Occupation:</label><select name='occupation'>
			   <option value='$occupation' selected=''>Student</option>
			   <option value='Manager'>Manager</option>
			   <option value='Medical worker'>Medical worker</option>
			   <option value= 'Trades worker'>Trades worker</option>
			   <option value ='Education'>Education</option>
			   <option value ='Technician'>Technician</option>
			   <option value ='Clerical Worker'>Clerical Worker</option>
			   <option value ='Retail worker'>Retail worker</option>
			   <option value ='Researcher'>Researcher</option>
			   <option value ='Other'>Other</option> </select></div> 
			<div>
				<label>Join date:</label>
				<input type='text' value='$joinDate' disabled=''>
				<span style='color :red'>Can't be changed</span>
			</div>
		 </fieldset>
		 <fieldset>
			<legend>Contact details</legend>
			<div>
			   <label>Contact method:</label><select name='contact_method'>
			   <option value='$email'>email</option>
			   <option value='$landline' selected=''>landline</option>
			   <option value='$mobile'>mobile</option></select></div>
			<div>
			   <label>Email:</label>
			   <input type='text' name='email' size ='50' maxlength ='50' value='$email'>
			   <span style='color :red'>If chosen must be provided</span>
			</div>
			<div>
			   <label>Mobile:</label>
			   <input type='text' name='mobile' size='13' maxlength ='12' value='$mobile'>
			   <span style='color:red'>Format 0[4 or 5]XX XXX XXX where X is a digit</span>
			</div>
			<div>
			   <label>Landline:</label>
			   <input type ='text' name='landline'  size='13' maxlength='13' value='$landline'>
			   <span style= 'color:red'>Format 0[2,3,6,7,8 or 9]XXXXXXXX where X is a digit</span>
			</div>
		 </fieldset> 
		 <fieldset>
			<legend>Magazine</legend>              
			<div><input  type='checkbox' name='magazine' value='$magazine' checked='checked'>&nbsp;&nbsp;Receive Magazine? 
			</div>
			<div>
			   <label>Street address:</label>
			   <input type='text' name='address' size='50' maxlength='50'  value='$street'>
			</div>
			<div>
			   <label>Suburb and State:</label>
			   <input  type='text' name='state' size='50' max length='50' value='$suburb'>
			   <span style= 'color:red'>Format Suburb, State</span>
			</div>
			<div>
			   <label>Postcode:</label>
			   <input type='text' name ='postcode' size='4' maxlength='4' value='$postcode'> <span style='color:red'>
				Format four digits only</span></div>
		 </fieldset><div>

		  </div>
		</form>
		<input type='submit' value='Update Member' onclick='editMemberData()'>&nbsp;
		<button onclick='deleteMemberById($memberId)'>Delete Member</button>";
	}

	public function showMovieAddEditForm($movie)
	{
		foreach ($movie as $movie) {
			$this->printEditMovieForm($movie);
		}
	}

	public function printEditMovieForm($movie) {
		$movieId = $movie['movie_id'];
		$title = $movie['title'];
		$tagline = $movie['tagline'];		
		$year = $movie['year'];
		$photo = $movie['thumbpath'];
		$rentalPeriod = $movie['rental_period'];
		$rentalPriceDVD = $movie['DVD_rental_price'];
		$purchasePriceDVD = $movie['DVD_purchase_price'];
		$bluRayPriceRental = $movie['BluRay_rental_price'];
		$bluRayPricePurchase = $movie['BluRay_purchase_price'];
		$dvdStock = $movie['numDVD'];
		$bluRayStock = $movie['numBluRay'];
		$dvdRented = $movie['numDVDout'];
		$bluRayRented = $movie['numBluRayOut'];
		// action='/moviezone/admin/html/result.php'
		print " 
         <span style='float:left; color:red; font-weight:bold'><br>Admin-mode</span><br><h1>Edit Movie A $title</h1><div id='compnote'>
			<p>* = Compulsory field</p></div>
			<form id='editmovieform' name='editmovieform' method='post' enctype='multipart/form-data'>
         <input type='hidden' name='action' value='update_movie'>
         <input type='hidden' name='id' value='30'>
         <input type='hidden' name='title' value='$title'>
         <fieldset>
			<legend>Movie Information:</legend><img src='img/movies/$photo' alt='photo' class='moviePoster' alt='Movie poster' height='150' width='105'>
			<div id='titlerow'>
				<label for='movie_id'>Movie ID:</label>
				<input type='text' name='movie_id' size='45' value='$movieId' disabled=''> 
				</div><div id='titlerow'>
				<label for='title'>Title:</label>
				<input type='text' name='title' size='45' value='$title' disabled=''> 
				</div><div id='yearrow'>
				<label for='year'>Year:</label>
				<input type='text' name='year' size='4' value='$year' disabled='''
				</div><div id='taglinerow'>
				<label for='tagline'>Tag line:</label>
				<input type='text' name='tagline' size='60' value='$tagline' disabled=''>
				</div>
			 </fieldset>
			 <fieldset id='stockfield'><legend>Stock Information:</legend><div>
        <label for='rental_period'>Rental Period</label>
		  <select name='rental_period'><option value='3 Day'>3 Day</option>
		  <option value='Weekly' selected=''>Weekly</option>
		  <option value='Overnight'>Overnight</option>
		  </select><span style='color:red;'> *</span></div><br>
		  <fieldset><legend>DVD:</legend><div id='dvdrentalrow'>
				<label for='dvdrental'>Rental price:</label>
				<input type='text' name='dvdrental' size='5' maxlength='10' value='$rentalPriceDVD'>
				<span style='color:red;'>*</span>
			</div><div id='dvdpurchaserow'>
				<label for='dvdpurchase'>Purchase price:</label>
				<input type='text' name='dvdpurchase' size='5' maxlength='10' value='$purchasePriceDVD'>
				<span style='color:red;'>*</span>
			</div><div id='dvdstockrow'>
				<label for='dvdstock'>In-stock:</label>
				<input type='text' name='dvdstock' size='5' maxlength='10' value='$dvdStock'>
				<span style='color:red;'>*</span>
			</div><div id='dvdrentedrow'>
				<label for='dvdrented'>Currently rented:</label>
				<input type='text' name='dvdrented' size='5' maxlength='10' value='$dvdRented'>
				<span style='color:red;'> * Overwrite only if a rental has failed to be returned.</span>
			</div><div id='dvdshelfrow'>
				<label for='dvdrented'>In Store:</label>
				<input type='text' name='dvdself' size='5' maxlength='10' value='$dvdStock' disabled=''>
			</div></fieldset>
			<fieldset><legend>BluRay:</legend><div id='blurentalrow'>
				<label for='blurental'>Rental price:</label>
				<input type='text' name='blurental' size='5' value='$bluRayPriceRental'>
				<span style='color:red;'>*</span>
			</div><div id='blupurchaserow'>
				<label for='blupurchase'>Purchase price:</label>
				<input type='text' name='blupurchase' size='5' value='$bluRayPricePurchase'>
				<span style='color:red;'>*</span>
			</div><div id='blustockrow'>
				<label for='blustock'>In-stock:</label>
				<input type='text' name='blustock' id='blustock' size='5' value='$bluRayStock'>
				<span style='color:red;'>*</span>
			</div><div id='blurentedrow'>
				<label for='blurented'>Currently rented:</label>
				<input type='text' name='blurented' size='5' value='$bluRayRented'>
				<span style='color:red;'> * Overwrite only if a rental has failed to be returned.</span>
			</div><div id='blurentedrow'>
				<label for='blurented'>In Store:</label>
				<input type='text' name='blurented' size='5' value='$bluRayStock' disabled=''>
			</div></fieldset>
		  </fieldset><div>

			 </div><br>
			 </form>
			 <input type='submit' value='Update Movie' onclick ='editMovieData()'> &nbsp;
			 <button onclick='deleteMovieById($movieId)'>Delete Movie</button> 
		";
		
	}
}