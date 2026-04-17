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

$user_id = $_GET['user_id'];

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
</head>
<body>
    <div id="user_update_form_container">
        <h1>Update User</h1>
        <?php foreach($rows as $user): ?>
            <form id="user_update_form" action="user_update.php?user_id=<?=$user['user_id']?>" method="post">
                <fieldset>
                    <ul>
                        <li>
                            <label for="user_name">User Name: </label>
                            <input type="text" id="user_name" name="user_name" value="<?=$user['user_name']?>">
                            <span id="user_name_error" class="error_field">* User name is required.</span>
                        </li>
                        <li>
                            <label for="user_password">User Password: </label>
                            <input type="password" id="user_password" name="user_password" value="<?=$user['passwords']?>">
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