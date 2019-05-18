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
		print "<h2>Error: $error</h2>";
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
			print "<select id ='id_member' style = 'min-width: 100px;'>";
			foreach ($members_array as $member) {
				$memberName = $member['surname'];
				$otherName = $member['other_name'];
				$userName = $member['username'];
				print "<option value = " . $member['member_id'] . ">$otherName $memberName - $userName</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'updateMemberForm(" . $member['member_id'] . ")' >Search</button>";
		}
	}

	public function showMovies($movies_array)
	{
		if (!empty($movies_array)) {
			print "<select id ='movie_id' style = 'min-width: 100px;'>";
			foreach ($movies_array as $movie) {
				$title = $movie['title'];
				$year = $movie['year'];
				print "<option value = " . $movie['movie_id']. ">$title - $year</option>";
			}
			print "</select> &nbsp";
			print "<button style = 'min-width: 100px;' onclick = 'updateMovieForm(" . $movie['movie_id'] . ")' >Search</button>";
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

		print "<form name=;joinform' id='joinform' method='post'>
		<input type='hidden' name='action' value='edit_member'>
		<input type='hidden' name='update' value='$memberId'>
		<fieldset>
			<legend>Member ID: $memberId</legend>
			<div>
			   <label>Surname:</label>
			   <input type='text' name='surname' size='50' maxlength='50' value='$surname' required=''>
			</div>
			<div>
			   <label>Other Names:</label>
			   <input type='text' name='othername' size='50' maxlength='60' value='$otherName' required=''>
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
			   <label>Contact method:</label><select name='contactmethod'>
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
			   <input type ='text' name='phone'  size='13' maxlength='13' value='$landline'>
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
			<input type='submit' value='Update User'>
		  </div>
	   </form>";
	}

	public function showMovieAddEditForm($movie)
	{
		foreach ($movie as $movie) {
			$this->printEditMovieForm($movie);
		}
	}

	public function printEditMovieForm($movie) {
		print "".$movie['title']."";
	}

}
