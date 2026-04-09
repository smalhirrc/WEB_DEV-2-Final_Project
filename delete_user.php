<?php

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header("Location: log_in_required.php");
    exit();
}

require('connect.php');
require('mutual_content.php');

$user_id = $_GET['user_id'];

$delete_user_query = "DELETE FROM Admins WHERE user_id = :user_id";

$statement_delete_user_query = $db-> prepare($delete_user_query);

try{
    $statement_delete_user_query->bindValue(":user_id", $user_id);

    $statement_delete_user_query->execute();

    echo 'User deleted successfully';
}
catch(PDOException $e){
    echo "Error: " . $e;
}

?>