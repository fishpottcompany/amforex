$(document).ready(function () 
{
/*
|--------------------------------------------------------------------------
| ADDING CURRENCY FUNCTION
|--------------------------------------------------------------------------
| WHEN THE ADD CURRENCY FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
   $("#add_bureau_form").submit(function (e) 
   { 
       e.preventDefault(); 
       fade_in_loader_and_fade_out_form("loader", "add_bureau_form");       
       var form_data = $("#add_bureau_form").serialize();
       var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
       send_restapi_request_to_server_from_form("post", admin_api_bureaus_add_bureau_url, bearer, form_data, "json", add_currency_success_response_function, add_currency_error_response_function);
   });
   

/*
|--------------------------------------------------------------------------
| SEARCHING FOR RATES FUNCTION
|--------------------------------------------------------------------------
| WHEN THE SEARCH RATES FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
$("#search_form").submit(function (e) 
{ 
    e.preventDefault(); 
    search_for_bureaus(0);
});


});
   
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */

/*
|--------------------------------------------------------------------------
| ADDING BUREAU RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I respond to the addition of a bureau
|--------------------------------------------------------------------------
|
*/
function add_currency_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Bureau added successfully");
    fade_out_loader_and_fade_in_form("loader", "add_bureau_form"); 
    $('#add_bureau_form')[0].reset();
}

function add_currency_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "add_bureau_form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF BUREAUS FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_bureaus_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate">'
                + '<td>' + element.bureau_id + '</td>'
                + '<td>' + element.bureau_name + '</td>'
                + '<td>' + element.bureau_tin + '</td>'
                + '<td>' + element.bureau_license_no + '</td>'
                + '<td>' + element.bureau_hq_gps_address + '</td>'
                + '<td>' + element.bureau_phone_1 + '</td>'
                + '<td>' + element.bureau_email_1 + '</td>'
                + '<td>' + element.worker_surname + " " + element.worker_firstname + '</td>'
                + '<td>' + element.worker_phone_number + '</td>'
                + '<td>' + element.num_of_branches + '</td>'
                + '<td>' + element.admin_surname + " " + element.admin_firstname + '</td>'
                + '</tr>'
            );
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No bureaus found");
    }
}

function get_bureaus_for_page_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF BUREAUS FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_bureaus_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_bureaus_get_bureaus_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_bureaus_for_page_success_response_function, get_bureaus_for_page_error_response_function);
}





/*
|--------------------------------------------------------------------------
| SEARCHING FOR RATES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_bureaus_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
    if(response.data.data.length > 0){
        show_log_in_console("response.data.prev_page_url : " + response.data.prev_page_url);
        show_log_in_console("response.data.next_page_url : " + response.data.next_page_url);
        if(response.data.prev_page_url != null){
            $('#pagination_buttons').append(
                '<a id="previous_btn" class="btn btn-default" data-link = "' + response.data.prev_page_url + '&kw=' + response.kw + '" onclick="search_for_bureaus(1)"><i class="material-icons">keyboard_arrow_left</i></a>'
            );
        }
        if(response.data.next_page_url != null){
            $('#pagination_buttons').append(
                '<a id="next_btn" class="btn btn-default" data-link = "' + response.data.next_page_url + '&kw=' + response.kw + '" onclick="search_for_bureaus(2)"><i class="material-icons">keyboard_arrow_right</i></a>'
            );
        }
        
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate">'
                + '<td>' + element.bureau_id + '</td>'
                + '<td>' + element.bureau_name + '</td>'
                + '<td>' + element.bureau_tin + '</td>'
                + '<td>' + element.bureau_license_no + '</td>'
                + '<td>' + element.bureau_hq_gps_address + '</td>'
                + '<td>' + element.bureau_phone_1 + '</td>'
                + '<td>' + element.bureau_email_1 + '</td>'
                + '<td>' + element.worker_surname + " " + element.worker_firstname + '</td>'
                + '<td>' + element.worker_phone_number + '</td>'
                + '<td>' + element.num_of_branches + '</td>'
                + '<td>' + element.admin_surname + " " + element.admin_firstname + '</td>'
                + '</tr>'
            );
            
        }
    } else {
        show_notification("msg_holder", "danger", "", "No bureaus found");
    }
}


function search_for_bureaus_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
}


/*
|--------------------------------------------------------------------------
| SEARCHING FOR RATES FUNCTION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_bureaus(url_fetch_type)
{
    if(url_fetch_type == 1){
        var url = document.getElementById("previous_btn").getAttribute("data-link");
    } else if(url_fetch_type == 2){
        var url = document.getElementById("next_btn").getAttribute("data-link");
    } else {
        var url = admin_api_bureaus_search_for_bureaus_url + document.getElementById("search_form_input").value;
    }
    fade_in_loader_and_fade_out_form("loader", "search_form");     
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    document.getElementById("table_body_list").innerHTML = "";
    document.getElementById("pagination_buttons").innerHTML = "";
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", search_for_bureaus_success_response_function, search_for_bureaus_error_response_function);

}

