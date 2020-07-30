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
| SEARCHING FOR RATES FUNCTION
|--------------------------------------------------------------------------
| WHEN THE SEARCH RATES FORM SUBMIT BUTTON IS CLICKED
|--------------------------------------------------------------------------
|
*/
$("#search_form").submit(function (e) 
{ 
    e.preventDefault(); 
    search_for_rates(0);
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
    
});

/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/******************************************************************************************************************************************** */
/*
|--------------------------------------------------------------------------
| ADDING RATE RESPONSE FUNCTIONS
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
| EDITING/UPDATING RATE RESPONSE FUNCTIONS
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
| SEARCHING FOR RATES RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function search_for_rates_success_response_function(response)
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
                '<tr style="cursor: pointer;" class="rate"><td>' + element.rate_id + '</td><td>' 
                + element.currency_full_name + '</td><td>' + element.currency_to_full_name + '</td><td>' + element.rate 
                + ' : 1</td><td>' + element.updated_at + '</td><td>' + element.admin_surname + " " + element.admin_firstname + '</td>'
                + '<td>'
                + '<div  id="holder_' + element.rate_id + '" class="input-group">'
                + '<input id="input_pin_' + element.rate_id + '" type="password" class="form-control" placeholder="Pin" aria-label="Pin">'
                + '<i style="cursor:pointer;" data-currency_from_id="' + element.currency_from_id + '" data-currency_to_id="' + element.currency_to_id 
                + '" data-rateid="' + element.rate_id + '" onclick="update_rate(this)" class="material-icons">keyboard_arrow_right</i>'
                + '</div>'
                + '<div  style="display:none;" id="loader_new_rate_' + element.rate_id + '"  class="customloader"></div>'
                + '</td>'
                + '</tr>'
            );
            
        }
    } else {
        show_notification("msg_holder", "danger", "", "No rates found");
    }
}


function search_for_rates_error_response_function(errorThrown)
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
function search_for_rates(url_fetch_type)
{
    if(url_fetch_type == 1){
        var url = document.getElementById("previous_btn").getAttribute("data-link");
    } else if(url_fetch_type == 2){
        var url = document.getElementById("next_btn").getAttribute("data-link");
    } else {
        var url = admin_api_rates_search_for_rates_url + document.getElementById("search_form_input").value;
    }
    fade_in_loader_and_fade_out_form("loader", "search_form");     
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    document.getElementById("table_body_list").innerHTML = "";
    document.getElementById("pagination_buttons").innerHTML = "";
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", search_for_rates_success_response_function, search_for_rates_error_response_function);

}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ALL RATES RESPONSE FUNCTIONS
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




/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF RATES FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_rates_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            $('#table_body_list').append(
                '<tr style="cursor: pointer;" class="rate"><td>' + element.rate_id + '</td><td>' 
                + element.currency_full_name + '</td><td>' + element.currency_to_full_name + '</td><td>' + element.rate 
                + ' : 1</td><td>' + element.updated_at + '</td><td>' + element.admin_surname + " " + element.admin_firstname + '</td>'
                + '<td>'
                + '<div  id="holder_' + element.rate_id + '" class="input-group">'
                + '<input id="input_pin_' + element.rate_id + '" type="password" class="form-control" placeholder="Pin" aria-label="Pin">'
                + '<i style="cursor:pointer;" data-currency_from_id="' + element.currency_from_id + '" data-currency_to_id="' + element.currency_to_id 
                + '" data-rateid="' + element.rate_id + '" onclick="update_rate(this)" class="material-icons">keyboard_arrow_right</i>'
                + '</div>'
                + '<div  style="display:none;" id="loader_new_rate_' + element.rate_id + '"  class="customloader"></div>'
                + '</td>'
                + '</tr>'
            );
            
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No rates found");
    }
}

function get_rates_for_page_error_response_function(errorThrown)
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
function get_rates_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_rates_get_rate_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_rates_for_page_success_response_function, get_rates_for_page_error_response_function);
}


/*
|--------------------------------------------------------------------------
| UPDATE RATE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function update_rate_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", "Rate updated successfully");
}

function update_rate_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| UPDATING RATE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function update_rate(obj)
{

    rate_id = obj.getAttribute("data-rateid");
    currency_from_id = obj.getAttribute("data-currency_from_id");
    currency_to_id = obj.getAttribute("data-currency_to_id");
    pin_input_obj = document.getElementById("input_pin_" + rate_id);
    loader_obj = document.getElementById("loader_new_rate_" + rate_id);
    holder_obj = document.getElementById("holder_" + rate_id);
    none = "none";

    if(pin_input_obj.value == null){
        show_notification("msg_holder", "danger", "", "Please enter your pin.");
        return;
    }

    if(pin_input_obj.value.trim() == ""){
        show_notification("msg_holder", "danger", "", "Please enter your pin.");
        return;
    }

    rate = prompt("Please enter the new rate", "");
    if(rate == null){
        show_notification("msg_holder", "danger", "", "Please enter the new. If the alertbox did not show asking for the new rate, please go to browser settings and enable popups for this website.");
        return;
    }

    if(rate.trim() == ""){
        show_notification("msg_holder", "danger", "", "Please enter the new. If the alertbox did not show asking for the new rate, please go to browser settings and enable popups for this website.");
        return;
    }

    if(isNaN(parseFloat(rate))){
        show_notification("msg_holder", "danger", "", 'Please ensure the rate you entered is a number');
        return;
    }

    rate = parseFloat(rate).toFixed(2);
    fade_in_loader_and_fade_out_form("loader_new_rate_" + rate_id, "holder_" + rate_id);   
    var form_data = "currency_from_id=" + currency_from_id + "&currency_to_id=" + currency_to_id + "&rate=" + rate + "&admin_pin=" + pin_input_obj.value;
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    window.setTimeout(loader_obj.style.display = none, 5000);
    show_log_in_console("form_data: " + form_data);
    pin_input_obj.value="";
    send_restapi_request_to_server_from_form("post", admin_api_rates_add_rate_url, bearer, form_data, "json", update_rate_success_response_function, update_rate_error_response_function);
}