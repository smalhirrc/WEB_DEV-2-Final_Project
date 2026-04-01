<?php

require "mutual_content.php";
require "connect.php";

if(isset($_GET['message']) && $_GET['message'] === "deleted"){
    echo "Player deleted successfully";
}
if(isset($_GET['message']) && $_GET['message'] === "removed"){
    echo "Image removed successfully";
}

$players_query = "SELECT p.player_id, p.player_name, p.player_profile_description 
                  FROM Players p";

$statement = $db->prepare($players_query);

$player_current_image_query = "SELECT image_name 
                               FROM Images
                               WHERE player_id = :player_id";

$statement_player_current_image_query = $db->prepare($player_current_image_query);

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
        <div id="player_list">
            <?php foreach($rows as $player): ?>
                <?php $player_id = $player['player_id'];
                      try{
                      $statement_player_current_image_query->bindValue(":player_id", $player_id);

                      $statement_player_current_image_query->execute();
                      $image_rows = $statement_player_current_image_query->fetchAll(PDO::FETCH_ASSOC);
                      }
                      catch(PDOException $e){
                          echo "Error is : " . $e->getMessage();  
                      }
                ?>
                <div class="player_row">
                    <div class="player_image">
                        <img src="images/<?=$image_rows[0]['image_name']?>" alt="players image">
                    </div>
                    <p>
                        <a href="player_page.php?player_id=<?=$player_id?>"><?=$player['player_name']?></a>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>