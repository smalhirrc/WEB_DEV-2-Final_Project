<?php

require('connect.php');
require('mutual_content.php');

$user_name = $_POST['user_name'];
$user_password = $_POST['user_password'];
$user_role = $_POST['user_role'];
$user_id = $_GET['user_id'];

$update_user_query = "UPDATE Admins SET user_name = :user_name, passwords = :user_password, user_role = :user_role WHERE user_id = :user_id";

$statement_update_user_query = $db->prepare($update_user_query);

try{
    $statement_update_user_query->bindValue(":user_name", $user_name);
    $statement_update_user_query->bindValue(":user_password", $user_password);
    $statement_update_user_query->bindValue(":user_role", $user_role);
    $statement_update_user_query->bindValue(":user_id", $user_id);

    $statement_update_user_query->execute();

    echo "successful";
}
catch(PDOException $e){
    echo "Error: " . $e;
}

?>