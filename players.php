<?php

require "mutual_content.php";
require "connect.php";

if(isset($_GET['message']) && $_GET['message'] === "deleted"){
    echo "Player deleted successfully";
}
if(isset($_GET['message']) && $_GET['message'] === "removed"){
    echo "Image removed successfully";
}

$players_query = "SELECT player_id, player_name, image_thumbnail
                  FROM Players";

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
    <aside aria-label="Sort Players" id="players_page_aside">
        <nav id="players_sorting_bar">
            <h2>Sort by:</h2>
            <ul>
                <li>
                    <a href="">Name</a>
                </li>
                <li>
                    <a href="">Date Created</a>
                </li>
                <li>
                    <a href="">Date Modified</a>
                </li>
            </ul>
        </nav>
    </aside>
    <main>
        <div id="player_list">
            <?php foreach($rows as $player): ?>
                <div class="player_row">
                    <div class="player_image">
                        <img src="images/<?=$player['image_thumbnail']?>" alt="players image">
                    </div>
                    <p>
                        <a href="player_page.php?player_id=<?=$player['player_id']?>"><?=$player['player_name']?></a>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>