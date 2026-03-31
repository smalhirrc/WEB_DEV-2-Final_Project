<?php

require "connect.php";
require "mutual_content.php";

$page_player_id = $_GET['player_id'];

$player_page_query = "SELECT p.player_name, 
                             p.player_age, 
                             p.player_height, 
                             p.player_weight, 
                             p.player_playing_position, 
                             p.player_jersey_number 
                      FROM Players p
                      WHERE p.player_id = :player_id";

                    //         --  t.team_name, 
                    //         --  t.team_coach_name, 
                    //         --  t.team_home_ground, 
                    //         --  t.team_founded_in_year, 
                    //         --  s.number_of_matches_played, 
                    //         --  s.total_goals, 
                    //         --  s.total_assists, 
                    //         --  s.yellow_cards, 
                    //         --  s.red_cards, 
                    //         --  c.category_id, 
                    //         --  c.category_name 
                    // --   FROM Players p
                    // --   JOIN Teams t ON p.team_id = t.team_id
                    // --   JOIN Player_satistics s ON p.player_id = s.player_id
                    // --   JOIN Categories c ON p.category_id = c.category_id

$statement_player_page_query = $db->prepare($player_page_query);

$player_current_image_query = "SELECT image_name 
                               FROM Images 
                               WHERE player_id = :player_id";

$statement_player_current_image_query = $db->prepare($player_current_image_query);

try{
    $statement_player_page_query->bindValue(":player_id", $page_player_id);
    $statement_player_page_query->execute();

    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);

    $statement_player_current_image_query->bindValue(":player_id", $page_player_id);
    $statement_player_current_image_query->execute();

    $image_rows = $statement_player_current_image_query->fetch(PDO::FETCH_ASSOC);
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
    <div id="page_link_back_to_players">
        <a href='players.php'>BackToPlayers</a>
    </div>
    <div id="player_profile">
        <div id="player_card">
            <div id="player_image">
                <img src="images/<?=$image_rows['image_name']?>" alt="image of football">
            </div>
            <div id="player_info">
            <?php foreach($rows as $player): ?>
                <p>
                    <?= $player['player_name'] . " (" . $player['player_playing_position'] . ") is " .
                    "He is " . $player['player_age'] . " years old, " .
                    $player['player_height'] . " cm tall, and weighs " .
                    $player['player_weight'] . " kg."; ?>
                </p>
            <?php endforeach ?>
            </div>
        </div>
        <div id="page_link_edit_player">
            <a href="log_in.php?player_id=<?=$page_player_id?>">Edit Player</a>
        </div>
    </div>
</body>
</html>