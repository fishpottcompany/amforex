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
       send_restapi_request_to_server_from_form("post", admin_api_rates_add_rate_url, bearer, form_data, "json", add_currency_success_response_function, add_currency_error_response_function);
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
| LISTING BUREAUS FUNCTIONS
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
*/
