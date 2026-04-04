<?php

if(isset($_GET['status']) && $_GET['status'] === 'added'){
    echo "<h1>Success<h1/>";
    echo "<p>Data added successfully</p>";
    echo '<a href="add_data.php">Add another player</a><br>';
    echo '<a href="index.php">Homepage</a>';
}
else if(isset($_GET['status']) && $_GET['status'] === 'image_invalid'){
    echo "<h1>Error: Invalid image selected</h1>";
    echo '<p>Player not added. <a href="add_data.php">Try again</a>.</p>';
    echo '<a href="index.php">Homepage</a>';
}
else if(isset($_GET['status']) && $_GET['status'] === 'updated_image_invalid'){
    echo "<h1>Error: Invalid image selected</h1>";
    echo '<p>Player not added. <a href="players.php">Try again</a>.</p>';
    echo '<a href="index.php">Homepage</a>';
}
else{
    header("Location: add_data.php");
}

?>