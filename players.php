<?php

require "mutual_content.php";
require "connect.php";

if(isset($_GET['message']) && $_GET['message'] === "deleted"){
    echo "Player deleted successfully";
}

$players_query = "SELECT p.player_id, p.player_name, p.player_profile_description 
                  FROM Players p";

$statement = $db->prepare($players_query);

try{
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo "Error is : " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players</title>
</head>
<body>
    <main>
        <?php foreach($rows as $player): ?>
            <div id="player_container">
                <div id="player_image_container">
                    <img src="images/<?=$player['player_name']?>.jpeg" alt="players image">
                </div>
                <p>
                    <a href="player_page.php?player_id=<?=$player['player_id']?>"><?=$player['player_name']?></a>
                </p>
            </div>
        <?php endforeach ?>
    </main>
</body>
</html>