<?php

require "connect.php";

$page_player_id = filter_input(INPUT_GET, 'player_id', FILTER_VALIDATE_INT);

// QUERY, PREPARE - TO DELETE PLAYER
$delete_player_query = "DELETE FROM Players 
    WHERE player_id = :player_id";

$statement_delete_player = $db->prepare($delete_player_query);

// QUERY, PREPARE - TO UPDATE PLAYER (remove image)
$remove_image_query = "UPDATE Players 
    SET image_name = :image_name, image_thumbnail = :image_thumbnail, image_medium = :image_medium 
    WHERE player_id = :player_id";

$statement_remove_image_query = $db->prepare($remove_image_query);

try {
    $db->beginTransaction();

    if ( isset($_GET['action']) && 
         $_GET['action'] === 'remove_image'
    ) {
        $image_name = null;
        $image_thumbnail = null;
        $image_medium = null;

        // BIND, EXECUTE  - TO UPDATE PLAYER (remove image)
        $statement_remove_image_query->bindValue(":image_name", $image_name);
        $statement_remove_image_query->bindValue(":image_thumbnail", $image_thumbnail);
        $statement_remove_image_query->bindValue(":image_medium", $image_medium);
        $statement_remove_image_query->bindValue(":player_id", $page_player_id);

        $statement_remove_image_query->execute();

        $db->commit();

        header("Location: players.php?message=removed");
        exit();
    }
    if ( !isset($_GET['action']) ) {
        // BIND, EXECUTE - TO DELETE PLAYER
        $statement_delete_player->bindValue(":player_id", $page_player_id);

        $statement_delete_player->execute();

        $db->commit();

        header("Location: players.php?message=deleted");
        exit();
    }
}
catch ( PDOException $e ) {
    echo "Error in deleting: " . $e->getMessage();
}

?>