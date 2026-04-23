<?php

require "mutual_content.php";

if ( isset($_GET['message']) && 
     $_GET['message'] === 'signin_success'
) {
    $user_name = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_SPECIAL_CHARS);

    function validate_user_name($input){
        if(!empty($input) && preg_match('/^[a-zA-Z]+$/', $input)){
            return $input;
        }
        return false;
    }

    $validated_user_name = validate_user_name($user_name);

    if($validated_user_name !== false){
        echo "<h1>Sign In successfully</h1>";
        echo "<p>Login with username: " . htmlspecialchars($validated_user_name) ."</p>";
        echo "<p><a href='log_in.php'>Try Log In</a></p>";
    }
    else{
        echo "<h1>invalid_user_name</h1>";
        echo "<p>Invalid username</p>";
    }
}

?>