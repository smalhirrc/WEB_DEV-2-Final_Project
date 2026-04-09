<?php

session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: log_in_required.php?allowed=admin');
    exit();
}

require('connect.php');
require('mutual_content.php');

$users_select_query = "SELECT user_name, user_id FROM Admins";

$statement_users_select_query = $db->prepare($users_select_query);

$statement_users_select_query->execute();

$rows = $statement_users_select_query->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="go_back_link">
        <a href='index.php?user=admin'>Go Back</a>
    </div>
    <main>
        <div id="users_table">
            <table class="users_table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $user): ?>
                        <?php $user_id=$user['user_id'] ?>
                        <tr>
                            <td><?=$user['user_name']?></td>
                            <td><a href="edit_user.php?user_id=<?=$user_id?>">edit</a></td>
                            <td><a href="delete_user.php?user_id=<?=$user_id?>" onClick="return confirm('Are your sure you want to delete <?=$user['user_name']?>');">delete</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div id="add_user_link">
                <a href="add_user.php">Add user</a>
            </div>
        </div>
    </main>
</body>
</html>