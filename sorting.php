<?php

session_start();

require "connect.php";
require "mutual_content.php";

// QUERY, PREPARE - SORT BY NAME
$sorting_query_by_name = "SELECT player_id, player_name, image_thumbnail 
    FROM Players 
    ORDER BY player_name 
    ASC";

$statement_sorting_query_by_name = $db->prepare($sorting_query_by_name);

// QUERY, PREPARE - SORT BY DATE CREATED
$sorting_query_by_date_created_at = "SELECT player_id, player_name, image_thumbnail FROM Players ORDER BY date_created_at DESC";

$statement_sorting_query_by_date_created_at = $db->prepare($sorting_query_by_date_created_at);

// QUERY, PREPARE - SORT BY MODIFIED
$sorting_query_by_date_modified = "SELECT player_id, player_name, image_thumbnail FROM Players ORDER BY updated_at DESC";

$statement_sorting_query_by_date_modified = $db->prepare($sorting_query_by_date_modified);

try {
    if ( isset($_GET['sortby']) && 
         $_GET['sortby'] === "name"
    ) {
        // EXECUTE, FETCH - SORT BY NAME
        $statement_sorting_query_by_name->execute();

        $rows = $statement_sorting_query_by_name->fetchAll(PDO::FETCH_ASSOC);

        $name_class = "active";
    }

    if ( isset($_GET['sortby']) && 
         $_GET['sortby'] === 'createdat'
    ) {
       // EXECUTE, FETCH - SORT BY DATE CREATED
       $statement_sorting_query_by_date_created_at->execute();
       
       $rows = $statement_sorting_query_by_date_created_at->fetchAll(PDO::FETCH_ASSOC);

       $created_class = "active";
    }

    if ( isset($_GET['sortby']) && 
         $_GET['sortby'] === 'modifiedat'
    ) {
        // EXECUTE, FETCH - SORT DATE CREATED 
        $statement_sorting_query_by_date_modified->execute();

        $rows = $statement_sorting_query_by_date_modified->fetchAll(PDO::FETCH_ASSOC);

        $modified_class = "active";
    }
}
catch ( PDOException $e ) {
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
    <?php if ( isset($_SESSION['logged_in']) ): ?>
    <aside aria-label="Sort Players" id="players_page_aside">
        <nav id="players_sorting_bar">
            <p>Sort by:</p>
            <ul>
                <li>
                    <a href="sorting.php?sortby=name" class="<?=$name_class?>">Name</a>
                </li>
                <li>
                    <a href="sorting.php?sortby=createdat" class="<?=$created_class?>">Date Created</a>
                </li>
                <li>
                    <a href="sorting.php?sortby=modifiedat" class="<?=$modified_class?>">Date Modified</a>
                </li>
            </ul>
        </nav>
    </aside>
    <?php endif ?>
    <main class="players_list_page_main">
        <div id="player_list">
            <?php foreach ( $rows as $player ): ?>
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