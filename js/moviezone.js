window.addEventListener("load", function(){
    makeAjaxGetRequest('moviezone_main.php', 'CMD_MOVIE_SELECT_NEW_RELEASE', null, updateContent);
});

function movieFilterChanged() {
	var actor = (document.getElementById('id_actor')||{}).value||'';
	var director = (document.getElementById('id_director')||{}).value||'';
	var genre = (document.getElementById('id_genre')||{}).value||'';
	var classification = (document.getElementById('id_classification')||{}).value||'';
    var params = '';
    
	if (actor != '') {
        params +='&actor=' + actor;
    }
	else if (director != '') {
        params +='&director=' + director;
    }
	else if (genre != '') {
        params +='&genre=' + genre;
    }
	else if (classification != '') {
        params +='&classification=' + classification;
    }
    makeAjaxGetRequest('moviezone_main.php', 'CMD_MOVIE_FILTER', params, updateContent);
}

function moviesShowAllClick() {	
    console.log('woop');
	makeAjaxGetRequest('moviezone_main.php','CMD_MOVIES_SELECT_ALL', null, updateContent);
}

function moviesShowNewReleasesClick() {	
	makeAjaxGetRequest('moviezone_main.php','CMD_MOVIE_SELECT_NEW_RELEASE', null, updateContent);
}

function actorFilterClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_SELECT_ACTORS', null, updateContent); 
}

function directorFilterClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_SELECT_DIRECTORS', null, updateContent); 
}

function genreFilterClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_SELECT_GENRES', null, updateContent); 
}

function classificationFilterClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_SELECT_CLASSIFICATIONS', null, updateContent); 
}

function showHomePageClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_HOME_PAGE', null, updateContent);   
    //makeAjaxGetRequest('moviezone_main.php', 'CMD_MOVIE_SELECT_NEW_RELEASE_LEFT', null, updateContentLeft);
}

function showContactPageClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_CONTACT_PAGE', null, updateContent);   
    makeAjaxGetRequest('moviezone_main.php', 'CMD_MOVIE_SELECT_NEW_RELEASE_LEFT', null, updateContentLeft);
}

function showSignUpPageClick() {
    makeAjaxGetRequest('moviezone_main.php', 'CMD_SIGN_UP', null, updateContent);   
    makeAjaxGetRequest('moviezone_main.php', 'CMD_MOVIE_SELECT_NEW_RELEASE_LEFT', null, updateContentLeft);
}


/*Updates the content area if success
*/
function updateContent(data) {
	document.getElementById('rightcol').innerHTML = data;
}

function updateContentLeft(data) {
	document.getElementById('leftcol').innerHTML = data;
}
