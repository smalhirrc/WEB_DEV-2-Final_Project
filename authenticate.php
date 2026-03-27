<?php

require "connect.php";

function sanitize_string($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_input = filter_var(trim($input_value), FILTER_SANITIZE_SPECIAL_CHARS);

    return $sanitized_input;
}

$sanitized_user_name = sanitize_string('user_name');

$sanitized_password = sanitize_string('password');

function validate_input($input){
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_user_name = validate_input($sanitized_user_name);
$validated_password = validate_input($sanitized_password);

$admin_query = "SELECT user_name, passwords FROM Admins WHERE user_name = :user LIMIT 1";
$statement_admin_query = $db->prepare($admin_query);
$statement_admin_query->bindValue(":user", $validated_user_name);
$statement_admin_query->execute();
$admin = $statement_admin_query->fetch(PDO::FETCH_ASSOC);

// If user exists and password matches
if ($admin && $admin['passwords'] === $validated_password) {
    if(isset($_GET['player_id'])){
        $player_id = $_GET['player_id'];
        header("Location: edit_player.php?player_id=$player_id");
        exit();
    }
    else{
        header("Location: add_data.php");
        exit();
    }
} 
else{
    echo "Invalid username or password";
}

?>