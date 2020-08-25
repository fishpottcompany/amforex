$(document).ready(function () 
{
    /*
    |--------------------------------------------------------------------------
    | ADDING STOCK FUNCTION
    |--------------------------------------------------------------------------
    | WHEN THE ADD STOCK FORM SUBMIT BUTTON IS CLICKED
    |--------------------------------------------------------------------------
    |
    */
    $("#arform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "arform");  
        rate_input = document.getElementById("rate");

        if( isNaN( parseFloat(rate_input.value))){
            show_notification("msg_holder", "danger", "", 'Please ensure the stock you entered is a number');
            fade_out_loader_and_fade_in_form("loader", "arform"); 
            return;
        }
        rate_input.value = parseFloat(rate_input.value).toFixed(2);
        var form_data = $("#arform").serialize();
        fade_out_loader_and_fade_in_form("loader", "arform"); 

        var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
        send_restapi_request_to_server_from_form("post", worker_api_stocks_add_stock_url, bearer, form_data, "json", add_stock_success_response_function, add_stock_error_response_function);
    });

    /*
    |--------------------------------------------------------------------------
    | SEARCHING FOR RATES FUNCTION
    |--------------------------------------------------------------------------
    | WHEN THE SEARCH RATES FORM SUBMIT BUTTON IS CLICKED
    |--------------------------------------------------------------------------
    |
    */
    $("#search_form").submit(function (e) 
    { 
        e.preventDefault(); 
        search_for_stocks(0);
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
        var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
        send_restapi_request_to_server_from_form("post", worker_api_currencies_edit_currency_url, bearer, form_data, "json", edit_currency_success_response_function, edit_currency_error_response_function);
    });


});

/*
|--------------------------------------------------------------------------
| ADDING STOCK RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
| Here is where I add a currency
|--------------------------------------------------------------------------
|
*/
function add_stock_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Rate updated successfully");
    fade_out_loader_and_fade_in_form("loader", "arform"); 
    $('#arform')[0].reset();
}

function add_stock_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "arform"); 
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
            url = host + "/worker/rates/edit/" + element.currency_id;
            if(element.currency_flagged == 0){tradable = "Yes";} else { tradable = "No"; }
            $('#currency_from_id').append(
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
| GETTING THE LIST OF STOCKS FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_stocks_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate">'
                + '<td>' + element.stock_id + '</td>'
                + '<td>' + element.currency_full_name + '</td>'
                + '<td>' + element.stock + '</td>'
                +' <td>' + element.updated_at + ' : 1</td>'
                + '<td>' + element.worker_surname + " " + element.worker_firstname + '</td>'
                + '<td>'
                + '<div  id="holder_' + element.stock_id + '" class="input-group">'
                + '<input id="input_pin_' + element.stock_id + '" type="password" class="form-control" placeholder="Pin" aria-label="Pin">'
                + '<i style="cursor:pointer;" data-currency_id="' + element.currency_id + '" data-stock_id="' + element.stock_id
                + '" onclick="update_stock(this)" class="material-icons">keyboard_arrow_right</i>'
                + '</div>'
                + '<div  style="display:none;" id="loader_new_stock_' + element.stock_id + '"  class="customloader"></div>'
                + '</td>'
                + '</tr>'
            );
            
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No rates found");
    }
}

function get_stocks_for_page_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF RATES FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_stocks_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    url = worker_api_stocks_get_stocks_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_stocks_for_page_success_response_function, get_stocks_for_page_error_response_function);
}

