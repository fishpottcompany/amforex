$(document).ready(function () 
{

    // RESENDING THE PASSCODE
    function resend_passcode()
    {
        
    }
    

    // RESENDING THE PASSCODE
    function success_response_function(response)
    {
        if(response == "Unauthorized"){
            user_token_is_no_longer_valid();
            return;
        } 
        localStorage.setItem("worker_passcode_completed", "1");
        localStorage.setItem("worker_passcode", "149");
        show_notification("msg_holder", "success", "Success:", "Verification successful");
        redirect_to_next_page(worker_web_dashboard_page_url, false);
    }

    // RESENDING THE PASSCODE
    function resend_passcode_success_response(response)
    {
        show_notification("msg_holder", "success", "Success:", "Passcode resent successfully");
        fade_out_loader_and_fade_in_form("loader", "otpform"); 
            
    }

        
    function error_response_function(errorThrown)
    {
        show_notification("msg_holder", "danger", "Error", errorThrown);
        fade_out_loader_and_fade_in_form("loader", "otpform"); 
    }

    // SUBMITTING THE LOGIN FORM TO GET API TOKEN
    $("#otpform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "otpform");       
        var form_data = $("#otpform").serialize();
        var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
        send_restapi_request_to_server_from_form("get", worker_api_send_passcode_url, bearer, form_data, "json", success_response_function, error_response_function);
    });

    $("#resendurl").click(function (e) { 
        e.preventDefault();
        fade_in_loader_and_fade_out_form("loader", "otpform");       
        var bearer = "Bearer " + localStorage.getItem("worker_access_token");
        show_log_in_console("worker_surname: " + localStorage.getItem("worker_surname"));
        send_restapi_request_to_server_from_form("get", worker_api_resend_passcode_url, bearer, "", "json", resend_passcode_success_response, error_response_function);

    });
    


});