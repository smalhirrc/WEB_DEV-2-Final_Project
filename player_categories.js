document.addEventListener("DOMContentLoaded", load);

function load()
{
    console.log("script_running");

    document.getElementById("submit").addEventListener("click", validate);
    document.getElementById("update").addEventListener("click", validate_update);
    // document.getElementById("reset").addEventListener("click", reset_all);
}

function validate(e){
    if ( !validate_add_category_input() ) {
        e.preventDefault();
    }
}

function validate_add_category_input()
{
    let valid_flag = true;

    let category_input = document.getElementById("player_role");

    if ( category_input.value.trim() === "" || 
         category_input.value.trim() === null
    ) {
        valid_flag = false;

        document.getElementById("add_category_input_error").style.display = "block";

        category_input.focus();
    }
    else {
        document.getElementById("add_category_input_error").style.display = "none"; 
    }

    return valid_flag;
}