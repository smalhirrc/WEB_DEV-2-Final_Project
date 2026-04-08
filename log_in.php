<?php
session_start();

// CAME HERE FROM 'ADD PLAYER' LINK ON INDEX PAGE
if(isset($_GET['for']) && $_GET['for'] === "add"){
    $directto = "add";
    // if session is logged in 
    if($_SESSION['logged_in'] && $_SESSION['logged_in'] === true){
        header("Location: add_data.php");
        exit();
    }
    // else fill form below 
}

// CAME HERE FROM 'LOG IN' LINK ON INDEX PAGE
if(isset($_GET['for']) && $_GET['for'] === "login"){
    $directto = "homepage";
    // will come from log in link, only if not logged in
    // fill form first
}

// CAME HERE FROM 'LOG OUT' LINK ON INDEX PAGE
if(isset($_GET['for']) && $_GET['for'] === "logout"){
    session_destroy();
    header("Location: index.php");
    exit();
}

// CAME HERE FROM 'EDIT PLAYER' LINK ON PLAYER'S PAGE
if(isset($_GET['for']) && $_GET['for'] === "edit"){
    $directto = "edit";

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
        $player_id = $_GET['player_id'];
        header("Location: edit_player.php?player_id=$player_id");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <header></header>
    <main>
        <div class="login_container">
            <form method="post" action="authenticate.php?player_id=<?=$player_id?>&directto=<?=$directto?>" class="login_form">

                <h2>Login</h2>

                <label for="user_name">Username: </label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter your username">

                <label for="password">Password: </label>
                <input type="password" id="password" name="password" placeholder="Enter your password">

                <button type="submit" id="log_in" name="log_in">LogIn</button>
            </form>
        </div>
    </main>
    <footer></footer>
</body>
</html>