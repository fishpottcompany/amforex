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
       
       send_restapi_request_to_server_from_form("post", worker_api_branches_add_branch_url, bearer, form_data, "json", add_branch_success_response_function, add_branch_error_response_function);
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
function add_branch_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Branch added successfully");
    fade_out_loader_and_fade_in_form("loader", "form"); 
    $('#form')[0].reset();
}

function add_branch_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL CURRENCIES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_all_branches_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    if(response.data.length > 0){
        for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            $('#branch_id').append(
                '<option value="' + element.branch_id + '">' + element.branch_name + '</option>'
            );
        }
        $('#submit_button_add_rate_form').append(
            '<button type="submit" class="btn btn-primary pull-right">Add</button>'
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
    fade_in_loader_and_fade_out_form("loader", "arform");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    send_restapi_request_to_server_from_form("get", worker_api_branches_get_branches_list_url, bearer, "", "json", get_all_branches_success_response_function, get_all_branches_error_response_function);
}
