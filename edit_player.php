<?php

require "connect.php"; 
require "mutual_content.php";

$page_player_id = $_GET['player_id'];

$player_page_query = "SELECT p.player_id,
                             p.player_name, 
                             p.player_age, 
                             p.player_height, 
                             p.player_weight, 
                             p.player_playing_position, 
                             p.player_jersey_number, 
                             p.player_profile_description
                      FROM Players p
                      WHERE p.player_id = :player_id";

$statement_player_page_query = $db->prepare($player_page_query);

$player_current_image_query = "SELECT image_name 
                               FROM Images 
                               WHERE player_id = :player_id";

$statement_player_current_image_query = $db->prepare($player_current_image_query);

try{
    $db->beginTransaction();

    $statement_player_page_query->bindValue(":player_id", $page_player_id);
    $statement_player_page_query->execute();

    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);

    $statement_player_current_image_query->bindValue(":player_id", $page_player_id);
    $statement_player_current_image_query->execute();

    $image_rows = $statement_player_current_image_query->fetch(PDO::FETCH_ASSOC);

    $db->commit();
}
catch(PDOException $e){
    echo "Error in showing values: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
    <script src="data_form_validate.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="data_form_container">
        <h1>Update Player</h1>
        <?php foreach($rows as $player): ?>
            <form id="player_data_form" method="post" enctype="multipart/form-data" action="update_data_submission.php?player_id=<?=$player['player_id']?>">
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
                            <label for="player_playing_position">Player Playing Position: </label>
                            <input type="text" id="player_playing_position" name="player_playing_position" value="<?=$player['player_playing_position']?>">
                            <span id="player_playing_position_error" class="error_field">* Player's playing position is required.</span>
                        </li>
                        <li>
                            <label for="player_jersey_number">Player Jersey Number: </label>
                            <input type="number" id="player_jersey_number" name="player_jersey_number" value="<?=$player['player_jersey_number']?>">
                            <span id="player_jersey_number_error" class="error_field">* Player's jersey number is required.</span>
                        </li>
                        <li>
                            <label for="player_profile_description">Player Description: </label>
                            <input id="player_profile_description" name="player_profile_description" value="<?=$player['player_profile_description']?>">
                            <span id="player_profile_description_error" class="error_field">* Player's profile description is required.</span>
                        </li>
                        <li>
                            <p>
                                <img src="images/<?=$image_rows['image_name']?>" alt="players image" id="current_image_preview">
                            </p>
                            <p>
                                <img src="#" alt="new image" id="new_image_preview">
                            </p>
                        </li>
                        <li>
                            <label for="player_image" id="add_image_label">Change Player Image</label>
                            <input type="file" name="player_image" id="player_image" onchange="show(this)">
                        </li>
                        <p id="remove_image_link">
                            <a href="">&times; Remove Image</a>
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
</body>
</html>