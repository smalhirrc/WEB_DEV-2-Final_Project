<?php

require "connect.php";
require "mutual_content.php";

$page_player_id = $_GET['player_id'];

$player_page_query = "SELECT player_name, 
                             player_age, 
                             player_height, 
                             player_weight, 
                             player_playing_position, 
                             player_jersey_number,
                             image_medium 
                      FROM Players
                      WHERE player_id = :player_id";

$statement_player_page_query = $db->prepare($player_page_query);

try{
    $statement_player_page_query->bindValue(":player_id", $page_player_id);
    $statement_player_page_query->execute();

    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo "Error is: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$player['player_name']?>'s Page</title>
</head>
<body>
    <div id="back_to_players_link">
        <a href='players.php'>BackToPlayers</a>
    </div>
    <div id="player_profile">
        <?php foreach($rows as $player): ?>
        <div id="player_card">
            <div id="player_profile_image">
                <img src="images/<?=$player['image_medium']?>" alt="image of player">
            </div>
            <div id="player_info">
                <p>
                    <?= $player['player_name'] . " (" . $player['player_playing_position'] . ") is " .
                    "He is " . $player['player_age'] . " years old, " .
                    $player['player_height'] . " cm tall, and weighs " .
                    $player['player_weight'] . " kg."; ?>
                </p>
            </div>
        </div>
        <?php endforeach ?>
        <div id="edit_player_link">
            <a href="log_in.php?player_id=<?=$page_player_id?>">Edit Player</a>
        </div>
    </div>
</body>
</html>