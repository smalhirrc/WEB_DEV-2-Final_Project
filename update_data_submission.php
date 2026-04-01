<?php

require "connect.php";

// SANITIZATION FUNCTIONS
// SANITIZE STRINGS
function sanitize_string($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_input = filter_var(trim($input_value), FILTER_SANITIZE_SPECIAL_CHARS);

    return $sanitized_input;
}

//SANITIZE NUMBERS
function sanitize_number($key){
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_number = filter_var($input_value, FILTER_SANITIZE_NUMBER_INT);

    return $sanitized_number;
} 

// SANITIZE FLOAT
function sanitize_float($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_float = filter_var($input_value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    return $sanitized_float;
}

// VALIDATE SANITIZED INPUTS
// PLAYER NAME
$sanitized_player_name = sanitize_string('player_name');

function validate_player_name($input){
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_player_name = validate_player_name($sanitized_player_name);

// PLAYER_AGE
$sanitized_player_age = sanitize_number('player_age');

function validate_player_age($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 100)));
    }
    return false;
}

$validated_player_age = validate_player_age($sanitized_player_age);

// PLAYER HEIGHT
$sanitized_player_height = sanitize_float('player_height');

function validate_player_height($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_FLOAT, array("options" => array("min_range" => 100.0, "max_range" => 250.0)));
    }
    return false;
}

$validated_player_height = validate_player_height($sanitized_player_height);

// PLAYER WEIGHT
$sanitized_player_weight = sanitize_float('player_weight');

function validate_player_weight($input)
{
    if(trim($input) !== ""){
        $validated_input = filter_var($input, FILTER_VALIDATE_FLOAT, array("options" => array("min_range" => 40.0, "max_range" => 170.0)));

        if($validated_input !== false){
            return round($validated_input, 2);
        }
    }

    return false;
}

$validated_player_weight = validate_player_weight($sanitized_player_weight);

// PLAYER PLAYING POSITION
$sanitized_player_playing_position = sanitize_string('player_playing_position');

function validate_playing_position($input)
{
    if(!empty($input)){
        return $input;
    }
    else{
        return false;
    }
}

$validated_player_playing_position = validate_playing_position($sanitized_player_playing_position);

// PLAYER JERSEY NUMBER
$sanitized_player_jersey_number = sanitize_number('player_jersey_number');

function validate_player_jersey_number($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    return false;
}

$validated_player_jersey_number = validate_player_jersey_number($sanitized_player_jersey_number);

// PLAYER PROFILE_DESCRIPTION
$sanitized_player_profile_description = sanitize_string('player_profile_description');

function validate_player_profile_description($input)
{
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_player_profile_description = validate_player_profile_description($sanitized_player_profile_description);

// TEAM NAME
$sanitized_team_name = sanitize_string('team_name');

function validate_team_name($input)
{
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_team_name = validate_team_name($sanitized_team_name);

// TEAM COACH NAME
$sanitized_team_coach_name = sanitize_string('team_coach_name');

function validate_team_coach_name($input)
{
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_team_coach_name = validate_team_coach_name($sanitized_team_coach_name);

// TEAM FOUNDED IN YEAR
$sanitized_team_founded_in_year = sanitize_number('team_founded_in_year');

function validate_team_founded_in_year($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1900, "max_range" => 2099)));
    }
    return false;
}

$validated_team_founded_in_year = validate_team_founded_in_year($sanitized_team_founded_in_year);

// TEAM CATEGORY
function validate_team_category()
{
    if(isset($_POST['team_category'])){
        return $_POST['team_category'];
    }
    return false;
}

$team_category = validate_team_category();

// TEAM HOME GROUND
$sanitized_team_home_ground = sanitize_string('team_home_ground');

function validate_team_home_ground($input)
{
    if(!empty(trim($input))){
        return $input;
    }
    else{
        return false;
    }
}

$validated_team_home_ground = validate_team_home_ground($sanitized_team_home_ground);

// NUMBER OF MATCHES
$sanitized_number_of_matches_played = sanitize_number('number_of_matches_played');

function validate_number_of_matches_played($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }
    
    return false;
}

$validated_number_of_matches_played = validate_number_of_matches_played($sanitized_number_of_matches_played);

// TOTAL GOALS
$sanitized_total_goals = sanitize_number('total_goals');

function validate_total_goals($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    return false;
}

$validated_total_goals = validate_total_goals($sanitized_total_goals);

// TOTAL ASSISTS
$sanitized_total_assists = sanitize_number('total_assists');

function validate_total_assists($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    return false;
}

$validated_total_assists = validate_total_assists($sanitized_total_assists);

// YELLOW CARDS
$sanitized_yellow_cards = sanitize_number('yellow_cards');

function validate_yellow_cards($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    return false;   
}

$validated_yellow_cards = validate_yellow_cards($sanitized_yellow_cards);

// RED CARDS
$sanitized_red_cards = sanitize_number('red_cards');

