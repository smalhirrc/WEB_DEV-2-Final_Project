<?php

require "connect.php";

$page_player_id = $_GET['player_id'];

// $delete_player_satistic_query = "DELETE FROM Player_satistics WHERE player_id = :player_id";
// $statement_delete_player_satistics = $db->prepare($delete_player_satistic_query);

$delete_player_query = "DELETE FROM Players WHERE player_id = :player_id";
$statement_delete_player = $db->prepare($delete_player_query);

$remove_image_query = "UPDATE Players SET image_name = :image_name, image_thumbnail = :image_thumbnail, image_medium = :image_medium WHERE player_id = :player_id";
$statement_remove_image_query = $db->prepare($remove_image_query);

try{
    $db->beginTransaction();

    // $statement_delete_player_satistics->bindValue(":player_id", $page_player_id);
    // $statement_delete_player_satistics->execute();

    if(isset($_GET['action']) && $_GET['action'] === 'remove_image'){
        $image_name = null;
        $image_thumbnail = null;
        $image_medium = null;

        $statement_remove_image_query->bindValue(":image_name", $image_name);
        $statement_remove_image_query->bindValue(":image_thumbnail", $image_thumbnail);
        $statement_remove_image_query->bindValue(":image_medium", $image_medium);


        $statement_remove_image_query->bindValue(":player_id", $page_player_id);

        $statement_remove_image_query->execute();

        $db->commit();

        header("Location: players.php?message=removed");

        exit();
    }
    if(!isset($_GET['action'])){
        $statement_delete_player->bindValue(":player_id", $page_player_id);
        $statement_delete_player->execute();
        $db->commit();
        header("Location: players.php?message=deleted");

        exit();
    }
}
catch(PDOException $e){
    echo "Error in deleting: " . $e->getMessage();
}

?>