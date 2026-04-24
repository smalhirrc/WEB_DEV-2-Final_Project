<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "mutual_content.php";
// require "connect.php";

// SANITIZE AND VALIDATE EMAIL
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : false;
$confirmed_password = isset($_POST['confirmed_password']) ? $_POST['confirmed_password'] : false;

function sanitize_email($input)
{
    return filter_var($input, FILTER_SANITIZE_EMAIL);
}
$sanitized_email = sanitize_email($email);

function validate_email($input)
{
    if(!empty(trim($input))){
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
    else{
        return false;
    }
}
$validated_email_address = validate_email($sanitized_email);

function validate_password($pass, $con_pass)
{
    if(!empty($pass) && !empty($con_pass)){
        return $pass === $con_pass;
    }

    return false;
}

$user_name = "";
if($validated_email_address){
    $user_name = substr($validated_email_address, 0, strpos($validated_email_address, "@"));
}

// PREPARE QUERY
$sign_in_query = "INSERT INTO Admins(user_name, passwords, email_id)
    VALUES (:user_name, :passwords, :email_id)";

$statement_sign_in_query = $db->prepare($sign_in_query);

if($_SERVER["REQUEST_METHOD"] === "POST" && validate_password($password, $confirmed_password) && $validated_email_address !== false){
    try{
        $statement_sign_in_query->bindValue(":user_name", $user_name);
        $statement_sign_in_query->bindValue(":passwords", password_hash($password, PASSWORD_DEFAULT));
        $statement_sign_in_query->bindValue(":email_id", $validated_email_address);

        if($statement_sign_in_query->execute()){
            header("Location: sign_in_success.php?message=signin_success&username=$user_name");
            exit();
        }
    }
    catch(PDOException $e){
        echo "Error: " . $e;
    }

}
else{

    $email_error_message = empty($validated_email_address) ? "* Invalid email" : "";

    $password_error_message = empty($password) ? "* Please enter password" : "";

    $confirmed_password_error_message = empty($confirmed_password) ? "* Please enter confirm password" : "";

    $pass_do_not_match = $password !== $confirmed_password ? "* Password do not match" : "";

    $error_messages = [$email_error_message, $password_error_message, $confirmed_password_error_message, $pass_do_not_match];

    $errors = [];

    foreach($error_messages as $check){
        if($check !== ""){
            $errors[] = $check;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>
    <main>
    <?php if (count($errors) !== 0 && $_POST): ?>
    <div id="error_container">
        <h2>Sign In Unsuccessfull</h2>
        <div id="errors">
            <?php foreach($errors as $error): ?>
                <p class="error_fields"><?=$error?></p>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>
        <div class="sign_in_form_container">
            <form class="sign_in_form" action="" method="post">
                <h2>Sign In</h2>
                <label>Email address:</label>
                <input type="email" id="email" name="email" value="<?=$email?>">
                <span class="error_field" id="email_error">* Please enter valid email</span>

                <label>Password:</label>
                <input type="password" id="password" name="password">
                <span class="error_field" id="password_error">* Please enter password</span>

                <label>Confirm Password:</label>
                <input type="password" id="confirmed_password" name="confirmed_password">
                <span class="error_field" id="confirmed_password_error">* Please enter confirm password</span>
                <span class="error_field" id="pass_match_error">* Password do not match</span>
                <button id="submit" type="submit">Sign In</button>
            </form>
        </div>
    </main>
    <script src="sign_in_script.js"></script>
</body>
</html>