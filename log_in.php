<?php

require "mutual_content.php";

if(isset($_GET['player_id'])){
    $player_id = $_GET['player_id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header></header>
    <main>
        <?php if(isset($_GET['player_id'])): ?>
            <?php $player_id = $_GET['player_id']; ?>
            <form method="post" action="authenticate.php?player_id=<?=$player_id?>">
                <label for="user_name">Username: </label>
                <input type="text" id="user_name" name="user_name">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password">
                <button type="submit" id="log_in" name="log_in">LogIn</button>
            </form>
        <?php else: ?>
                <form method="post" action="authenticate.php">
                <label for="user_name">Username: </label>
                <input type="text" id="user_name" name="user_name">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password">
                <button type="submit" id="log_in" name="log_in">LogIn</button>
            </form>
        <?php endif ?>
    </main>
    <footer></footer>
</body>
</html>