/*
|--------------------------------------------------------------------------
| SEARCHING FOR RATES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_stocks_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
    if(response.data.data.length > 0){
        show_log_in_console("response.data.prev_page_url : " + response.data.prev_page_url);
        show_log_in_console("response.data.next_page_url : " + response.data.next_page_url);
        if(response.data.prev_page_url != null){
            $('#pagination_buttons').append(
                '<a id="previous_btn" class="btn btn-default" data-link = "' + response.data.prev_page_url + '&kw=' + response.kw + '" onclick="search_for_rates(1)"><i class="material-icons">keyboard_arrow_left</i></a>'
            );
        }
        if(response.data.next_page_url != null){
            $('#pagination_buttons').append(
                '<a id="next_btn" class="btn btn-default" data-link = "' + response.data.next_page_url + '&kw=' + response.kw + '" onclick="search_for_rates(2)"><i class="material-icons">keyboard_arrow_right</i></a>'
            );
        }
        
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate">'
                + '<td>' + element.stock_id + '</td>'
                + '<td>' + element.currency_full_name + '</td>'
                + '<td>' + element.stock + '</td>'
                +' <td>' + element.updated_at + ' : 1</td>'
                + '<td>' + element.worker_surname + " " + element.worker_firstname + '</td>'
                + '<td>'
                + '<div  id="holder_' + element.stock_id + '" class="input-group">'
                + '<input id="input_pin_' + element.stock_id + '" type="password" class="form-control" placeholder="Pin" aria-label="Pin">'
                + '<i style="cursor:pointer;" data-currency_id="' + element.currency_id + '" data-stock_id="' + element.stock_id
                + '" onclick="update_stock(this)" class="material-icons">keyboard_arrow_right</i>'
                + '</div>'
                + '<div  style="display:none;" id="loader_new_stock_' + element.stock_id + '"  class="customloader"></div>'
                + '</td>'
                + '</tr>'
            );
            
        }
    } else {
        show_notification("msg_holder", "danger", "", "No stocks found");
    }
}


function search_for_stocks_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
    fade_out_loader_and_fade_in_form("loader", "search_form"); 
}



/*
|--------------------------------------------------------------------------
| SEARCHING FOR RATES FUNCTION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_stocks(url_fetch_type)
{
    if(url_fetch_type == 1){
        var url = document.getElementById("previous_btn").getAttribute("data-link");
    } else if(url_fetch_type == 2){
        var url = document.getElementById("next_btn").getAttribute("data-link");
    } else {
        var url = worker_api_rates_search_for_rates_url + document.getElementById("search_form_input").value;
    }
    fade_in_loader_and_fade_out_form("loader", "search_form");     
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    document.getElementById("table_body_list").innerHTML = "";
    document.getElementById("pagination_buttons").innerHTML = "";
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", search_for_stocks_success_response_function, search_for_stocks_error_response_function);

}



/*
|--------------------------------------------------------------------------
| UPDATE RATE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function update_stock_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Stock updated successfully");
}

function update_stock_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
    fade_out_loader_and_fade_in_form("loader_new_stock_" + stock_id, "holder_" + stock_id);
}



/*
|--------------------------------------------------------------------------
| UPDATING RATE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function update_stock(obj)
{

    stock_id = obj.getAttribute("data-stock_id");
    currency_id = obj.getAttribute("data-currency_id");
    pin_input_obj = document.getElementById("input_pin_" + stock_id);
    loader_obj = document.getElementById("loader_new_stock_" + stock_id);
    holder_obj = document.getElementById("holder_" + stock_id);
    none = "none";

    if(pin_input_obj.value == null){
        show_notification("msg_holder", "danger", "", "Please enter your pin.");
        return;
    }

    if(pin_input_obj.value.trim() == ""){
        show_notification("msg_holder", "danger", "", "Please enter your pin.");
        return;
    }

    stock = prompt("Please enter the new stock", "");

    if(stock == null){
        show_notification("msg_holder", "danger", "", "Please enter the new stock. If the alertbox did not show asking for the new stock, please go to browser settings and enable popups for this website.");
        return;
    }

    if(stock.trim() == ""){
        show_notification("msg_holder", "danger", "", "Please enter the new stock. If the alertbox did not show asking for the new stock, please go to browser settings and enable popups for this website.");
        return;
    }

    if(isNaN(parseFloat(stock))){
        show_notification("msg_holder", "danger", "", 'Please ensure the stock you entered is a number');
        return;
    }

    stock = parseFloat(stock).toFixed(2);

    fade_in_loader_and_fade_out_form("loader_new_stock_" + stock_id, "holder_" + stock_id);   

    var form_data = "currency_id=" + currency_id + "&stock=" + stock + "&worker_pin=" + pin_input_obj.value;
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    window.setTimeout(loader_obj.style.display = none, 5000);
    show_log_in_console("form_data: " + form_data);
    stock.value="";
    send_restapi_request_to_server_from_form("post", worker_api_stocks_add_stock_url, bearer, form_data, "json", update_stock_success_response_function, update_stock_error_response_function);
}