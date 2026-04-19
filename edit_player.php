<?php

session_start();

if ( !isset($_SESSION['logged_in']) || 
     $_SESSION['logged_in'] !== true
) {
    header('Location: log_in_required.php');
    exit();
}

require "connect.php"; 
require "mutual_content.php";

// **********************************************************
// SANITIZATION FUNCTIONS
// SANITIZE STRINGS
function sanitize_string($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_input = filter_var(
        trim($input_value), 
        FILTER_SANITIZE_SPECIAL_CHARS
    );

    return $sanitized_input;
}

//SANITIZE NUMBERS
function sanitize_number($key){
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_number = filter_var(
        $input_value, 
        FILTER_SANITIZE_NUMBER_INT
    );

    return $sanitized_number;
} 

// SANITIZE FLOAT
function sanitize_float($key)
{
    $input_value = isset($_POST[$key]) ? $_POST[$key] : "";

    $sanitized_float = filter_var(
        $input_value, 
        FILTER_SANITIZE_NUMBER_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION);

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
        return filter_var(
            $input, 
            FILTER_VALIDATE_INT, 
            array(
                "options" => array(
                    "min_range" => 1, 
                    "max_range" => 100
                )
            )
        );
    }

    return false;
}

$validated_player_age = validate_player_age($sanitized_player_age);

// PLAYER HEIGHT
$sanitized_player_height = sanitize_float('player_height');

function validate_player_height($input)
{
    if ( trim($input) !== "" ) {
        return filter_var(
            $input, 
            FILTER_VALIDATE_FLOAT, 
            array(
                "options" => array(
                    "min_range" => 100.0, 
                    "max_range" => 250.0
                )
            )
        );
    }

    return false;
}

$validated_player_height = validate_player_height($sanitized_player_height);

// PLAYER WEIGHT
$sanitized_player_weight = sanitize_float('player_weight');

function validate_player_weight($input)
{
    if ( trim($input) !== "" ) {
        $validated_input = filter_var(
            $input, 
            FILTER_VALIDATE_FLOAT, 
            array(
                "options" => array(
                    "min_range" => 40.0, 
                    "max_range" => 170.0
                )
            )
        );

        if ( $validated_input !== false ) {
            return round(
                $validated_input, 
                2
            );
        }
    }

    return false;
}

$validated_player_weight = validate_player_weight($sanitized_player_weight);

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

