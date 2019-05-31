window.addEventListener("load", function() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_ADMIN_LOGIN', null, updateContent);
});

var editing_mode; //if we are in editing mode e.g. add/edit car

// window.addEventListener("load", function() {
// 	makeAjaxGetRequest('bv_caryard_admin_main.php','cmd_car_select_all', null, updateContent);
//     //show the top navigation panel
// 	makeAjaxGetRequest('bv_caryard_admin_main.php', 'cmd_show_top_nav', null, updateTopNav);
// 	editing_mode = false; //default when loaded
// });

function showMembers() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SELECT_MEMBERS', null, updateContent);
}

function showMovies() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SHOW_MOVIES', null, updateContent);
}

function showSignUpPageClick() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SIGN_UP', null, updateContent);
}

function updateTopNav(data = null) {
    var topnav = document.getElementById('id_topnav');
    if (data != null) {
        topnav.innerHTML = data;
        topnav.style.display = "inherit";
    } else {
        topnav.innerHTML = '';
        topnav.style.display = "none";
    }
}

function loadDashboard() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_DASHBOARD', null, updateContent);
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_LEFT_NAV', null, updateContentLeft);
}

function newMovie() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_NEW_MOVIE', null, updateContent);
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SELECT_ACTORS', null, populateSelectBox);
}

function deleteMemberById(member_id) {
    var params = '';
    params = '&member_id=' + member_id;
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_DELETE_MEMBER_BY_ID', params, updateContent);
}

function deleteMovieById(movie_id) {
    var params = '';
    params = '&movie_id=' + movie_id;
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_DELETE_MOVIE_BY_ID', params, updateContent);
}

function updateMemberForm(member_id) {
    var params = '&member_id=' + member_id;
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SHOW_EDIT_MEMBER_FORM', params, updateContent);
}

function updateMovieForm(movie_id) {
    var params = '&movie_id=' + movie_id;
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_SHOW_EDIT_MOVIE_FORM', params, updateContent);
}

/*Updates the content area if success
 */
function updateContent(data) {
    document.getElementById('admin_rightcol').innerHTML = data;
}

function updateContentLeft(data) {
    document.getElementById('admin_leftcol').innerHTML = data;
}

function getStockReport() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_STOCK_REPORT', null, updateContent);
}

function populateSelectBox(data) {
    document.getElementById('selectBox').innerHTML = data;
    document.getElementById('selectBoxTwo').innerHTML = data;
    document.getElementById('selectBoxThree').innerHTML = data;
    document.getElementById('selectBoxFour').innerHTML = data;
    document.getElementById('selectBoxFive').innerHTML = data;
    document.getElementById('selectBoxSix').innerHTML = data;
}

function validate(newmovieform) {
    //regex
    var regex = [
        /^[A-Z][\w\s]{9,45}$/, //title
        /^\d{4}$/, //year
        /^[A-Z][\w\s]{2,128}$/, //tagline
        /^[A-Z][\w\s]{2,128}$/, //plot
        /^[A-Z][\w\s]{2,10}$/, //director
        /^[A-Z][\w\s]{2,10}$/, //studio
        /^[A-Z][\w\s]{1,1}$/, //genre
        /^[A-Z][\w\s]{1,1}$/, //classification
        /^[A-Z][\w\s]{1,10}$/, //star
        /^[A-Z][\w\s]{1,10}$/, //star
        /^[A-Z][\w\s]{1,10}$/, //star
        /^[A-Z][\w\s]{1,10}$/, //star
        /^[A-Z][\w\s]{1,10}$/, //star
        /^[A-Z][\w\s]{1,10}$/, //star


        /[+-]?([0-9]*[.])?[0-9]+$/ //price
    ];
    //error messages
    var errors = [
        'title begins with Capital letter and between 10-45 characters',
        'year should have 4 digits',
        'tagline cannot be blank',
        'plot cannot be blank',
        'director cannot be blank',
        'studio cannot be blank',
        'genre cannot be blank',
        'classification cannot be blank',
        'star1 cannot be blank',
        'star2 cannot be blank',
        'star3 cannot be blank',
        'costar1 cannot be blank',
        'costar2 cannot be blank',
        'costar3 cannot be blank',
        // 'price should be between 0 - 999999'
    ];
    var names = [
        'title', 'year', 'tagline', 'plot', 'director', 'studio', 'genre', 'classification', 'star1', 'star2', 'star3', 'costar1', 'costar2', 'costar3'
    ];
    //perform the validation
    for (var i = 0; i < names.length; i++) {
        if (!regex[i].test(newmovieform.elements[names[i]].value)) {
            alert(errors[i]);
            return false;
        }
    }
    return true;
}

