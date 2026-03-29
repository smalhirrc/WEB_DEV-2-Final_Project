<?php

require "connect.php";

$page_player_id = $_GET['player_id'];

// $delete_player_satistic_query = "DELETE FROM Player_satistics WHERE player_id = :player_id";
// $statement_delete_player_satistics = $db->prepare($delete_player_satistic_query);

$delete_player_query = "DELETE FROM Players WHERE player_id = :player_id";
$statement_delete_player = $db->prepare($delete_player_query);

try{
    $db->beginTransaction();

    // $statement_delete_player_satistics->bindValue(":player_id", $page_player_id);
    // $statement_delete_player_satistics->execute();

    $statement_delete_player->bindValue(":player_id", $page_player_id);
    $statement_delete_player->execute();

    $db->commit();

    header("Location: players.php?message=deleted");

    exit();

}
catch(PDOException $e){
    echo "Error in deleting: " . $e->getMessage();
}

?>