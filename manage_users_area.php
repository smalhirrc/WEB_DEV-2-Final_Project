<?php

session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: log_in_required.php?allowed=admin');
    exit();
}

require('connect.php');
require('mutual_content.php');

$users_select_query = "SELECT user_name FROM Admins";

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
                        <tr>
                            <td><?=$user['user_name']?></td>
                            <td><a href="">edit</a></td>
                            <td><a href="">delete</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>