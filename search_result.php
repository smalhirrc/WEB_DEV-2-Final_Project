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

// if(isset($_GET['limit']) && isset($_GET['offset'])){
    // $uptolimit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?? 100;
    // $fromoffset = filter_input(INPUT_GET, 'offset', FILTER_VALIDATE_INT) ?? 0;
// }

require 'connect.php';

$search_item = strtolower("%" . $validated_search_input . "%");

if ( isset($_GET['select_input']) && 
    !empty($_GET['select_input'])
) {
    $select_input = filter_input(INPUT_GET, 'select_input', FILTER_VALIDATE_INT);

    $search_query = "SELECT player_id, player_name, player_height, player_weight, player_age, player_profile_description, category_id
FROM Players
WHERE (
        LOWER(player_name) LIKE :search_input OR 
        player_age LIKE :search_input OR
        player_height LIKE :search_input OR
        player_weight LIKE :search_input OR
        LOWER(player_profile_description) LIKE :search_input
    ) 
    AND category_id = :select_input
    ORDER BY player_name ASC";

}
else {
    $search_query = "SELECT player_id, player_name, player_height, player_weight, player_age, player_profile_description, category_id
        FROM Players
        WHERE (
            LOWER(player_name) LIKE :search_input OR 
            player_age LIKE :search_input OR
            player_height LIKE :search_input OR
            player_weight LIKE :search_input OR
            LOWER(player_profile_description) LIKE :search_input
        )
        ORDER BY player_name ASC";

}

$statement_search_query = $db->prepare($search_query);

if($validated_search_input !== false){
    try{
        $statement_search_query->bindValue(":search_input", $search_item);

        if ( isset($_GET['select_input']) && 
            !empty($_GET['select_input'])
        ) {
            $statement_search_query->bindValue(":select_input", $select_input);
        }
        $statement_search_query->execute();

        $search_match_rows = $statement_search_query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo "There is error: " . $e;
    }
}

$json_array = [];

foreach($search_match_rows as $rows){
    $json_array[] = [
        "player_id" => $rows['player_id'],
        "player_name" => $rows['player_name'],
        "player_age" => $rows['player_age'],
        "player_height" => $rows['player_height'],
        "player_weight" => $rows['player_weight'],
        "player_profile_description" => $rows['player_profile_description']
    ];
}

$json_data = json_encode($json_array);

file_put_contents("search_result_data.json", $json_data);

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
    <script>let search_input = "<?=$validated_search_input?>";</script>
</head>
<body>


    <?php if(isset($_GET['page_top_search_input'])): ?>
        <h1>Results for: "<?=htmlspecialchars($validated_search_input)?>"</h1>
    <?php endif ?>
            <div id="result_count_container">
            <p>
                <span id="result_count"></span>
            </p>
        </div>
    <div id="search_match_link_container">
        <p>    
        </p>
        <div id="pagination">
            <a href="#" class="back">back</a>
            <a href="#" class="next">next</a>
        </div>
        <div id="result_page_links_container">
            <ul id="result_page_links_list">
            </ul>
        </div>
    </div>


    <script src="search_result_srcipt.js"></script>        
</body>
</html>