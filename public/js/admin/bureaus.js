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
| EDITING CURRENCY FUNCTION
|--------------------------------------------------------------------------
| WHEN THE EDIT CURRENCY FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
$("#edit_bureau_form").submit(function (e) 
{ 
    e.preventDefault(); 
    fade_in_loader_and_fade_out_form("loader", "edit_bureau_form");       
    var form_data = $("#edit_bureau_form").serialize();
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    send_restapi_request_to_server_from_form("post", admin_api_bureaus_edit_bureau_url, bearer, form_data, "json", edit_bureau_success_response_function, edit_bureau_error_response_function);
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



/*
|--------------------------------------------------------------------------
| WHEN A BUREAU LIST ITEM IS CLICKED, WE SEND THEM TO THE EDIT PAGE.
|--------------------------------------------------------------------------
| FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
|--------------------------------------------------------------------------
|
*/
$(document).on('click', '.bureau', function () {
    show_log_in_console("url: " + (this).getAttribute("data-url"));
    redirect_to_next_page((this).getAttribute("data-url"), true);
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
| EDITING/UPDATING BUREAU RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I edit a bureau
|--------------------------------------------------------------------------
|
*/

function edit_bureau_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Bureau updated successfully");
    fade_out_loader_and_fade_in_form("loader", "edit_bureau_form"); 
    //$('#edit_bureau_form')[0].reset();
}

function edit_bureau_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "edit_bureau_form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


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
            url = host + "/admin/bureaus/edit/" + element.bureau_id;
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="bureau" data-url="' + url + '">'
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
            url = host + "/admin/bureaus/edit/" + element.bureau_id;
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="bureau" data-url="' + url + '">'
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

/*
|--------------------------------------------------------------------------
| GETTING THE A SINGLE BUREAU TO BE EDITED AND IT'S RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_this_bureau_success_response_function(response)
{
    if(response.data.length > 0){
            const element = response.data[0];
            if(element.bureau_flagged == 0){
                $("#tradable_input_label").html("Tradable Status: Currently Set As TRADABLE");
            } else { 
                $("#tradable_input_label").html("Tradable Status: Currently Set As NOT-TRADABLE");
             }

            $("#bureau_id").val(element.bureau_id);
            $("#bureau_name").val(element.bureau_name);
            $("#bureau_hq_gps_address").val(element.bureau_hq_gps_address);
            $("#bureau_hq_location").val(element.bureau_hq_location);
            $("#bureau_tin").val(element.bureau_tin);
            $("#bureau_license_no").val(element.bureau_license_no);
            $("#bureau_registration_num").val(element.bureau_registration_num);
            $("#bureau_phone_1").val(element.bureau_phone_1);
            $("#bureau_phone_2").val(element.bureau_phone_2);
            $("#bureau_email_1").val(element.bureau_email_1);
            $("#bureau_email_2").val(element.bureau_email_2);
            $("#worker_surname").val(element.worker_surname);
            $("#worker_firstname").val(element.worker_firstname);
            $("#worker_othernames").val(element.worker_othernames);
            $("#worker_gps_address").val(element.worker_home_gps_address);
            $("#worker_location").val(element.worker_home_location);
            $("#worker_position").val(element.worker_position);
            $("#worker_phone_number").val(element.worker_phone_number);
            $("#worker_email").val(element.worker_email);
            $('#submit_button_holder').html(
               '<button type="submit" class="btn btn-primary pull-right">Edit</button>'
            );
            fade_out_loader_and_fade_in_form("loader", "edit_bureau_form"); 
    } else {
        $('#loader').fadeOut();
        show_notification("msg_holder", "danger", "", "Bureau not found");
    }
}

function get_this_bureau_error_response_function(errorThrown)
{
    $('#loader').fadeOut();
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| FETCHING A SINGLE BUEAU FUNCTION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/

function get_this_bureau(bureau_id)
{
    fade_in_loader_and_fade_out_form("loader", "edit_bureau_form");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_bureaus_get_one_bureau_url + bureau_id;
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_this_bureau_success_response_function, get_this_bureau_error_response_function);
}


