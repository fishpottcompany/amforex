$(document).ready(function () 
{

    

    // RESENDING THE PASSCODE
    function success_response_function(response)
    {
        localStorage.setItem("worker_firstname", response.worker_firstname);
        localStorage.setItem("worker_surname", response.worker_surname);
        localStorage.setItem("worker_access_token", response.worker_token);
        show_notification("msg_holder", "success", "Success:", "Login successful");
        redirect_to_next_page(worker_web_passcode_page_url, false);
    }

    function error_response_function(errorThrown)
    {
        fade_out_loader_and_fade_in_form("loader", "lform"); 
        show_notification("msg_holder", "danger", "Error", errorThrown);
    }

    // SUBMITTING THE LOGIN FORM TO GET API TOKEN
    $("#lform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "lform");       
        send_request_to_server_from_form("post", worker_api_login_url, $("#lform").serialize(), "json", success_response_function, error_response_function);
    });

    


});