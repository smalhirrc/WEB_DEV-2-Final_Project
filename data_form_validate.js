/**
 * Description: Validates user input for the add player form.
 * Author: Sukhpreet Singh Malhi
 * Version: 1.0
 * Last Updated: 2026-03-21
 */

document.addEventListener("DOMContentLoaded", load);

function validate(e) 
{
    let checks = [valid_player_name(),
    valid_player_age(),
    valid_player_height(),
    valid_player_weight(),
    valid_player_playing_position(),
    valid_player_jersey_number(),
    valid_player_role(),
    valid_player_profile_description()];

    let form_valid_flag = !checks.includes(false);

    if (!form_valid_flag) {
        e.preventDefault();
    }
}

function reset_all() 
{
    let error_messages = document.getElementsByClassName("error_field");

    for (let i = 0; i < error_messages.length; i++) {
        document.getElementsByClassName("error_field")[i].style.display = "none";
    }

    let current_image_preview_container = document.querySelector("p.current_image_preview");
    let current_image_preview = document.querySelector("p.current_image_preview img");
    let new_image_preview_container = document.querySelector("p.new_image_preview");
    let new_image_preview = document.querySelector("p.new_image_preview img");

    current_image_preview_container.style.display = "block";
    current_image_preview.style.display = "block";
    new_image_preview_container.style.display = "none";
    new_image_preview.style.display = "none";
}

function load() 
{
    let player_data_form = document.getElementById("player_data_form");
    player_data_form.addEventListener("submit", validate);

    let player_data_form_submit_button = document.getElementById("submit");
    player_data_form_submit_button.addEventListener("click", validate);

    let player_data_form_reset_button = document.getElementById("reset");
    player_data_form_reset_button.addEventListener("click", reset_all);

    let remove_image_link = document.querySelector("p#remove_image_link a");

    // function will run
    if (image_set === 1) {
        console.log("image set");
        remove_image_link.style.display = "inline-block";
    }
    else {
        console.log("image not set");
        remove_image_link.style.display = "none";
    }
}

// function will make previous image display none
// new image display block - src of new display is selected file

function show_preview(input) 
{
    let current_image_preview_container = document.querySelector("p.current_image_preview");
    let new_image_preview = document.querySelector("p.new_image_preview img");
    let new_image_preview_container = document.querySelector("p.new_image_preview");

    let file = input.files[0];

    const render = URL.createObjectURL(file);

    new_image_preview.src = render;
    current_image_preview_container.style.display = "none";
    new_image_preview_container.style.display = "block";
    new_image_preview.style.display = "block";
}

function hide_instruction(input) 
{
    let add_player_current_image = document.getElementById("upload_instruction");
    let new_image_preview_container = document.querySelector("p.new_image_preview");
    let new_image_preview = document.querySelector("p.new_image_preview img");

    let file = input.files[0];

    let render = URL.createObjectURL(file);

    new_image_preview.src = render;
    add_player_current_image.style.display = "none";
    new_image_preview_container.style.display = "block";
    new_image_preview.style.display = "block";
}























// PLAYER NAME 
function valid_player_name() {
    let valid_flag = true;
    let player_name = document.getElementById("player_name");
    // console.log(player_name.value);
    if (player_name.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_name_error").style.display = "inline-block";

        // This puts the cursor in the box
        player_name.focus();

        // This highlights any current text (if any) so they can overwrite it
        player_name.select();
    }
    else {
        document.getElementById("player_name_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER AGE
function valid_player_age() {
    let valid_flag = true;
    let player_age = document.getElementById("player_age");
    // console.log(player_age.value);
    if (player_age.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_age_error").style.display = "inline-block";

        player_age.focus();
    }
    else {
        document.getElementById("player_age_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER HEIGHT
function valid_player_height() {
    let valid_flag = true;
    let player_height = document.getElementById("player_height");
    // console.log(player_height.value);
    if (player_height.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_height_error").style.display = "inline-block";

        player_height.focus();
    }
    else {
        document.getElementById("player_height_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER WEIGHT
function valid_player_weight() {
    let valid_flag = true;
    let player_weight = document.getElementById("player_weight");
    // console.log(player_weight.value);
    if (player_weight.value === "") {
        valid_flag = false;

        document.getElementById("player_weight_error").style.display = "inline-block";

        player_weight.focus();
    }
    else {
        document.getElementById("player_weight_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER PLAYING POSITION
function valid_player_playing_position() {
    let valid_flag = true;
    let player_playing_position = document.getElementById("player_playing_position");
    // console.log(player_playing_position.value);
    if (player_playing_position.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_playing_position_error").style.display = "inline-block";

        player_playing_position.focus();
    }
    else {
        document.getElementById("player_playing_position_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER JERSEY NUMBER
function valid_player_jersey_number() {
    let valid_flag = true;
    let player_jersey_number = document.getElementById("player_jersey_number");
    // console.log(player_jersey_number.value);
    if (player_jersey_number.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_jersey_number_error").style.display = "inline-block";

        player_jersey_number.focus();
    }
    else {
        document.getElementById("player_jersey_number_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// PLAYER PROFILE DESCRIPTION
function valid_player_profile_description() {
    let valid_flag = true;
    let player_profile_description = document.getElementById("player_profile_description");
    // console.log(player_profile_description.value);
    if (player_profile_description.value.trim() === "") {
        valid_flag = false;

        document.getElementById("player_profile_description_error").style.display = "inline-block";

        player_profile_description.focus();
    }
    else {
        document.getElementById("player_profile_description_error").style.display = "none";
    }
    // console.log(valid_flag);
    return valid_flag;
}

// SELECT INPUT OF PLAYER'S ROLE
function valid_player_role() {
    let valid_flag = true;
    let player_role = document.getElementById("player_role");

    if (player_role.value === "") {
        valid_flag = true;

        document.getElementById("player_role_error").style.display = "inline-block";

        player_role.focus();
    }
    else {
        document.getElementById("player_role_error").style.display = "none";
    }

    return valid_flag;
}