// PLAYER IMAGE FILE UPLOAD CHECKING
function file_upload_path($original_filename, $upload_subfolder_name = 'images')
{
    $current_folder = dirname(__FILE__);

    $path_segments = [
        $current_folder, 
        $upload_subfolder_name, 
        basename($original_filename)
    ];

    return join(
        DIRECTORY_SEPARATOR, 
        $path_segments
    );
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

if ( isset($_FILES['player_image']) && 
     $_FILES['player_image']['error'] === 0
) {
    $image_filename = $_FILES['player_image']['name'];

    $new_image_path = file_upload_path($image_filename);

    $temporary_image_path = $_FILES['player_image']['tmp_name'];

    if ( file_is_an_image($temporary_image_path, $new_image_path) ) {
        $image_name = $_FILES['player_image']['name'];

        move_uploaded_file($temporary_image_path, $new_image_path);

// THUMBNAIL   
        $src_image = imagecreatefromjpeg($new_image_path);
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
        $medium_src_image = imagecreatefromjpeg($new_image_path);
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
    else{
        $image_name = false;
    }
}
else {
    $image_name = false;
}

$player_id = $_GET['player_id'];
$category_id = $_POST['player_role'] ? $_POST['player_role'] : null;

// QUERY, PREPARE
$select_image_query = "SELECT image_name, image_thumbnail, image_medium 
    FROM Players
    WHERE player_id = :player_id";

$statement_select_image_query = $db->prepare($select_image_query);

$statement_select_image_query->bindValue("player_id", $player_id);

$statement_select_image_query->execute();

$previous_image = $statement_select_image_query->fetchAll(PDO::FETCH_ASSOC);

// QUERY, PREPARE, BIND, EXECUTE
$players_table_update_query = "UPDATE Players 
                               SET player_name = :player_name, 
                                   player_age = :player_age,
                                   player_height = :player_height,
                                   player_weight = :player_weight,
                                   player_profile_description = :player_profile_description,
                                   image_name = :image_name, 
                                   image_thumbnail = :image_thumbnail, 
                                   image_medium = :image_medium,
                                   category_id = :category_id 
                               WHERE player_id = :player_id";

$statement_players_table_update = $db->prepare($players_table_update_query);

$checks = [validate_player_name($sanitized_player_name), 
    validate_player_age($sanitized_player_age), 
    validate_player_height($sanitized_player_height), 
    validate_player_weight($sanitized_player_weight), 
    validate_player_profile_description($sanitized_player_profile_description)];

if($_POST){
    if(!in_array(false, $checks)){
    try {
        $db->beginTransaction();

        $statement_players_table_update->bindValue(":player_name", $validated_player_name);
        $statement_players_table_update->bindValue(":player_age", $validated_player_age);
        $statement_players_table_update->bindValue(":player_height", $validated_player_height);
        $statement_players_table_update->bindValue(":player_weight", $validated_player_weight);
        $statement_players_table_update->bindValue(":player_profile_description", $validated_player_profile_description);

        // IMAGE CHANGED AND OK
        if ( $image_name !== false ) {
            $statement_players_table_update->bindValue(":image_name", $image_name);
            $statement_players_table_update->bindValue(":image_thumbnail", $image_thumbnail_name);
            $statement_players_table_update->bindValue(":image_medium", $medium);
        }
        // IMAGE NOT CHANGED OR NOT OK
        else if ( !isset($_FILES['player_image']) ||
            $_FILES['error'] !== 0
        ) {
            foreach ( $previous_image as $p_img ) {
                $statement_players_table_update->bindValue(":image_name", $p_img['image_name']);
                $statement_players_table_update->bindValue(":image_thumbnail", $p_img['image_thumbnail']);
                $statement_players_table_update->bindValue(":image_medium", $p_img['image_medium']);
            }
        } 
        // IMAGE NOT OK
        else {
            header("Location: success.php?status=updated_image_invalid");
            exit();
        }

        $statement_players_table_update->bindValue(":category_id", $category_id); 

        $statement_players_table_update->bindValue(":player_id", $player_id);

        $statement_players_table_update->execute();

        $db->commit();

        header("Location: edit_player.php?player_id=$player_id");
        exit();
    }
    catch ( PDOException $e ) {
        echo "Error in updating players: " . $e->getMessage();
    }
    }
    else {
        $player_name_error_message = validate_player_name($sanitized_player_name) === false ? "Player Name is invalid" : ""; 
        // echo $player_name_error_message; 

        $player_age_error_message = validate_player_age($sanitized_player_age) === false ? "Player Age is invalid. Please enter between 1 - 100" : "";
        // echo $player_age_error_message;

        $player_height_error_message = validate_player_height($sanitized_player_height) === false ? "Player Height is invalid. Please enter between 100.0 - 250.0" : "";
        // echo $player_height_error_message;

        $player_weight_error_message = validate_player_weight($sanitized_player_weight) === false ? "Player Weight is invalid. Please enter between 40.0 - 170.0" : "";
        // echo $player_weight_error_message;

        $player_profile_description_error_message = validate_player_profile_description($sanitized_player_profile_description) === false ? "Player Profile Description is invalid" : "";
        // echo $player_profile_description_error_message;

        $error_checks = [$player_name_error_message, 
            $player_age_error_message, 
            $player_height_error_message, 
            $player_weight_error_message, 
            $player_profile_description_error_message];

        $errors = [];

        foreach($error_checks as $check){
            if($check !== ""){
                $errors[] = $check;
            }
        }      
    }
}
// **********************************************************

$page_player_id = $_GET['player_id'];

// QUERY, PREPARE
$player_page_query = "SELECT player_id, 
                            player_name,
                            player_age, 
                            player_height, 
                            player_weight, 
                            player_profile_description, 
                            image_name, 
                            category_id
                      FROM Players
                      WHERE player_id = :player_id";

$statement_player_page_query = $db->prepare($player_page_query);

try {
    $db->beginTransaction();

// BIND, EXECUTE, FETCH
    $statement_player_page_query->bindValue(":player_id", $page_player_id);
    $statement_player_page_query->execute();

    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);

    $db->commit();
}
catch ( PDOException $e ) {
    echo "Error in showing values: " . $e->getMessage();
}

$player_categories_table_select = "SELECT category_id, category_name 
    FROM Player_Categories";

$statement_player_categories_table_select = $db->prepare($player_categories_table_select);

$statement_player_categories_table_select->execute();

$category_rows = $statement_player_categories_table_select->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if (in_array(false, $checks) && $_POST): ?>
    <div id="error_container">
        <div id="errors">
            <h1>Player not updated</h1>
            <?php foreach($errors as $error_messages): ?>
                <p class="error_fields">* <?=$error_messages?></p>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>
<div id="data_form_container">
        <h1>Update Player</h1>
        <?php foreach($rows as $player): ?>
            <?php $image_set = $player['image_name'] !== null ? 1 : 0 ?>
            <script>
                let image_set = <?=isset($image_set) ? $image_set : 0 ?>
            </script>
            <form id="player_data_form" method="post" enctype="multipart/form-data" action="edit_player.php?player_id=<?=$player['player_id']?>">
                <fieldset>
                    <legend><?=$player['player_name'] . "'s"?> Information</legend>
                    <ul>
                        <li>
                            <label for="player_name">Player Name: </label>
                            <input type="text" id="player_name" name="player_name" value="<?=$player['player_name']?>">
                            <span id="player_name_error" class="error_field">* Player name is required.</span>
                        </li>
                        <li>
                            <label for="player_age">Player Age: </label>
                            <input type="number" id="player_age" name="player_age" value="<?=$player['player_age']?>">
                            <span id="player_age_error" class="error_field">* Valid player age is required.</span>
                        </li>
                        <li>
                            <label for="player_height">Player Height (cm): </label>
                            <input type="number" id="player_height" name="player_height" step="any" min="100" max="250" value="<?=$player['player_height']?>">
                            <span id="player_height_error" class="error_field">* Player height is required.</span>
                        </li>
                        <li>
                            <label for="player_weight">Player Weight (kg): </label>
                            <input type="number" id="player_weight" name="player_weight" step="any" min="40" max="170" value="<?=$player['player_weight']?>">
                            <span id="player_weight_error" class="error_field">* Player weight is required.</span>
                        </li>
                        <li>
                            <label for="player_profile_description">Player Description: </label>
                            <input id="player_profile_description" name="player_profile_description" value="<?=$player['player_profile_description']?>">
                            <span id="player_profile_description_error" class="error_field">* Player's profile description is required.</span>
                        </li>
                        <li>
                            <label for="player_role">Player Role: </label>
                            <select id="player_role" name="player_role">
                                <option value="" <?=$player['category_id'] === null ? "selected" : ""?>></option>
                                <?php foreach($category_rows as $category): ?>
                                    <option value="<?= $category['category_id'] ?>" <?=$player['category_id'] === $category['category_id'] ? "selected" : ""?>><?= $category['category_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <span id="player_role_error" class="error_field">* Please select player role</span>
                            <span>Category not found?<a href="add_role.php"> add </a></span>
                        </li>
                        <li>
                            <p class="current_image_preview">
                                <img src="images/<?=$player['image_name']?>" alt="player's image">
                            </p>
                            <p class="new_image_preview">
                                <img src="#" alt="image">
                            </p>
                        </li>
                        <li>
                            <label for="player_image" class="add_image_label">Change Player Image</label>
                            <input type="file" name="player_image" id="player_image" onchange="show_preview(this)">
                        </li>
                        <p id="remove_image_link">
                            <a href="delete.php?player_id=<?=$page_player_id?>&action=remove_image" onClick="return confirm('Do you want to remove image?');">&times; Remove Image</a>
                        </p>
                    </ul>
                </fieldset>
                <button type="submit" id="submit" name="submit">Update Player</button>
                <button type="reset" id="reset" name="reset">Reset</button>
            </form>
        <?php endforeach ?>
    </div>
    <div id="delete_player_link">
        <a href="delete.php?player_id=<?=$page_player_id?>" onClick="return confirm('Are you sure you want to delete the Player?');">Delete Player</a>
    </div>
    <script src="data_form_validate.js"></script>
</body>
</html>