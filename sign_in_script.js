document.addEventListener("DOMContentLoaded", load);

function load()
{
    document.getElementById("submit").addEventListener("click", validate);
    console.log("script_running");
}

function validate(e)
{
    let checks = [validateEmail(), validatePassword(), validateConfirmedPassword(), passwordMatch()];

    if(checks.includes(false)){
        e.preventDefault();
    }
console.log(checks);

}

function passwordMatch()
{
    errorFlag = true;

    let password = document.getElementById("password");
    let confirmedPassword = document.getElementById("confirmed_password");

    if(password.value.trim() !== confirmedPassword.value.trim()){
        errorFlag = false;
        document.getElementById("pass_match_error").style.display = "inline-block";

        password.select();
    }
    else{
        document.getElementById("pass_match_error").style.display = "none";
    }

    return errorFlag;
}

function validateEmail()
{
    let errorFlag = true;

    let email = document.getElementById("email");

    if(email.value.trim() === "" || email.value.trim() === null){
        errorFlag = false;

        document.getElementById("email_error").style.display = "inline-block";

        email.select();
    }
    else{
        document.getElementById("email_error").style.display = "none";
    }

    return errorFlag;
}

function validatePassword()
{
    let errorFlag = true;

    let password = document.getElementById("password");

    if(password.value.trim() === "" || password.value.trim() === null){
        errorFlag = false;

        document.getElementById("password_error").style.display = "inline-block";

        password.select();
    }
    else{
        document.getElementById("password_error").style.display = "none";
    }

    return errorFlag;
}

function validateConfirmedPassword()
{
    let errorFlag = true;

    let confirmedPassword = document.getElementById("confirmed_password");

    if(confirmedPassword.value.trim() === "" || confirmedPassword.value.trim() === null){
        errorFlag = false;
        document.getElementById("confirmed_password_error").style.display = "inline-block";
        confirmedPassword.select();
    }
    else{
        document.getElementById("confirmed_password_error").style.display = "none";
    }

    return errorFlag;
}
