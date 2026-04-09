document.addEventListener("DOMContentLoaded", load);

function load(){
    let submit = document.getElementById("submit");

    submit.addEventListener("click", validate);
}

function validate(e){
    let checks = [validate_user_name(), 
                  validate_user_password(), 
                  validate_user_role()];


    let form_valid_flag = !checks.includes(false);

    if(!form_valid_flag){
        e.preventDefault();
    }
}

function validate_user_name(){
    let valid_flag = true;
    let user_name = document.getElementById("user_name");

    if(user_name.value.trim() === ""){
        valid_flag = false;

        document.getElementById("user_name_error").style.display = "inline-block";

        user_name.focus();
        user_name.select();
    }
    else{
        document.getElementById("user_password_error").style.display = "none";
    }

    return valid_flag;
}

function validate_user_password(){
    let valid_flag = true;
    let user_password = document.getElementById("user_password");

    if(user_password.value.trim() === ""){
        valid_flag = false;

        document.getElementById("user_password_error").style.display = "inline-block";

        user_password.focus();
        user_password.select();
    }
    else{
        document.getElementById("user_password_error").style.display = "none";
    }

    return valid_flag;
}

function validate_user_role(){
    let valid_flag = true;
    let user_role = document.getElementById("user_role");

    if(user_role.value.trim() === ""){
        valid_flag = false;

        document.getElementById("user_role_error").style.display = "inline-block";

        user_role.focus();
        user_role.select();
    }
    else{
        document.getElementById("user_role_error").style.display = "none";
    }

    return valid_flag;
}