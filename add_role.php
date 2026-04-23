<?php

session_start();

if (
    !isset($_SESSION['logged_in']) || 
    $_SESSION['logged_in'] !== true
) {
    header('Location: log_in_required.php');
    exit();
}

require "mutual_content.php";
require "connect.php";




$player_categories_table_select = "SELECT category_id, category_name FROM Player_Categories";

$statement_player_categories_table_select = $db->prepare($player_categories_table_select);

$statement_player_categories_table_select->execute();

$category_rows = $statement_player_categories_table_select->fetchAll(PDO::FETCH_ASSOC);




function sanitize_string($key)
{
    $input = $_POST[$key] ? $_POST[$key] : "";

    return filter_var(
        trim($input), 
        FILTER_SANITIZE_SPECIAL_CHARS
    );
}

function validate_player_role($input)
{
    if ( trim($input) !== "" && preg_match('/^[a-zA-Z ]+$/', trim($input)) ) {
        return $input;
    }

    return false;
}

$sanitized_player_role = sanitize_string('player_role');
$validated_player_role = validate_player_role($sanitized_player_role);




// QUERY, PREPARE, BIND, EXECUTE - TO INSERT CATEGORY
$player_role_query = "INSERT INTO Player_Categories (category_name) 
    VALUES (:player_role)";

$statement_player_role_query = $db->prepare($player_role_query);




if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if( $validated_player_role !== false ) {
        $statement_player_role_query->bindValue(":player_role", $validated_player_role);

        if ( $statement_player_role_query->execute() ) {
            header("Location: success.php?status=roleadded");
            exit();
        }
    }
    else {
        $player_role_error_message = "* Please enter valid player category"; 
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player Role</title>
</head>
<body>
    <h1>Manage Player Categories</h1>
    <br>
    <p><i>Players are categorized by their on-field playing positions, such as midfielder, attacker, defender etc.</i></p>
    <div id="add_role_form_container">
        <form id="add_role_form" action="" method="post">
            <fieldset>
                <lagend>Player Category</legend>
                <ul>
                    <li>
                        <label for="player_role">Add here: </label>
                        <input type="text" id="player_role" name="player_role"> 
                        <span class="error_field" id="add_category_input_error">* Category name required</span>
                        <?php if ( isset($player_role_error_message) ): ?>
                            <p class="error_fields"><?= $player_role_error_message ?></p>
                        <?php endif ?>
                    </li>
                </ul>
            </fieldset>
            <button id="submit" type="submit">Add</button>
            <button id="reset" type="reset">Reset</button>
        </form>
    </div>
    <div id="categories_table_container">
        <table class="categories_table">
            <thead>
                <tr>
                    <th>Index</th>
                    <th>Category Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; ?>
                <?php foreach($category_rows as $category): ?>
                <?php $i += 1; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?=$category['category_name']?></td>
                        <td><a href="edit_category.php?category_id=<?=$category['category_id']?>">edit</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script src="player_categories.js"></script>
</body>
</html>