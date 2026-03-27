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
            <div class="login_container">
                <form method="post" action="authenticate.php?player_id=<?=$player_id?>" class="login_form">

                    <h2>Login</h2>

                    <label for="user_name">Username: </label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter your username">

                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">

                    <button type="submit" id="log_in" name="log_in">LogIn</button>

                </form>
            </div>
        <?php else: ?>
            <div class="login_container">
                <form method="post" action="authenticate.php" class="login_form">

                    <h2>Login</h2>

                    <label for="user_name">Username: </label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter your username">

                    <label for="password">Password: </label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">

                    <button type="submit" id="log_in" name="log_in">LogIn</button>
                    
                </form>
            </div>
        <?php endif ?>
    </main>
    <footer></footer>
</body>
</html>