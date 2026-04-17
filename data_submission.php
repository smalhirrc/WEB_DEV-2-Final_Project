<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'connect.php';
require "mutual_content.php";

// SANITIZATION FUNCTIONS
// SANITIZE STRINGS
function sanitize_string($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_input = filter_var(trim($input_value), FILTER_SANITIZE_SPECIAL_CHARS);

    return $sanitized_input;
}

//SANITIZE NUMBERS
function sanitize_number($key)
{
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

function validate_player_name($input)
{
    if ( !empty(trim($input)) ) {
        return $input;
    }
    else {
        return false;
    }
}

$validated_player_name = validate_player_name($sanitized_player_name);

// PLAYER_AGE
$sanitized_player_age = sanitize_number('player_age');

function validate_player_age($input)
{
    if ( trim($input) !== "" ) {
        return filter_var($input, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 100)));
    }
    return false;
}

$validated_player_age = validate_player_age($sanitized_player_age);

// PLAYER HEIGHT
$sanitized_player_height = sanitize_float('player_height');

function validate_player_height($input)
{
    if ( trim($input) !== "" ) {
        return filter_var($input, FILTER_VALIDATE_FLOAT, array("options" => array("min_range" => 100.0, "max_range" => 250.0)));
    }
    return false;
}

$validated_player_height = validate_player_height($sanitized_player_height);

// PLAYER WEIGHT
$sanitized_player_weight = sanitize_float('player_weight');

