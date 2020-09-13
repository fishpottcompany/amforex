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
   $("#form").submit(function (e) 
   { 
       e.preventDefault(); 
       fade_in_loader_and_fade_out_form("loader", "form");
       var form_data = $("#form").serialize();
       var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
       show_log_in_console("form_data: " + form_data);
       
       send_restapi_request_to_server_from_form("post", worker_api_workers_add_worker_url, bearer, form_data, "json", add_worker_success_response_function, add_worker_error_response_function);
   });
   
   /*
    |--------------------------------------------------------------------------
    | WHEN A BUREAU LIST ITEM IS CLICKED, WE SEND THEM TO THE EDIT PAGE.
    |--------------------------------------------------------------------------
    | FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
    |--------------------------------------------------------------------------
    |
    */
    $(document).on('click', '.thisworker', function () {
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
| ADDING CURRENCY RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I add a currency
|--------------------------------------------------------------------------
|
*/
function add_worker_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", response.message);
    fade_out_loader_and_fade_in_form("loader", "form"); 
    $('#form')[0].reset();
}

function add_worker_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL BRANCHES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_all_branches_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "form"); 
    if(response.data.length > 0){
        for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            $('#branch_id').append(
                '<option value="' + element.branch_id + '">' + element.branch_name + '</option>'
            );
        }
        $('#submit_button_form').append(
            '<button type="submit" class="btn btn-primary pull-right">Add/Update</button>'
        );
    } else {
        show_notification("msg_holder", "danger", "", "No branches found. Add a branch to the bureau");
    }
}


function get_all_branches_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


function get_all_branches()
{
    fade_in_loader_and_fade_out_form("loader", "form");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    send_restapi_request_to_server_from_form("get", worker_api_branches_get_branches_list_url, bearer, "", "json", get_all_branches_success_response_function, get_all_branches_error_response_function);
}

/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF WORKERS FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_workers_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            if(element.worker_flagged == 0){
                worker_flagged = "No";
            } else {
                worker_flagged = "Yes";
            }
            url = host + "/bureau/workers/edit/" + element.worker_id;
            $('#table_body_list').append(
                '<tr style="cursor: pointer;"  class="thisworker" data-url="' + url + '">'
                + '<td>' + element.worker_id + '</td>'
                + '<td>' + element.worker_surname + ' ' + element.worker_firstname +  '</td>'
                + '<td>' + element.worker_phone_number + '</td>'
                + '<td>' + element.worker_email + '</td>'
                +' <td>' + element.branch_name + '</td>'
                + '<td>' + worker_flagged + '</td>'
                + '<td>' + element.creator_name + '</td>'
                + '</tr>'
            );
            
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No workers found");
    }
}

function get_workers_for_page_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF WORKERS FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_workers_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    url = worker_api_workers_get_workers_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_workers_for_page_success_response_function, get_workers_for_page_error_response_function);
}


/*
|--------------------------------------------------------------------------
| GETTING THE A SINGLE BUREAU TO BE EDITED AND IT'S RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_this_worker_success_response_function(response)
{
    if(response.data != null && response.data.worker_ext_id != ""){
            const element = response.data;
            document.getElementById("branch_name_label").innerHTML = "  |   Current Branch: " + element.branch_name;
            $("#worker_surname").val(element.worker_surname);
            $("#worker_firstname").val(element.worker_firstname);
            $("#worker_othernames").val(element.worker_othernames);
            $("#worker_home_gps_address").val(element.worker_home_gps_address);
            $("#worker_home_location").val(element.worker_home_location);
            $("#worker_position").val(element.worker_position);
            $("#worker_phone_number").val(element.worker_phone_number);
            $("#worker_email").val(element.worker_email);

            if(element.worker_flagged == 0){
                worker_flagged = "Un-flagged";
            } else {
                worker_flagged = "Flagged";
            }
            document.getElementById("worker_flagged_label").innerHTML = "  |   Current Status: " + worker_flagged;
            get_all_branches(); 
    } else {
        $('#loader').fadeOut();
        show_notification("msg_holder", "danger", "", "Worker not found");
    }
}

function get_this_worker_error_response_function(errorThrown)
{
    $('#loader').fadeOut();
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| FETCHING A SINGLE WORKER FUNCTION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/

function get_this_worker(worker_id)
{
    fade_in_loader_and_fade_out_form("loader", "form");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    url = worker_api_workers_get_one_worker_url + worker_id;
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_this_worker_success_response_function, get_this_worker_error_response_function);
}