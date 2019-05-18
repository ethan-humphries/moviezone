<div id="login_centered">
    <div id="login">
        <form method="post" id="login" name="login" action="/~vinh/moviezone/admin.php">
            <fieldset>
                <legend>Login</legend>
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" size="39" maxlength="10" required="">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" size="40" maxlength="10" required="">
                </div>
            </fieldset>
            <div id="formbuttons">
                <button type='button' name='btnOK' id='id_OK' onclick='login_btnOKClicked()'>Login</button>
                <button type='button' name='btnCancel' id='id_Cancel' onclick='login_btnCancelClicked()'>Cancel</button>
            </div>
        </form>
    </div>
</div>
</div>
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