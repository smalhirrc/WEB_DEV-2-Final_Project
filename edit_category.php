<?php

session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    header('Location: log_in_required.php');
    exit();
}

require "mutual_content.php";
require "connect.php";

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "";

$player_categories_table_select = "SELECT category_name FROM Player_Categories WHERE category_id = :category_id";

$statement_player_categories_table_select = $db->prepare($player_categories_table_select);

$statement_player_categories_table_select->bindValue(":category_id", $category_id);

$statement_player_categories_table_select->execute();

$category_row = $statement_player_categories_table_select->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>
    <div>
        <div>
            <p>Category Current Name: "<?= $category_row['category_name'] ?>"</p>
            <p>
                <form action="update_category.php?message=update&category_id=<?=$category_id?>" method="post">
                    <label for="updated_category">Change to:</label>
                    <input type="text" id="updated_category" name="updated_category">
                    <span class="error_field" id="updated_category_input_error">* Category name required</span>
                    <button id="submit" type="submit">Update</button>
                    <button id="reset" type="reset">Reset</button>
                </form>
            </p>
        </div>
    </div>
    <script src="player_categories_update.js"></script>
</body>
</html>