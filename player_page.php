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
                      WHERE p.player_id = $page_player_id";

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

try{
    $statement_player_page_query->execute();
    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $player){
        echo $player['player_name'] . " (" . $player['player_playing_position'] . ") is ";

        echo "He is " . $player['player_age'] . " years old, "
        . $player['player_height'] . " cm tall, and weighs "
        . $player['player_weight'] . " kg. <br>";
    }
}
catch(PDOException $e){
    echo "Error is: " . $e->getMessage();
}

echo "<a href='players.php'>BackToPlayers</a><br>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$player['player_name']?>'s Page</title>
</head>
<body>
    <div>
        <a href="log_in.php?player_id=<?=$page_player_id?>">Edit Player</a>
    </div>
</body>
</html>