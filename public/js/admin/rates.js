$(document).ready(function () 
{
/*
|--------------------------------------------------------------------------
| ADDING RATE FUNCTION
|--------------------------------------------------------------------------
| WHEN THE ADD RATE FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
   $("#arform").submit(function (e) 
   { 
       e.preventDefault(); 
       fade_in_loader_and_fade_out_form("loader", "arform");  
       rate_input = document.getElementById("rate");

       if( isNaN( parseFloat(rate_input.value))){
        show_notification("msg_holder", "danger", "", 'Please ensure the rate you entered is a number');
        fade_out_loader_and_fade_in_form("loader", "arform"); 
        return;
       }
       rate_input.value = parseFloat(rate_input.value).toFixed(2);
       var form_data = $("#arform").serialize();
       fade_out_loader_and_fade_in_form("loader", "arform"); 
    
       if(document.getElementById("currency_from_id").value == document.getElementById("currency_to_id").value){
            show_notification("msg_holder", "danger", "", 'The currency(from) and currency(to) cannot be the same');
            fade_out_loader_and_fade_in_form("loader", "arform"); 
            return;
       }

       var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
       send_restapi_request_to_server_from_form("post", admin_api_rates_add_rate_url, bearer, form_data, "json", add_rate_success_response_function, add_rate_error_response_function);
   });
   
/*
|--------------------------------------------------------------------------
| ADDING RATE FUNCTION
|--------------------------------------------------------------------------
| WHEN THE ADD RATE FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
    $("#erform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "ecform");       
        var form_data = $("#ecform").serialize();
        var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
        send_restapi_request_to_server_from_form("post", admin_api_currencies_edit_currency_url, bearer, form_data, "json", edit_currency_success_response_function, edit_currency_error_response_function);
    });



/*
|--------------------------------------------------------------------------
| WHEN A CURRENCY LIST ITEM IS CLICKED, WE SEND THEM TO THE EDIT PAGE.
|--------------------------------------------------------------------------
| FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
|--------------------------------------------------------------------------
|
*/

    
    $(document).on('click', '.rate', function () {
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
function add_rate_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Rate updated successfully");
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    $('#arform')[0].reset();
}

function add_rate_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "arform"); 
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
function edit_rate_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Currency updated successfully");
    fade_out_loader_and_fade_in_form("loader", "ecform"); 
    $('#arform')[0].reset();
}

function edit_rate_error_response_function(errorThrown)
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
function get_all_currencies_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    if(response.data.length > 0){
        for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            url = host + "/admin/rates/edit/" + element.currency_id;
            if(element.currency_flagged == 0){tradable = "Yes";} else { tradable = "No"; }
            $('#currency_from_id').append(
                '<option value="' + element.currency_id + '">' + element.currency_full_name + '</option>'
               
            );
            $('#currency_to_id').append(
                '<option value="' + element.currency_id + '">' + element.currency_full_name + '</option>'
            );
            
        }
        $('#submit_button_add_rate_form').append(
            '<button type="submit" class="btn btn-primary pull-right">Add</button>'
        );
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
    fade_in_loader_and_fade_out_form("loader", "arform");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    send_restapi_request_to_server_from_form("get", admin_api_currencies_get_currency_list_url, bearer, "", "json", get_all_currencies_success_response_function, get_all_currencies_error_response_function);
}