function btnAddMovieSubmitClick(command) {
    if (!validate(document.newmovie))
        return;
    var moviedata = new FormData(document.newmovie);
    makeAjaxPostRequest('moviezone_admin_main.php', command, moviedata, function(data) {
        if (data == '_OK_') {
            if (command == 'CMD_ADD_MOVIE') {
                alert('The movie data has been successfully updated to the database');
                document.movie.reset(); //reset form
                document.getElementById('id_photo_frame').src = '';
                document.getElementById('id_error').innerHTML = '';
            } else {
                btnAddMovieExitClick();
            }
        } else {
            document.getElementById('id_error').innerHTML = data;
        }
    });
}

function btnAddMovieExitClick() {
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_DASHBOARD', null, updateContent);
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_LEFT_NAV', null, updateContentLeft)
    editing_mode = false;
}

//exit to the main app
function exitClick() {
    if (editing_mode)
        if (confirm("Data is not saved. Are you sure to exit?") == false)
            return;
        //load the navigation panel on demand
    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_DASHBOARD', null, function(data) {
        if (data == '_OK_') {
            editing_mode = false;
            window.location.replace('../index.php');
        }
    });
}

function editMovieData() {
    var movieId = document.getElementsByName('movie_id')[0].value;
    var rentalPeriod = document.getElementsByName('rental_period')[0].value;
    var dvdRentalPrice = document.getElementsByName('dvdrental')[0].value;
    var dvdPurchasePrice = document.getElementsByName('dvdpurchase')[0].value;
    var dvdStock = document.getElementsByName('dvdstock')[0].value;
    var bluRayRentalPrice = document.getElementsByName('blurental')[0].value;
    var blueRayPurchasePrice = document.getElementsByName('blupurchase')[0].value;
    var blueRayStock = document.getElementsByName('blustock')[0].value;
    var params = '';
    params += '&movie_id=' + movieId;
    params += '&DVD_rental_price=' + dvdRentalPrice;
    params += '&DVD_purchase_price=' + dvdPurchasePrice;
    params += '&numDVD=' + dvdStock;
    params += '&BluRay_rental_price=' + bluRayRentalPrice;
    params += '&BluRay_purchase_price=' + blueRayPurchasePrice;
    params += '&numBluRay=' + blueRayStock;

    if (dvdRentalPrice < 0 || isNaN(dvdRentalPrice)) {
        params += '&DVD_rental_price' + dvdRentalPrice;
        errors = true;
        errorMessage = 'DVD price cannot be less than zero and must be a number';
    } else if (dvdPurchasePrice < 0 || isNaN(dvdPurchasePrice)) {
        params += '&DVD_purchase_price' + dvdPurchasePrice;
        errors = true;
        errorMessage = 'DVD price cannot be less than zero and must be a number';
    } else if (dvdStock < 0 || isNaN(dvdStock)) {
        params += '&numDVD' + dvdStock;
        errors = true;
        errorMessage = 'DVD stock cannot be less than zero and must be a number';
    } else if (bluRayRentalPrice < 0 || isNaN(bluRayRentalPrice)) {
        params += '&BluRay_rental_price' + bluRayRentalPrice;
        errors = true;
        errorMessage = 'bluRayRentalPrice price cannot be less than zero and must be a number';
    } else if (blueRayPurchasePrice < 0 || isNaN(blueRayPurchasePrice)) {
        params += '&BluRay_purchase_price' + blueRayPurchasePrice;
        errors = true;
        errorMessage = 'blueRayPurchasePrice price cannot be less than zero and must be a number';
    } else if (blueRayStock < 0 || isNaN(blueRayStock)) {
        params += '&numBluRay' + blueRayStock;
        errors = true;
        errorMessage = 'blueRayStock price cannot be less than zero and must be a number';
    } else {
        this.errors = false;
    }

    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_EDIT_MOVIE', params, updateContent);
}

function editMemberData() {
    var member_id = document.getElementsByName('member_id')[0].value;
    var surname = document.getElementsByName('surname')[0].value;
    var other_name = document.getElementsByName('other_name')[0].value;
    var password = document.getElementsByName('password')[0].value;
    var occupation = document.getElementsByName('occupation')[0].value;
    var contact_method = document.getElementsByName('contact_method')[0].value;
    var email = document.getElementsByName('email')[0].value;
    var mobile = document.getElementsByName('mobile')[0].value;
    var landline = document.getElementsByName('landline')[0].value;
    var params = '';
    var error = '';

    // validation to be used
    if (member_id == null || surname == null || other_name == null) {
        error = 'You must supply primary details';
    } else if (email == null || mobile == null || landline == null) {
        error = 'You must supply contact details';
    } else if (occupation == null || contact_method == null) {
        error = 'Please complete all select boxes';
    } else {
        errors = '';
    }

    params += '&member_id=' + member_id;
    params += '&surname=' + surname;
    params += '&other_name=' + other_name;
    params += '&password=' + password;
    params += '&occupation=' + occupation;
    params += '&contact_method=' + contact_method;
    params += '&email=' + email;
    params += '&mobile=' + mobile;
    params += '&landline=' + landline;

    makeAjaxGetRequest('moviezone_admin_main.php', 'CMD_EDIT_MEMBER', params, updateContent);
}