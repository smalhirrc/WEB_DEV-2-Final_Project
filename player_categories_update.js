document.addEventListener("DOMContentLoaded", load);

function load()
{
    document.getElementById("submit").addEventListener("click", validate);
}

function validate(e)
{
    if(!validate_updated_category()){
        e.preventDefault();
    }
}

function validate_updated_category()
{
    let valid_flag = true;
    let updated_category = document.getElementById("updated_category");

    if(updated_category.value.trim() === "" || updated_category.value.trim() === null){
        valid_flag = false;

        document.getElementById("updated_category_input_error").style.display = "block";

        updated_category.focus();
    }
    else{
        document.getElementById("updated_category_input_error").style.display = "none";
    }

    return valid_flag;
}