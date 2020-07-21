
/*
|--------------------------------------------------------------------------
| WHEN THE DOCUMENT IS FULLY LOADED, WE PERFORM ALL ACTIONS
|--------------------------------------------------------------------------
| WHEN THE ADD CURRENCY FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/ 
$(document).ready(function () 
{
/*
|--------------------------------------------------------------------------
| ADDING CURRENCY FUNCTIONS
|--------------------------------------------------------------------------
| WHEN THE ADD CURRENCY FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
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
| FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
|--------------------------------------------------------------------------
|
*/

    
    $(document).on('click', '.currency', function () {
        show_log_in_console("url: " + (this).getAttribute("data-url"));
        redirect_to_next_page((this).getAttribute("data-url"), true);
    });
    
});

/*
|--------------------------------------------------------------------------
| ADDING CURRENCY RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I add a currency
|--------------------------------------------------------------------------
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


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL CURRENCIES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_all_currencies_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.length > 0){
        for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            url = host + "/admin/currencies/edit/" + element.currency_id;
            if(element.currency_flagged == 0){tradable = "Yes";} else { tradable = "No"; }
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="currency" data-url="' + url + '"><td>' + element.currency_id + '</td><td>' 
                + element.currency_full_name + '</td><td>' + element.currency_abbreviation + '</td><td>' + element.currency_symbol 
                + '</td><td>' + element.updated_at + '</td><td>' + tradable + '</td><td>' + element.admin_surname + " " + element.admin_firstname + '</td></tr>'
            );
            
        }
    } else {
        show_notification("msg_holder", "danger", "", "No currencies found");
    }
}

function get_all_currencies_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "acform"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

function get_all_currencies()
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    send_restapi_request_to_server_from_form("get", admin_api_currencies_get_currency_list_url, bearer, "", "json", get_all_currencies_success_response_function, get_all_currencies_error_response_function);
}

