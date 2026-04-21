<?php

require "mutual_content.php";

// got search input
$search_input = isset($_GET['page_top_search_input']) ? $_GET['page_top_search_input'] : "";

// sanitized it
$sanitized_search_input = filter_var($search_input, FILTER_SANITIZE_SPECIAL_CHARS);

// function to validate it
function validate_search_input($input){
    if( !empty(trim($input)) && preg_match('/^[a-zA-Z0-9 .,]+$/', $input) ) {
        return $input;
    }
    else {
        return false;
    }
}

// validated it
$validated_search_input = validate_search_input($sanitized_search_input);

require 'connect.php';

$search_item = strtolower("%" . $validated_search_input . "%");

$search_query = "SELECT player_id, player_name, player_height, player_weight, player_age, player_profile_description
    FROM Players
    WHERE LOWER(player_name) LIKE :search_input OR 
        LOWER(player_age) LIKE :search_input OR
        LOWER(player_height) LIKE :search_input OR
        LOWER(player_weight) LIKE :search_input OR
        LOWER(player_profile_description) LIKE :search_input";

$statement_search_query = $db->prepare($search_query);

if($validated_search_input !== false){
    try{
        $statement_search_query->bindValue("search_input", $search_item);

        $statement_search_query->execute();

        $search_match_rows = $statement_search_query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo "There is error: " . $e;
    }
}

// echo "input: " . $search_input . "<br>";
// echo "sanitized input: " . $sanitized_search_input . "<br>"; 
// echo "validated: " . $validated_search_input . "<br>"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
</head>
<body>


    <?php if(isset($_GET['page_top_search_input'])): ?>
        <h1>Results for: "<?=$validated_search_input?>"</h1>
<?php foreach($search_match_rows as $row): ?>
        <div id="search_match_link_container">
            <p>
                <!-- Title -->
                <a href="player_page.php?player_id=<?=$row['player_id']?>&page_top_search_input=<?=$validated_search_input?>"><?=$row['player_name']?></a>
            </p>
        </div>
<?php endforeach ?>
    <?php endif ?> 
    
    
</body>
</html>