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
   $("#acform").submit(function (e) 
   { 
       e.preventDefault(); 
       fade_in_loader_and_fade_out_form("loader", "acform");
       var form_data = $("#acform").serialize();
       var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
       show_log_in_console("bearer: " + bearer);
       show_log_in_console("form_data: " + form_data);
       show_log_in_console("worker_api_customers_add_customer_url: " + worker_api_customers_add_customer_url);
       send_restapi_request_to_server_from_form("post", worker_api_customers_add_customer_url, bearer, form_data, "json", add_customer_success_response_function, add_customer_error_response_function);
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
function add_customer_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Customer added successfully");
    fade_out_loader_and_fade_in_form("loader", "acform"); 
    $('#acform')[0].reset();
}

function add_customer_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "acform"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

/*
|--------------------------------------------------------------------------
| EDITING/UPDATING CURRENCY RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I add a currency
|--------------------------------------------------------------------------
|
*/
function edit_currency_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Currency updated successfully");
    fade_out_loader_and_fade_in_form("loader", "ecform"); 
    //$('#acform')[0].reset();
}

function edit_currency_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "ecform"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL CURRENCIES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_currencies_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
    if(response.data.length > 0){
        document.getElementById("table_body_list").innerHTML = "";
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

function search_for_currencies_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
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
        document.getElementById("table_body_list").innerHTML = "";
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
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

function get_all_currencies()
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    send_restapi_request_to_server_from_form("get", admin_api_currencies_get_currency_list_url, bearer, "", "json", get_all_currencies_success_response_function, get_all_currencies_error_response_function);
}

/*
|--------------------------------------------------------------------------
| GETTING THE CURRENCY BEING EDITED AND IT'S RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_this_currency_success_response_function(response)
{
    if(response.data.length > 0){
            const element = response.data[0];
            if(element.currency_flagged == 0){
                $("#tradable_input_label").html("Tradable Status: Currently Set As TRADABLE");
            } else { 
                $("#tradable_input_label").html("Tradable Status: Currently Set As NOT-TRADABLE");
             }

            $("#currency_id").val(element.currency_id);
            $("#currency_full_name").val(element.currency_full_name);
            $("#currency_abbreviation").val(element.currency_abbreviation);
            $("#currency_symbol").val(element.currency_symbol);
            $("#currency_id").val(element.currency_id);
            $('#submit_button_holder').html(
               '<button type="submit" class="btn btn-primary pull-right">Edit</button>'
            );
            fade_out_loader_and_fade_in_form("loader", "ecform"); 
    } else {
        $('#loader').fadeOut();
        show_notification("msg_holder", "danger", "", "Currency not found");
    }
}

function get_this_currency_error_response_function(errorThrown)
{
    $('#loader').fadeOut();
    show_notification("msg_holder", "danger", "Error", errorThrown);
}

function get_this_currency(currency_id)
{
    fade_in_loader_and_fade_out_form("loader", "ecform");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_currencies_get_one_currency_url + currency_id;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_this_currency_success_response_function, get_this_currency_error_response_function);
}


