<?php

if(isset($_GET['status']) && $_GET['status'] === 'added'){
    echo "<h1>Success<h1/>";
    echo "<p>Data added successfully</p>";
    echo '<a href="add_data.php">Add another player</a><br>';
    echo '<a href="index.php">Homepage</a>';
}
else{
    header("Location: add_data.php");
}

?>