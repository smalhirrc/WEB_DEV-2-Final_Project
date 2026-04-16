<?php

require "connect.php";
require "mutual_content.php";

if(isset($_GET['message']) && $_GET['message'] === "update"){

    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "";

    function sanitize_string($key)
    {
        $input = isset($_POST[$key]) ? $_POST[$key] : "";

        return filter_var(trim($input), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    function valid_category_name($input)
    {
        if(trim($input) === ""){
            return false;
        }

        return $input;
    }


    $sanitized_category_name = sanitize_string('updated_category');
    $validated_category_name = valid_category_name($sanitized_category_name);

    $categories_update_query = "UPDATE Player_Categories SET category_name = :category_name WHERE category_id = :category_id";

    $statement_categories_update_query = $db->prepare($categories_update_query);

    try{
    $statement_categories_update_query->bindValue(":category_id", $category_id);
    $statement_categories_update_query->bindValue(":category_name", $validated_category_name);

    $statement_categories_update_query->execute();
    }
    catch(PDOException $e){
        echo "Error: " . $e;
    }

    header("Location: success.php?status=category_updated");
    exit();
}

?>