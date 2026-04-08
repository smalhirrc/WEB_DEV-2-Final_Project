<?php
    echo "Log in required. <a href='log_in.php?for=login'>Log In</a>";

    if(isset($_GET['allowed']) && $_GET['allowed'] === 'admin'){
        echo "Admin's log in required. <a href='log_in.php?for=login'>Log In</a>";
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
    
</body>
</html>