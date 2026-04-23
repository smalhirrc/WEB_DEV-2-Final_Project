<?php

session_start();

if (
    !isset($_SESSION['logged_in']) || 
    $_SESSION['logged_in'] !== true
) {
    header("Location: log_in_required.php");
    exit();
}

require('connect.php');
require('mutual_content.php');

if ( isset($_GET['message']) && 
     $_GET['message'] === 'signinsuccess'
) {
    $get_user_name = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_SPECIAL_CHARS);

    function validate_user_name($input){
        if(!empty($input) && preg_match('/^[a-zA-Z ]+$/', trim($input))){
            return $input;
        }
        return false;
    }

    $valid_user_name = validate_user_name($get_user_name);

    if($valid_user_name !== false){
        echo "<h1>Sign In successfully</h1>";
        echo "<p>User can login with username: <b>" . htmlspecialchars($valid_user_name) ."</b></p>";
    }
    else{
        echo "<h1>invalid_user_name</h1>";
        echo "<p>Invalid username</p>";
    }
}


$user_name = $_POST['user_name'] ? $_POST['user_name'] : "";
$user_password = $_POST['user_password'] ? $_POST['user_password'] : false;
$user_role = $_POST['user_role'] ? $_POST['user_role'] : false;

$validated_user_name = preg_match( '/^[a-zA-Z0-9]+$/', trim($user_name) ) ? $user_name : false;




$add_user_query = "INSERT INTO Admins (user_name, passwords, user_role)
    VALUES (:user_name, :user_password, :user_role)";

$statement_add_user_query = $db->prepare($add_user_query);




$checks = [$user_password, $user_role, $validated_user_name];

if ( $_POST ) {
    if ( !in_array(false, $checks) ) {
        try {
            $statement_add_user_query->bindValue(":user_name", $validated_user_name);
            $statement_add_user_query->bindValue(":user_password", password_hash($user_password, PASSWORD_DEFAULT));
            $statement_add_user_query->bindValue(":user_role", $user_role);

            if( $statement_add_user_query->execute() ) {
                header("Location: add_user.php?message=signinsuccess&username=$validated_user_name");
                exit();
            }         
        }
        catch ( PDOException $e ) {
            echo "ERROR: " . $e;
        }
        echo "inif";
    }
    else {
        $user_name_error_message = $validated_user_name === false ? "* Please enter valid user name (include only lower case, upper case or numbers)" : "";
    
        $user_password_error_message = $user_password === false ? "* Please enter password" : "";

        $user_role_error_message = $user_role === false ? "* Please select user role" : "";

        $error_checks = [$user_name_error_message, $user_password_error_message, $user_role_error_message];

        $errors = [];

        foreach( $error_checks as $check ) {
            if ( $check !== "" ) {
                $errors[] = $check;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
</head>
<body>




    <?php if ( $_POST && count($errors) > 0): ?>
    <div id="error_container">
        <div id="errors">
            <?php foreach($errors as $error_messages): ?>
                <p class="error_fields">* <?=$error_messages?></p>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>




    <div id="add_user_form_container">
        <h1>Add User</h1>
        <form id="add_user_form" action="" method="post">
            <fieldset>
                <ul>
                    <li>
                        <label for="user_name">User Name: </label>
                        <input type="text" id="user_name" name="user_name" value="<?=$_POST['user_name']?>">
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
                            <option value="" <?= $_POST['user_role'] === "" ? "selected" : ""; ?>></option>
                            <option value="admin" <?= $_POST['user_role'] === "admin" ? "selected" : ""; ?>>Admin</option>
                            <option value="user" <?= $_POST['user_role'] === "user" ? "selected" : ""; ?> >User</option>
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