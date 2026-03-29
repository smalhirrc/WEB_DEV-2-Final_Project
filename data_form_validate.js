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
                  valid_player_profile_description()];
    // ,
    //               valid_team_name(),
    //               valid_team_coach_name(),
    //               valid_team_home_ground(),
    //               valid_team_founded_in_year(),
    //               valid_team_category() ,
    //               valid_number_of_matches_played(),
    //               valid_total_goals(),
    //               valid_total_assists(),
    //               valid_yellow_cards(),
    //               valid_red_cards()

    let form_valid_flag = !checks.includes(false);

    if(!form_valid_flag){
        e.preventDefault();
    }

    console.log("form_valid_flag: " + form_valid_flag);
}

function reset_all()
{
    let error_messages = document.getElementsByClassName("error_field");

    for(let i = 0; i < error_messages.length; i++){
        document.getElementsByClassName("error_field")[i].style.display = "none";
    }
}

function load()
{
    let player_data_form = document.getElementById("player_data_form");
    player_data_form.addEventListener("submit", validate);

    let player_data_form_submit_button = document.getElementById("submit");
    player_data_form_submit_button.addEventListener("click", validate);

    let player_data_form_reset_button = document.getElementById("reset");
    player_data_form_reset_button.addEventListener("click", reset_all);
}



























