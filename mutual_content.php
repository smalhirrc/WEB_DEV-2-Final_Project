<?php
session_start();

$logged_in = isset($_SESSION['logged_in']) && 
    $_SESSION['logged_in'] === true;

$is_admin = $_SESSION['is_admin'] === true;

require "connect.php";

// SELECT FOR DROPDOWN OPTIONS AND VALUES
$player_categories_table_select = "SELECT category_id, category_name FROM Player_Categories";

$statement_player_categories_table_select = $db->prepare($player_categories_table_select);

$statement_player_categories_table_select->execute();

$category_rows = $statement_player_categories_table_select->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header id="header">


        <div id="logo_div">
            <img src="images/good_guides_logo.jpeg" alt="Good Guides logo image" width="100" height="50">
        </div>




        <div id="page_top_right_container">


            <div id="header_links">
                <a href='index.php'>Homepage</a>
                <a href="log_in.php?for=add">Add Player</a>
                <a href="players.php">See Players</a>
                <?php if($logged_in): ?>
                    <a href="add_role.php">Manage Categories</a>
                    <?php if($is_admin): ?>
                        <a href="manage_users_area.php">Manage Users</a>
                    <?php endif ?>
                        <a href="log_in.php?for=logout" onClick="return confirm('Are you sure you want to logout?');">Log Out</a>
                <?php else: ?>
                <a href="log_in.php?for=login">Log In</a>
                <?php endif ?>
            </div>


        </div>


    </header>




    <?php if(isset($_GET['message']) && $_GET['message'] === 'success'):?>
    <?= "<h1>WELCOME, You are now logged in!</h1>" ?>
    <?php endif ?>

<main>
    <div id="search_form_container">
        <form id="search_form" action="search_result.php" method="get">
            <input type="text" id="page_top_search_input" name="page_top_search_input" value="<?=htmlspecialchars($_POST['page_top_search_input'])?>">
            <button type="submit">Search</button>
            <label for="search_by_category">By category: </label>
            <select id="search_by_category" name="select_input">
                <option value="">All</option>
                <?php foreach($category_rows as $category): ?>
                    <option value="<?=$category['category_id']?>"><?=$category['category_name']?></option>
                <?php endforeach ?>
            </select>
        </form>
    </div>    
</main>


    <footer>

    </footer>
</body>
</html>