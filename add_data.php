<?php
session_start();

require("mutual_content.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player's Data</title>
    <script src="data_form_validate.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="data_form_container">
        <h1>Add Player</h1>
        <form id="player_data_form" method="post" action="data_submission.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Player's Information</legend>
                <ul>
                    <li>
                        <label for="player_name">Player Name: </label>
                        <input type="text" id="player_name" name="player_name"/>
                        <span id="player_name_error" class="error_field">* Player name is required.</span>
                    </li>
                    <li>
                        <label for="player_age">Player Age: </label>
                        <input type="number" id="player_age" name="player_age"/>
                        <span id="player_age_error" class="error_field">* Valid player age is required.</span>
                    </li>
                    <li>
                        <label for="player_height">Player Height (cm): </label>
                        <input type="number" id="player_height" name="player_height" step="any" min="100" max="250"/>
                        <span id="player_height_error" class="error_field">* Player height is required.</span>
                    </li>
                    <li>
                        <label for="player_weight">Player Weight (kg): </label>
                        <input type="number" id="player_weight" name="player_weight" step="any" min="40" max="170"/>
                        <span id="player_weight_error" class="error_field">* Player weight is required.</span>
                    </li>
                    <li>
                        <label for="player_playing_position">Player Playing Position: </label>
                        <input type="text" id="player_playing_position" name="player_playing_position"/>
                        <span id="player_playing_position_error" class="error_field">* Player's playing position is required.</span>
                    </li>
                    <li>
                        <label for="player_jersey_number">Player Jersey Number: </label>
                        <input type="number" id="player_jersey_number" name="player_jersey_number"/>
                        <span id="player_jersey_number_error" class="error_field">* Player's jersey number is required.</span>
                    </li>
                    <li>
                        <label for="player_profile_description">Player Description: </label>
                        <input id="player_profile_description" name="player_profile_description"/>
                        <span id="player_profile_description_error" class="error_field">* Player's profile description is required.</span>
                    </li>
                    <li>
                        <label for="player_image">Upload Player Image (optional): </label>
                        <input type="file" name="player_image" id="player_image">
                    </li>
                </ul>
            </fieldset>
            <!-- <fieldset>
                <legend>Player's Team Information</legend>
                <ul>
                    <li>
                        <label for="team_name">Team Name: </label>
                        <input type="text" id="team_name" name="team_name"/>
                        <span id="team_name_error" class="error_field">* Team's Name is required.</span>
                    </li>
                    <li>
                        <label for="team_coach_name">Team Coach Name: </label>
                        <input type="text" id="team_coach_name" name="team_coach_name"/>
                        <span id="team_coach_name_error" class="error_field">* Team's coach name is required.</span>
                    </li>
                    <li>
                        <label for="team_home_ground">Team Home Ground: </label>
                        <input type="text" id="team_home_ground" name="team_home_ground"/>
                        <span id="team_home_ground_error" class="error_field">* Team's home ground is required.</span>
                    </li>
                    <li>
                        <label for="team_founded_in_year">Team Founded in (year): </label>
                        <input type="number" id="team_founded_in_year" name="team_founded_in_year" min="1900" max="2099"/>
                        <span id="team_founded_in_year_error" class="error_field">* Team founded in which year is required.</span>
                    </li>
                    <li>
                        <label>Team Category: </label>
                        <input type="radio" id="team_category_under_17" class="team_category" name="team_category" value="Under_17"/>
                        <label for="team_category_under_17">Under 17</label>
                        <input type="radio" id="team_category_under_19" class="team_category" name="team_category" value="Under_19"/>
                        <label for="team_category_under_19">Under 19</label>
                        <input type="radio" id="team_category_senior" class="team_category" name="team_category" value="Under_21"/>
                        <label for="team_category_senior">Senior</label>
                        <span id="team_category_error" class="error_field">* Team's category is required.</span>
                    </li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Player's Satistics</legend>
                <ul>
                    <li>
                        <label for="number_of_matches_played">Matches Played: </label>
                        <input type="number" id="number_of_matches_played" name="number_of_matches_played"/>
                        <span id="number_of_matches_played_error" class="error_field">* Number of matches played is required.</span>
                    </li>
                    <li>
                        <label for="total_goals">Total Goals Scored: </label>
                        <input type="number" id="total_goals" name="total_goals"/>
                        <span id="total_goals_error" class="error_field">* Number of total goals is required.</span>
                    </li>
                    <li>
                        <label for="total_assists">Total Assists: </label>
                        <input type="number" id="total_assists" name="total_assists"/>
                        <span id="total_assists_error" class="error_field">* Number of total assists is required.</span>
                    </li>
                    <li>
                        <label for="yellow_cards">Yellow Cards: </label>
                        <input type="number" id="yellow_cards" name="yellow_cards"/>
                        <span id="yellow_cards_error" class="error_field">* Number of yellow cards is required.</span>
                    </li>
                    <li>
                        <label for="red_cards">Red Cards: </label>
                        <input type="number" id="red_cards" name="red_cards"/>
                        <span id="red_cards_error" class="error_field">* Number of red cards is required.</span>
                    </li>
                </ul>
            </fieldset> -->
            <button type="submit" id="submit" name="submit">Submit</button>
            <button type="reset" id="reset" name="reset">Reset</button>
        </form>
    </div>
</body>
</html>