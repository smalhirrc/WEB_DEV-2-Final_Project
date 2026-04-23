document.addEventListener("DOMContentLoaded", load);

let resultArray = [];
let offset = 0;
let limit = 5;
let page_size = 2;

function load()
{
    fetch('search_result_data.json')
    .then(function (response) { return response.json() })
    .then(function (data) {
        resultArray = data;
        // console.log(resultArray);

        showResults(resultArray);
    })
    .catch((errors) =>
        console.log(errors));
}

function showResults(result_array)
{
    // empty result container
    let search_match_link_container = document.querySelector("#search_match_link_container p");
    search_match_link_container.innerHTML = "";

    // slice result array
    let resultArray = result_array.slice(offset, offset + page_size);

    // loop search result to create page links
    for(let i=0; i < resultArray.length; i++){
        let player_page_link = document.createElement("a");
        let href = `player_page.php?player_id=${resultArray[i]['player_id']}&page_top_search_input=${search_input}`;
        player_page_link.setAttribute("href", href);

        player_page_link.innerText = resultArray[i]['player_name'];

        search_match_link_container.appendChild(player_page_link);
    }

    // NEXT button
    if (offset + page_size >= result_array.length) {
        document.getElementsByClassName("next")[0].style.display = "none";
    } else {
        document.getElementsByClassName("next")[0].style.display = "block";
    }

    // BACK button
    if (offset === 0) {
        document.getElementsByClassName("back")[0].style.display = "none";
    } else {
        document.getElementsByClassName("back")[0].style.display = "block";
    }

    // count display
    let result_count = result_array.length;

    document.getElementById("result_count").innerHTML = result_array.indexOf(resultArray[resultArray.length - 1]) + 1 + " of " + result_count + " results found";

    // searched page number and links
    let number_of_pages = Math.ceil(result_array.length / page_size);

    let page_link_list = document.getElementById("result_page_links_list");
    page_link_list.innerHTML = "";

    for(let j = 1; j <= number_of_pages; j++){
        let list_element = document.createElement("li");

        let page_link = document.createElement("a");
       
        page_link.classList.add("active_page");
        page_link.setAttribute("id", page_size);
        
        page_link.innerText = j;

        page_link.addEventListener("click", () => {
            let link_id = page_link.id;
            offset = (j - 1) * link_id;
            load();
        });

        list_element.appendChild(page_link);
        page_link_list.appendChild(list_element);
    }

// TOTAL PAGES
let totalPages = Math.ceil(result_array.length / page_size);

// CURRENT PAGE
let currentPage = Math.floor(offset / page_size) + 1;

// NEXT BUTTON
let nextBtn = document.getElementsByClassName("next")[0];

nextBtn.onclick = function (e) {
    e.preventDefault();

    if (currentPage < totalPages) {
        offset += page_size;
        showResults(result_array);
    }
};

// BACK BUTTON
let backBtn = document.getElementsByClassName("back")[0];

backBtn.onclick = function (e) {
    e.preventDefault();

    if (currentPage > 1) {
        offset -= page_size;
        showResults(result_array);
    }
};

document.getElementsByClassName("active_page")[currentPage - 1].style.backgroundColor = "#fff";
document.getElementsByClassName("active_page")[currentPage - 1].style.color = "#000";
}

