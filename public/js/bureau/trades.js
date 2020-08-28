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
       currency_in_amount_input = document.getElementById("currency_in_amount");

       if( isNaN( parseFloat(currency_in_amount_input.value))){
        show_notification("msg_holder", "danger", "", 'Please ensure the amount you entered is a number');
        fade_out_loader_and_fade_in_form("loader", "arform"); 
        return;
       }
       currency_in_amount_input.value = parseFloat(currency_in_amount_input.value).toFixed(2);
       var form_data = $("#arform").serialize();
       show_log_in_console("form_data: " + form_data);
       fade_out_loader_and_fade_in_form("loader", "arform"); 
    
       if(document.getElementById("currency_in_id").value == document.getElementById("currency_out_id").value){
            show_notification("msg_holder", "danger", "", 'The currency coming-in and going-out cannot be the same');
            fade_out_loader_and_fade_in_form("loader", "arform"); 
            return;
       }

       var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
       send_restapi_request_to_server_from_form("post", worker_api_trades_add_trade_url, bearer, form_data, "json", add_trade_success_response_function, add_trade_error_response_function);
   });

});

/*
|--------------------------------------------------------------------------
| ADDING RATE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I add a currency
|--------------------------------------------------------------------------
|
*/
function add_trade_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", response.message);
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    $('#arform')[0].reset();
}

function add_trade_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL CURRENCIES AND RESPONSE FUNCTIONS
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
            if(element.currency_flagged == 0){tradable = "Yes";} else { tradable = "No"; }
            $('#currency_in_id').append(
                '<option value="' + element.currency_id + '">' + element.currency_full_name + '</option>'
               
            );
            $('#currency_out_id').append(
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
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    send_restapi_request_to_server_from_form("get", worker_api_currencies_get_currency_list_url, bearer, "", "json", get_all_currencies_success_response_function, get_all_currencies_error_response_function);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF RATES FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_trades_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    url = worker_api_trades_get_trades_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_trades_for_page_success_response_function, get_trades_for_page_error_response_function);
}

/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF STOCKS FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_trades_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate">'
                + '<td>' + element.trade_id + '</td>'
                + '<td>' + element.currency_full_name + '</td>'
                + '<td>' + element.trade_currency_in_amount + '</td>'
                + '<td>' + element.trade_currency_out_full_name + '</td>'
                +' <td>' + element.trade_currency_out_amount + '</td>'
                + '<td>' + element.updated_at + '</td>'
                + '<td>' + element.worker_surname + " " + element.worker_firstname + '</td>'
                //+ '<td><a href="' + host + '/bureau/transactions/edit/' + element.trade_id + '"><i class="material-icons">colorize</i></a></td>'
                + '</tr>'
            );
            
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No trades found");
    }
}

function get_trades_for_page_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}
