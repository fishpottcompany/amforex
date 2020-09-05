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