function validate_player_weight($input)
{
    if ( trim($input) !== "" ) {
        $validated_input = filter_var($input, FILTER_VALIDATE_FLOAT, array("options" => array("min_range" => 40.0, "max_range" => 170.0)));

        if ( $validated_input !== false ) {
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
    if ( !empty($input) ) {
        return $input;
    }
    else {
        return false;
    }
}

$validated_player_playing_position = validate_playing_position($sanitized_player_playing_position);

// PLAYER JERSEY NUMBER
$sanitized_player_jersey_number = sanitize_number('player_jersey_number');

function validate_player_jersey_number($input)
{
    if ( trim($input) !== "" ) {
        return filter_var($input, FILTER_VALIDATE_INT);
    }
    return false;
}

$validated_player_jersey_number = validate_player_jersey_number($sanitized_player_jersey_number);

// PLAYER PROFILE_DESCRIPTION
$sanitized_player_profile_description = sanitize_string('player_profile_description');

function validate_player_profile_description($input)
{
    if ( !empty(trim($input)) ) {
        return $input;
    }
    else {
        return false;
    }
}

$validated_player_profile_description = validate_player_profile_description($sanitized_player_profile_description);

// PLAYER ROLE
$player_role = $_POST['player_role'] ? $_POST['player_role'] : "";

function validate_player_role($input)
{
    $choices = ["Defender", "Midfielder", "Attacker"];

    if ( in_array($input, $choices) ) {
        return $input;
    }
    else {
        return false;
    }
}

$validate_player_role = validate_player_role($player_role);

// PLAYER IMAGE FILE UPLOAD CHECKING
function file_upload_path($original_filename, $upload_subfolder_name = 'images')
{
    $current_folder = dirname(__FILE__);

    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

    return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path)
{
    $image_mime_type = getimagesize($temporary_path)['mime'];
    $image_extension = pathinfo($new_path, PATHINFO_EXTENSION);

    $allowed_mime_types = ['image/jpeg', 'image/png'];
    $allowed_extensions = ['jpeg', 'jpg', 'png'];

    $mime_type_is_valid = in_array($image_mime_type, $allowed_mime_types);
    $file_extension_is_valid = in_array($image_extension, $allowed_extensions);

    return $mime_type_is_valid && $file_extension_is_valid;
}

if ( isset($_FILES['player_image']) && 
     $_FILES['player_image']['error'] === 0
) {
    $image_filename = $_FILES['player_image']['name'];

    $new_image_path = file_upload_path($image_filename);

    $temporary_image_path = $_FILES['player_image']['tmp_name'];

    if ( file_is_an_image($temporary_image_path, $new_image_path) ) {
        $image_name = $_FILES['player_image']['name'];
        $image_mime_type = getimagesize($temporary_image_path)['mime'];

        move_uploaded_file($temporary_image_path, $new_image_path);

        $image_type = pathinfo($new_image_path, PATHINFO_EXTENSION);
        $function_name = "imagecreatefrom" . $image_type;

// THUMBNAIL   
        $src_image = $function_name($new_image_path);
        $src_width = imagesx($src_image);
        $src_height = imagesy($src_image);        
        $src_x = 0;
        $src_y = 0;
        $dst_x = 0;
        $dst_y = 0;
        $dst_width = 60;
        $dst_height = 60;
        $dst_image = imagecreatetruecolor($dst_width, $dst_height);


        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_width, $dst_height, $src_width, $src_height);
    
        $thumbnail = dirname(__FILE__) . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . pathinfo($image_name, PATHINFO_FILENAME) . "_thumbnail." . pathinfo($image_name, PATHINFO_EXTENSION);

        $image_thumbnail_name = pathinfo($image_name, PATHINFO_FILENAME) . "_thumbnail." . pathinfo($image_name, PATHINFO_EXTENSION);

        imagejpeg($dst_image, $thumbnail);

        imagedestroy($src_image);
        imagedestroy($dst_image);


// MEDIUM
        $medium_src_image = $function_name($new_image_path);
        $medium_src_width = imagesx($src_image);
        $medium_src_height = imagesy($src_image);        
        $medium_src_x = 0;
        $medium_src_y = 0;
        $medium_dst_x = 0;
        $medium_dst_y = 0;
        $medium_dst_width = 180;
        $medium_dst_height = 180;
        $medium_dst_image = imagecreatetruecolor($medium_dst_width, $medium_dst_height);


        imagecopyresampled($medium_dst_image, $medium_src_image, $medium_dst_x, $medium_dst_y, $medium_src_x, $medium_src_y, $medium_dst_width, $medium_dst_height, $medium_src_width, $medium_src_height);
    
        $medium_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . pathinfo($image_name, PATHINFO_FILENAME) . "_medium." . pathinfo($image_name, PATHINFO_EXTENSION);

        $medium = pathinfo($image_name, PATHINFO_FILENAME) . "_medium." . pathinfo($image_name, PATHINFO_EXTENSION);

        imagejpeg($medium_dst_image, $medium_path);

        imagedestroy($medium_src_image);
        imagedestroy($medium_dst_image);
    }
    else {
        $image_name = false;
    }
}

// QUERY, PREPARE, BIND, EXECUTE, FETCH
$categories_select = "SELECT category_id 
    FROM Player_Categories 
    WHERE category_name = :player_role 
    LIMIT 1";

$statement_category_select = $db->prepare($categories_select);

$statement_category_select->bindValue(":player_role", $validate_player_role);

$statement_category_select->execute();

$category_id = $statement_category_select->fetchColumn();

// QUERY, PREPARE - TO INSERT PLAYER
$players_query = "INSERT INTO Players (player_name, player_age, player_height, player_weight, player_playing_position, player_jersey_number, player_profile_description, image_name, image_thumbnail, image_medium, category_id) 
    VALUES (:player_name, :player_age, :player_height, :player_weight, :player_playing_position, :player_jersey_number, :player_profile_description, :image_name, :image_thumbnail, :image_medium, :category_id)";

$statement_player_query = $db->prepare($players_query);

try {
    $db->beginTransaction();

    // BIND - TO INSERT PLAYER
    $statement_player_query->bindValue(':player_name', $validated_player_name);
    $statement_player_query->bindValue(':player_age', $validated_player_age);
    $statement_player_query->bindValue(':player_height', $validated_player_height);
    $statement_player_query->bindValue(':player_weight', $validated_player_weight);
    $statement_player_query->bindValue(':player_playing_position', $validated_player_playing_position);
    $statement_player_query->bindValue(':player_jersey_number', $validated_player_jersey_number);
    $statement_player_query->bindValue(':player_profile_description', $validated_player_profile_description);

    // IMAGE
    if ( isset($image_name) && 
         $image_name !== false
    ) {
        $statement_player_query->bindValue(":image_name", $image_name);
        $statement_player_query->bindValue(":image_thumbnail", $image_thumbnail_name);
        $statement_player_query->bindValue(":image_medium", $medium);
    }
    else if ( isset($image_name) && 
              $image_name === false
    ) {
        header("Location: success.php?status=image_invalid");
        exit();
    }
    else {
        $statement_player_query->bindValue(":image_name", null);
        $statement_player_query->bindValue(":image_thumbnail", null);
        $statement_player_query->bindValue(":image_medium", null);
    }

    $statement_player_query->bindValue(":category_id", $category_id);

    // EXECUTE - TO INSERT PLAYER
    $statement_player_query->execute();

    $db->commit();

    echo "Successfully saved Player!";

    header("Location: success.php?status=added&image=$new_image_path");
    exit();
}
catch ( PDOException $e ) {
    if ( $db->inTransaction() ) {
        $db->rollBack();
    }
    echo "Error: " . $e->getMessage();
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
    <header>

    </header>
    <main></main>
    <footer></footer>
</body>
</html>