<?php

require "mutual_content.php";
require "connect.php";

if(isset($_GET['message']) && $_GET['message'] === "deleted"){
    echo "Player deleted successfully";
}

$players_query = "SELECT p.player_id, p.player_name, t.team_name 
                  FROM Players p 
                  JOIN Teams t ON p.team_id = t.team_id";

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
        <table class="players_table">
            <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Player Team</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $player): ?>
                <tr>
                    <td><a href="player_page.php?player_id=<?=$player['player_id']?>" class="player_page"><?=$player['player_name']?></td>
                    <td><?= $player['team_name'] ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
</body>
</html>