<?php

session_start();

require "connect.php";
require "mutual_content.php";

$page_player_id = filter_input(INPUT_GET, 'player_id', FILTER_VALIDATE_INT);

// QUERY, PREPARE, BIND, EXECUTE, FETCH
$player_page_query = "SELECT player_name, player_age, player_height, player_weight, image_medium 
    FROM Players
    WHERE player_id = :player_id";

$statement_player_page_query = $db->prepare($player_page_query);

try {
    $statement_player_page_query->bindValue(":player_id", $page_player_id);

    $statement_player_page_query->execute();

    $rows = $statement_player_page_query->fetchAll(PDO::FETCH_ASSOC);
}
catch ( PDOException $e ) {
    echo "Error is: " . $e->getMessage();
}

$data = isset($_GET['page_top_search_input']) ? $_GET['page_top_search_input'] : "";

$data_sanitized = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);

function validate_search_input($input){
    if( !empty(trim($input)) && preg_match('/^[a-zA-Z0-9 .,]+$/', $input) ) {
        return $input;
    }
    else {
        return false;
    }
}

$validated_data_sanitized = validate_search_input($data_sanitized);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($player['player_name'])?>'s Page</title>
</head>
<body>
    <?php if(trim($validated_data_sanitized) !== "" || $validated_data_sanitized !== false): ?>
        <div id="go_back_link">
            <a href='search_result.php?page_top_search_input=<?=$validated_data_sanitized?>'>BackToResults</a>
        </div>
        <?php else: ?>
        <div id="go_back_link">
            <a href='players.php'>BackToPlayers</a>
        </div>
    <?php endif ?>
    <div id="player_profile">
        <?php foreach($rows as $player): ?>
        <div id="player_card">
            <div id="player_profile_image">
                <?php if($player['image_medium'] !== null): ?>
                <img src="images/<?=htmlspecialchars($player['image_medium'])?>" alt="image of player">
                <?php endif ?>
            </div>
            <div id="player_info">
                <p>
                    <?= htmlspecialchars($player['player_name']) .
                    " is " . htmlspecialchars($player['player_age']) . " years old, " .
                    htmlspecialchars($player['player_height']) . " cm tall, and weighs " .
                    htmlspecialchars($player['player_weight']) . " kg."; ?>
                </p>
            </div>
        </div>
        <?php endforeach ?>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div id="edit_player_link">
                <a href="log_in.php?for=edit&player_id=<?=$page_player_id?>">Edit Player</a>
            </div>
        <?php endif ?>
    </div>
</body>
</html>