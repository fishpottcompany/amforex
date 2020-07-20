$(document).ready(function () 
{

/*
|--------------------------------------------------------------------------
| ADDING CURRENCY FUNCTIONS
|--------------------------------------------------------------------------
|
| Here is where I add a currency
|
*/
    function add_currency_success_response_function(response)
    {
        show_notification("msg_holder", "success", "Success:", "Currency added successfully");
        fade_out_loader_and_fade_in_form("loader", "acform"); 
        $('#acform')[0].reset();
    }

    function add_currency_error_response_function(errorThrown)
    {
        fade_out_loader_and_fade_in_form("loader", "acform"); 
        show_notification("msg_holder", "danger", "Error", errorThrown);
    }

    $("#acform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "acform");       
        var form_data = $("#acform").serialize();
        var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
        send_restapi_request_to_server_from_form("post", admin_api_currencies_add_currency_url, bearer, form_data, "json", add_currency_success_response_function, add_currency_error_response_function);
    });

    /*
|--------------------------------------------------------------------------
| WHEN A CURRENCY LIST ITEM IS CLICKED, WE SEND THEM TO THE EDIT PAGE.
|--------------------------------------------------------------------------
|
| FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
|
*/

    $(".currency").click(function (e) 
    { 
        e.preventDefault(); 
        url = admin_web_currencies_edit_page_url + "?id=" + (this).getAttribute("data-cid");
        redirect_to_next_page(url, true);
    });

});