// PLAYER NAME 
function valid_player_name()
{
    let valid_flag = true;
    let player_name = document.getElementById("player_name");
// console.log(player_name.value);
    if(player_name.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_name_error").style.display = "inline-block";

        // This puts the cursor in the box
        player_name.focus();

        // This highlights any current text (if any) so they can overwrite it
        player_name.select();
    }
    else{
        document.getElementById("player_name_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER AGE
function valid_player_age()
{
    let valid_flag = true;
    let player_age = document.getElementById("player_age");
// console.log(player_age.value);
    if(player_age.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_age_error").style.display = "inline-block";

        player_age.focus();
    }
    else{
        document.getElementById("player_age_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER HEIGHT
function valid_player_height()
{
    let valid_flag = true;
    let player_height = document.getElementById("player_height");
// console.log(player_height.value);
    if(player_height.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_height_error").style.display = "inline-block";

        player_height.focus();
    }
    else{
        document.getElementById("player_height_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER WEIGHT
function valid_player_weight()
{
    let valid_flag = true;
    let player_weight = document.getElementById("player_weight");
// console.log(player_weight.value);
    if(player_weight.value === ""){
        valid_flag = false;

        document.getElementById("player_weight_error").style.display = "inline-block";

        player_weight.focus();
    }
    else{
        document.getElementById("player_weight_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER PLAYING POSITION
function valid_player_playing_position()
{
    let valid_flag = true;
    let player_playing_position = document.getElementById("player_playing_position");
// console.log(player_playing_position.value);
    if(player_playing_position.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_playing_position_error").style.display = "inline-block";

        player_playing_position.focus();
    }
    else{
        document.getElementById("player_playing_position_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER JERSEY NUMBER
function valid_player_jersey_number()
{
    let valid_flag = true;
    let player_jersey_number = document.getElementById("player_jersey_number");
// console.log(player_jersey_number.value);
    if(player_jersey_number.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_jersey_number_error").style.display = "inline-block";

        player_jersey_number.focus();
    }
    else{
        document.getElementById("player_jersey_number_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// PLAYER PROFILE DESCRIPTION
function valid_player_profile_description()
{
    let valid_flag = true;
    let player_profile_description = document.getElementById("player_profile_description");
// console.log(player_profile_description.value);
    if(player_profile_description.value.trim() === ""){
        valid_flag = false;

        document.getElementById("player_profile_description_error").style.display = "inline-block";

        player_profile_description.focus();
    }
    else{
        document.getElementById("player_profile_description_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TEAM NAME
function valid_team_name()
{
    let valid_flag = true;
    let team_name = document.getElementById("team_name");
// console.log(team_name.value);
    if(team_name.value.trim() === ""){
        valid_flag = false;

        document.getElementById("team_name_error").style.display = "inline-block";

        team_name.focus();
    }
    else{
        document.getElementById("team_name_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TEAM COACH NAME
function valid_team_coach_name()
{
    let valid_flag = true;
    let team_coach_name = document.getElementById("team_coach_name");
// console.log(team_coach_name.value);
    if(team_coach_name.value.trim() === ""){
        valid_flag = false;

        document.getElementById("team_coach_name_error").style.display = "inline-block";

        team_coach_name.focus();
    }
    else{
        document.getElementById("team_coach_name_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TEAM HOME GROUND
function valid_team_home_ground()
{
    let valid_flag = true;
    let team_home_ground = document.getElementById("team_home_ground");
// console.log(team_home_ground.value);
    if(team_home_ground.value.trim() === ""){
        valid_flag = false;

        document.getElementById("team_home_ground_error").style.display = "inline-block";

        team_home_ground.focus();
    }
    else{
        document.getElementById("team_home_ground_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TEAM FOUNDED IN YEAR
function valid_team_founded_in_year()
{
    let valid_flag = true;
    let team_founded_in_year = document.getElementById("team_founded_in_year");
// console.log(team_founded_in_year.value);
    if(team_founded_in_year.value.trim() === ""){
        valid_flag = false;

        document.getElementById("team_founded_in_year_error").style.display = "inline-block";

        team_founded_in_year.focus();
    }
    else{
        document.getElementById("team_founded_in_year_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TEAM CATEGORY
function valid_team_category()
{
    let valid_flag = true;
    let team_category = document.querySelector('input[name="team_category"]:checked');

    if(!team_category){
        valid_flag = false;

        document.getElementById("team_category_error").style.display = "inline-block";
    }
    else{
        document.getElementById("team_category_error").style.display = "none";
    }

    return valid_flag;
}

// NUMBER OF MATCHES PLAYED BY PLAYER
function valid_number_of_matches_played()
{
    let valid_flag = true;
    let number_of_matches_played = document.getElementById("number_of_matches_played");
// console.log(number_of_matches_played.value);
    if(number_of_matches_played.value.trim() === ""){
        valid_flag = false;

        document.getElementById("number_of_matches_played_error").style.display = "inline-block";

        number_of_matches_played.focus();
    }
    else{
        document.getElementById("number_of_matches_played_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TOTAL GOALS BY PLAYER
function valid_total_goals(){
    let valid_flag = true;
    let total_goals = document.getElementById("total_goals");
// console.log(total_goals.value);
    if(total_goals.value.trim() === ""){
        valid_flag = false;

        document.getElementById("total_goals_error").style.display = "inline-block";

        total_goals.focus();
    }
    else{
        document.getElementById("total_goals_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TOTAL ASSISTS BY PLAYER
function valid_total_assists(){
    let valid_flag = true;
    let total_assists = document.getElementById("total_assists");
// console.log(total_assists.value);
    if(total_assists.value.trim() === ""){
        valid_flag = false;

        document.getElementById("total_assists_error").style.display = "inline-block";

        total_assists.focus();
    }
    else{
        document.getElementById("total_assists_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TOTAL YELLOW CARD TO PLAYER
function valid_yellow_cards(){
    let valid_flag = true;
    let yellow_cards = document.getElementById("yellow_cards");
// console.log(yellow_cards.value);
    if(yellow_cards.value.trim() === ""){
        valid_flag = false;

        document.getElementById("yellow_cards_error").style.display = "inline-block";

        yellow_cards.focus();
    }
    else{
        document.getElementById("yellow_cards_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}

// TOTAL RED CARDS TO PLAYER
function valid_red_cards(){
    let valid_flag = true;
    let red_cards = document.getElementById("red_cards");
// console.log(red_cards.value);
    if(red_cards.value.trim() === ""){
        valid_flag = false;

        document.getElementById("red_cards_error").style.display = "inline-block";

        red_cards.focus();
    }
    else{
        document.getElementById("red_cards_error").style.display = "none";
    }
// console.log(valid_flag);
    return valid_flag;
}