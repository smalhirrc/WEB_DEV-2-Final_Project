<?php

require "connect.php";
require "mutual_content.php";

// BY NAME
$sorting_query_by_name = "SELECT player_id, player_name, image_thumbnail FROM Players ORDER BY player_name ASC";

$statement_sorting_query_by_name = $db->prepare($sorting_query_by_name);

// BY DATE CREATED
$sorting_query_by_date_created_at = "SELECT player_id, player_name, image_thumbnail FROM Players ORDER BY date_created_at DESC";

$statement_sorting_query_by_date_created_at = $db->prepare($sorting_query_by_date_created_at);

// BY MODIFIED
$sorting_query_by_date_modified = "SELECT player_id, player_name, image_thumbnail FROM Players ORDER BY updated_at DESC";

$statement_sorting_query_by_date_modified = $db->prepare($sorting_query_by_date_modified);

try{

    if(isset($_GET['sortby']) && $_GET['sortby'] === "name"){
        $statement_sorting_query_by_name->execute();

        $rows = $statement_sorting_query_by_name->fetchAll(PDO::FETCH_ASSOC);
    }

    if(isset($_GET['sortby']) && $_GET['sortby'] === 'createdat'){
       $statement_sorting_query_by_date_created_at->execute();
       
       $rows = $statement_sorting_query_by_date_created_at->fetchAll(PDO::FETCH_ASSOC);
    }

    if(isset($_GET['sortby']) && $_GET['sortby'] === 'modifiedat'){
        $statement_sorting_query_by_date_modified->execute();

        $rows = $statement_sorting_query_by_date_modified->fetchAll(PDO::FETCH_ASSOC);
    }
}
catch(PDOException $e){
    echo "ERROR: " . $e;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorted Results</title>
</head>
<body>
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