function validate_red_cards($input)
{
    if(trim($input) !== ""){
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    return false;
}

$validated_red_cards = validate_red_cards($sanitized_red_cards);

// PLAYER IMAGE FILE UPLOAD CHECKING
function file_upload_path($original_filename, $upload_subfolder_name = 'images')
{
    $current_folder = dirname(__FILE__);

    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path){
    $image_mime_type = getimagesize($temporary_path)['mime'];
    $image_extension = pathinfo($new_path, PATHINFO_EXTENSION);

    $allowed_mime_types = ['image/jpeg', 'image/png'];
    $allowed_extensions = ['jpeg', 'jpg', 'png'];

    $mime_type_is_valid = in_array($image_mime_type, $allowed_mime_types);
    $file_extension_is_valid = in_array($image_extension, $allowed_extensions);

    return $mime_type_is_valid && $file_extension_is_valid;
}

if(isset($_FILES['player_image']) && $_FILES['player_image']['error'] === 0){
    $image_filename = $_FILES['player_image']['name'];

    $new_image_path = file_upload_path($image_filename);

    $temporary_image_path = $_FILES['player_image']['tmp_name'];

    if(file_is_an_image($temporary_image_path, $new_image_path)){
        $image_name = $_FILES['player_image']['name'];

        move_uploaded_file($temporary_image_path, $new_image_path);
    }
}


















$player_id = $_GET['player_id'];

$players_table_update_query = "UPDATE Players 
                               SET player_name = :player_name, 
                                   player_age = :player_age,
                                   player_height = :player_height,
                                   player_weight = :player_weight,
                                   player_playing_position = :player_playing_position,
                                   player_jersey_number = :player_jersey_number,
                                   player_profile_description = :player_profile_description 
                               WHERE player_id = :player_id";
$statement_players_table_update = $db->prepare($players_table_update_query);

// $update_table_satistics_query = "UPDATE Player_satistics
//                                  SET number_of_matches_played = :number_of_matches_played,
//                                      total_goals = :total_goals,
//                                      total_assists = :total_assists,
//                                      yellow_cards = :yellow_cards,
//                                      red_cards = :red_cards
//                                 WHERE player_id = :player_id";
                        
// $statement_satistics_update = $db->prepare($update_table_satistics_query);

$images_table_select_query = "SELECT player_id, image_name
                              FROM Images
                              WHERE player_id = :player_id";

$statement_images_table_select_query = $db->prepare($images_table_select_query);

$images_table_insert_query = "INSERT INTO Images (player_id, image_name)
                             VALUES (:player_id, :image_name)";

$statement_images_table_insert_query = $db->prepare($images_table_insert_query);

// PLAYER IMAGE
$images_table_update_query = "UPDATE Images SET image_name = :image_name
                        WHERE player_id = :player_id";


$statement_images_table_update_query = $db->prepare($images_table_update_query);

try{
    $db->beginTransaction();

    $statement_players_table_update->bindValue(":player_name", $validated_player_name);
    $statement_players_table_update->bindValue(":player_age", $validated_player_age);
    $statement_players_table_update->bindValue(":player_height", $validated_player_height);
    $statement_players_table_update->bindValue(":player_weight", $validated_player_weight);
    $statement_players_table_update->bindValue(":player_playing_position", $validated_player_playing_position);
    $statement_players_table_update->bindValue(":player_jersey_number", $validated_player_jersey_number);
    $statement_players_table_update->bindValue(":player_profile_description", $validated_player_profile_description);
    $statement_players_table_update->bindValue(":player_id", $player_id);
    $statement_players_table_update->execute();

    // $statement_satistics_update->bindValue(":number_of_matches_played", $validated_number_of_matches_played);
    // $statement_satistics_update->bindValue(":total_goals", $validated_total_goals);
    // $statement_satistics_update->bindValue(":total_assists", $validated_total_assists);
    // $statement_satistics_update->bindValue(":yellow_cards", $validated_yellow_cards);
    // $statement_satistics_update->bindValue(":red_cards", $validated_red_cards);
    // $statement_satistics_update->bindValue(":player_id", $player_id);
    // $statement_satistics_update->execute();

    $statement_images_table_select_query->bindValue(":player_id", $player_id);
    $statement_images_table_select_query->execute();
    $statement_images_table_select_query_rows = $statement_images_table_select_query->fetchAll(PDO::FETCH_ASSOC);

    if(isset($image_name) && count($statement_images_table_select_query_rows) > 0){
        $statement_images_table_update_query->bindValue(":player_id", $player_id);
        $statement_images_table_update_query->bindValue(":image_name", $image_name);

        $statement_images_table_update_query->execute();
    }
    else if(isset($image_name) && count($statement_images_table_select_query_rows) === 0){
        $statement_images_table_insert_query->bindValue(":player_id", $player_id);
        $statement_images_table_insert_query->bindValue(":image_name", $image_name);
        $statement_images_table_insert_query->execute();
    }

    $db->commit();

    header("Location: edit_player.php?player_id=$player_id");
    exit();
}
catch(PDOException $e){
    echo "Error in updating players: " . $e->getMessage();
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>