<?php

session_start();

if ( !isset($_SESSION['logged_in']) || 
     $_SESSION['logged_in'] !== true
) {
    header('Location: log_in_required.php');
    exit();
}

require "mutual_content.php";
require "connect.php";




$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "";

$sanitized_category_id = filter_var(
    $category_id,
    FILTER_SANITIZE_NUMBER_INT
);

$validated_category_id = filter_var(
    $sanitized_category_id,
    FILTER_VALIDATE_INT
);




// QUERY, PREPARE, BIND, EXECUTE, FETCH - TO SELECT CURRENT CATEGORY
$player_categories_table_select = "SELECT category_name 
    FROM Player_Categories 
    WHERE category_id = :category_id";

$statement_player_categories_table_select = $db->prepare($player_categories_table_select);

$statement_player_categories_table_select->bindValue(":category_id", $validated_category_id);

$statement_player_categories_table_select->execute();

$category_row = $statement_player_categories_table_select->fetch();




function sanitize_string($key)
{
    $input = isset($_POST[$key]) ? $_POST[$key] : "";

    return filter_var(
        trim($input), 
        FILTER_SANITIZE_SPECIAL_CHARS
    );
}

function valid_category_name($input)
{
    if ( trim($input) !== "" && preg_match('/^[a-zA-Z ]+$/', trim($input)) ) {
        return $input;
    }
    return false;
}

$sanitized_category_name = sanitize_string('updated_category');
$validated_category_name = valid_category_name($sanitized_category_name);




$categories_update_query = "UPDATE Player_Categories 
    SET category_name = :category_name 
    WHERE category_id = :category_id";

$statement_categories_update_query = $db->prepare($categories_update_query);




if( $_POST ) {
    if( $validated_category_name !== false ) {
        try {
            // BIND, EXECUTE
            $statement_categories_update_query->bindValue(":category_id", $category_id);
            $statement_categories_update_query->bindValue(":category_name", $validated_category_name);

            if( $statement_categories_update_query->execute() ) {
                header("Location: success.php?status=category_updated");
                exit();
            }
        }
        catch ( PDOException $e ) {
            echo "Error: " . $e;
        }
    }
    else {
        $category_error_message = "* Please enter valid category";
    }
}

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
                <form action="edit_category.php?category_id=<?=$category_id?>" method="post">
                    <label for="updated_category">Change to:</label>
                    <input type="text" id="updated_category" name="updated_category">
                    <span class="error_field" id="updated_category_input_error">* Category name required</span>
                    <?php if ( isset( $category_error_message ) ): ?>
                        <p class="error_fields"><?= $category_error_message ?></p>
                    <?php endif ?>
                    <button id="submit" type="submit">Update</button>
                    <button id="reset" type="reset">Reset</button>
                </form>
            </p>
        </div>
    </div>
    <script src="player_categories_update.js"></script>
</body>
</html>