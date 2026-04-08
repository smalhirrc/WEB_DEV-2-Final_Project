<?php
session_start();
require('mutual_content.php');

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
else if(isset($_GET['for']) && $_GET['for'] === "login"){
    $directto = "homepage";
    // will come from log in link, only if not logged in
    // fill form first
}

// CAME HERE FROM 'LOG OUT' LINK ON INDEX PAGE
else if(isset($_GET['for']) && $_GET['for'] === "logout"){
    session_destroy();
    header("Location: index.php");
    exit();
}

// CAME HERE FROM 'EDIT PLAYER' LINK ON PLAYER'S PAGE
else if(isset($_GET['for']) && $_GET['for'] === "edit"){
    $directto = "edit";
    $player_id = $_GET['player_id'];

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
        header("Location: edit_player.php?for=edit&player_id=$player_id");
        exit();
    }
}

else{
    $directto = "homepage";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
</body>
</html>