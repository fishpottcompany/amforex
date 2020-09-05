$(document).ready(function () 
{
/*
|--------------------------------------------------------------------------
| CHANGING PASSWORD FUNCTION
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
       send_restapi_request_to_server_from_form("post", worker_api_security_change_password_url, bearer, form_data, "json", change_password_success_response_function, change_password_error_response_function);
   });
   
    
});

/*
|--------------------------------------------------------------------------
| CHANGING PASSWORDRESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function change_password_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Password changed successfully. You will have to sign-in again");
    fade_out_loader_and_fade_in_form("loader", "form"); 
    $('#form')[0].reset();
}

function change_password_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

