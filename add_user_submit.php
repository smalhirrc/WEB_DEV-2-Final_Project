<?php

require('connect.php');
require('mutual_content.php');

$user_name = $_POST['user_name'];
$user_password = $_POST['user_password'];
$user_role = $_POST['user_role'];

$add_user_query = "INSERT INTO Admins (user_name, passwords, user_role)
    VALUES (:user_name, :user_password, :user_role)";

$statement_add_user_query = $db->prepare($add_user_query);

try {
    $statement_add_user_query->bindValue(":user_name", $user_name);
    $statement_add_user_query->bindValue(":user_password", $user_password);
    $statement_add_user_query->bindValue(":user_role", $user_role);

    $statement_add_user_query->execute();

    echo "Successfully added user";
}
catch ( PDOException $e ) {
    echo "ERROR: " . $e;
}

?>