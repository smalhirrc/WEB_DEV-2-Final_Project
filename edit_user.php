<?php

session_start();

if ( !isset($_SESSION['logged_in']) || 
     $_SESSION['logged_in'] !== true
) {
    header("Location: log_in_required.php");
    exit();
}

require('connect.php');
require('mutual_content.php');

$sanitized_user_id = filter_input(
    INPUT_GET,
    'user_id',
    FILTER_SANITIZE_NUMBER_INT
);

$user_id = filter_var(
    $sanitized_user_id,
    FILTER_VALIDATE_INT
);

// QUERY, PREPARE, BIND, EXECUTE, FETCH
$select_user_query = "SELECT user_id, user_name, passwords, user_role 
    FROM ADMINS 
    WHERE user_id = :user_id";

$statement_select_user_query = $db->prepare($select_user_query);

try {
    $statement_select_user_query->bindValue(":user_id", $user_id);

    $statement_select_user_query->execute();

    $rows = $statement_select_user_query->fetchAll(PDO::FETCH_ASSOC);
}
catch ( PDOException $e ) {
    echo 'Error: ' . $e;
}




$user_name = $_POST['user_name'] ? $_POST['user_name'] : "";
$user_password = $_POST['user_password'] ? $_POST['user_password'] : false;
$user_role = $_POST['user_role'] ? $_POST['user_role'] : false;

$validated_user_name = preg_match('/^[a-zA-Z0-9]+$/', trim($user_name)) ? $user_name : false;

// QUERY, PREPARE, BIND, EXECUTE
$update_user_query = "UPDATE Admins 
SET user_name = :user_name, passwords = :user_password, user_role = :user_role 
WHERE user_id = :user_id";

$statement_update_user_query = $db->prepare($update_user_query);

$checks = [$validated_user_name, $user_password, $user_role];

if ( $_POST ) {
    if ( !in_array(false, $checks) ) {
        try {
            $statement_update_user_query->bindValue(":user_name", $user_name);
            $statement_update_user_query->bindValue(":user_password", $user_password);
            $statement_update_user_query->bindValue(":user_role", $user_role);
            $statement_update_user_query->bindValue(":user_id", $user_id);

            if( $statement_update_user_query->execute() ) {
                header("Location: edit_user.php?user_id=$user_id&status=user_updated");
                exit();
            }
        }
        catch ( PDOException $e ) {
            echo "Error: " . $e;
        }
    }
    else {
        $user_name_error_message = $validated_user_name === false ? "* Please enter valid user name" : "";

        $user_password_error_message = $user_password === false ? "* Please enter valid password" : "";

        $user_role_error_message = $user_role === false ? "* Please select user role" : "";

        $error_checks = [$user_name_error_message, $user_password_error_message, $user_role_error_message];

        $errors = [];

        foreach($error_checks as $check){
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
    <title>Edit user</title>
</head>
<body>




    <?php if(isset($_GET['status']) && $_GET['status'] === "user_updated"): ?>
        <p class="success">user updated successfully</p>
    <?php endif ?>



    
    <?php if ( $_POST && count($errors) > 0): ?>
    <div id="error_container">
        <div id="errors">
            <?php foreach($errors as $error_messages): ?>
                <p class="error_fields">* <?=$error_messages?></p>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>




    <div id="user_update_form_container">
        <h1>Update User</h1>
        <?php foreach($rows as $user): ?>
            <form id="user_update_form" action="" method="post">
                <fieldset>
                    <ul>
                        <li>
                            <label for="user_name">User Name: </label>
                            <input type="text" id="user_name" name="user_name" value="<?=htmlspecialchars($user['user_name'])?>">
                            <span id="user_name_error" class="error_field">* User name is required.</span>
                        </li>
                        <li>
                            <label for="user_password">User Password: </label>
                            <input type="password" id="user_password" name="user_password" value="">
                            <span id="user_password_error" class="error_field">* User password is required.</span>
                        </li>
                        <li>
                            <label for="user_role">Update Role: </label>
                            <select id="user_role" name="user_role">
                                <option value="admin" <?php echo ($user['user_role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?php echo ($user['user_role'] === 'user') ? 'selected' : ''; ?>>User</option>
                            </select>
                            <span id="user_role_error" class="error_field">* Please select user role.</span>
                        </li>
                    </ul>
                </fieldset>
                <button type="submit" id="submit">Update</button>
                <button type="reset" id="reset">Reset</button>
            </form>
        <?php endforeach ?>
    </div>
    <script src="user_page_script.js"></script>
</body>
</html>