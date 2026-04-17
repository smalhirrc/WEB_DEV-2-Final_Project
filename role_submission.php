<?php

require "connect.php";

function sanitize_string($key)
{
    $input = $_POST[$key] ? $_POST[$key] : "";

    return filter_var(
        trim($input), 
        FILTER_SANITIZE_SPECIAL_CHARS
    );
}

function validate_player_role($input)
{
    if ( trim($input) === "" ) {
        return false;
    }
    return $input;
}

$sanitized_player_role = sanitize_string('player_role');
$validated_player_role = validate_player_role($sanitized_player_role);

// QUERY, PREPARE, BIND, EXECUTE
$player_role_query = "INSERT INTO Player_Categories (category_name) 
    VALUES (:player_role)";

$statement_player_role_query = $db->prepare($player_role_query);

$statement_player_role_query->bindValue(":player_role", $validated_player_role);

if ( $statement_player_role_query->execute() ) {
    header("Location: success.php?status=roleadded");
    exit();
}

?>



