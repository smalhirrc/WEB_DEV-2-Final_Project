<?php

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header("Location: log_in_required.php");
    exit();
}

require('connect.php');
require('mutual_content.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
</head>
<body>
    <div id="add_user_form_container">
        <h1>Add User</h1>
        <form id="add_user_form" action="add_user_submit.php" method="post">
            <fieldset>
                <ul>
                    <li>
                        <label for="user_name">User Name: </label>
                        <input type="text" id="user_name" name="user_name" value="">
                        <span id="user_name_error" class="error_field">* User name is required.</span>
                    </li>
                    <li>
                        <label for="user_password">User Password: </label>
                        <input type="password" id="user_password" name="user_password" value="">
                        <span id="user_password_error" class="error_field">* User password is required.</span>
                    </li>
                    <li>
                        <label for="user_role">User Role: </label>
                        <select id="user_role" name="user_role">
                            <option value=""></option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <span id="user_role_error" class="error_field">* Please select user role.</span>
                    </li>
                </ul>
            </fieldset>
            <button type="submit" id="submit">Add</button>
            <button type="reset" id="reset">Reset</button>
        </form>
    </div>
    <script src="user_page_script.js"></script>
</body>
</html>