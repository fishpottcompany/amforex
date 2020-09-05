
/****************************************
    
                URLS

****************************************/
var host = "http://amforex";

// LOGIN PAGE URLS
var worker_api_login_url = `${host}/api/v1/bureau/login`;
var worker_web_login_page_url = `${host}/`;


// PASSCODE VERIFICATION PAGE URL
var worker_api_send_passcode_url = `${host}/api/v1/bureau/verification`;
var worker_api_resend_passcode_url = `${host}/api/v1/bureau/resend`;
var worker_web_passcode_page_url = `${host}/bureau/verification`;

// DASHBOARD PAGE
var worker_web_dashboard_page_url = `${host}/bureau/dashboard`;

// LOG OUT
var worker_api_logout_url = `${host}/api/v1/bureau/logout`;


// RATES 
var worker_api_currencies_get_currency_list_url = `${host}/api/v1/bureau/currencies/list`;
var worker_api_rates_add_rate_url = `${host}/api/v1/bureau/rates/add`;
var worker_api_rates_get_rate_list_url = `${host}/api/v1/bureau/rates/list/?page=`;
var worker_api_rates_search_for_rates_url = `${host}/api/v1/bureau/rates/search/?kw=`;

// STOCKS
var worker_api_stocks_add_stock_url = `${host}/api/v1/bureau/stocks/add`;
var worker_api_stocks_get_stocks_list_url = `${host}/api/v1/bureau/stocks/list/?page=`;
var worker_api_stocks_search_for_stock_url = `${host}/api/v1/bureau/stocks/search/?kw=`;

// CUSTOMER
var worker_api_customers_add_customer_url = `${host}/api/v1/bureau/customers/add`;
var worker_api_customers_search_for_customer_url = `${host}/api/v1/bureau/customers/search/?kw=`;

// TRADES
var worker_api_trades_add_trade_url = `${host}/api/v1/bureau/trades/add`;
var worker_api_trades_get_trades_list_url = `${host}/api/v1/bureau/trades/list/?page=`;
var worker_api_trades_search_for_trades_url = `${host}/api/v1/bureau/trades/search/?`;
var worker_web_export_trades_as_pdf_page_url = `${host}/bureau/transactions/export/pdf/?`;

// SECURITY
var worker_api_security_change_password_url = `${host}/api/v1/bureau/security/password/change`;

// BRANCHES
var worker_api_branches_add_branch_url = `${host}/api/v1/bureau/branches/add`;
var worker_api_branches_get_branches_list_url = `${host}/api/v1/bureau/branches/list`;


// WORKERS
var worker_api_branches_add_branch_url = `${host}/api/v1/bureau/branches/add`;



var show_logging_in_console = true;


// LOGGING INFORMATION
function show_log_in_console(log){
    if(show_logging_in_console){
        console.log(log);
    }
}


// CHECKING IF USER HAS AN API TOKEN
function user_has_api_token()
{
    if(
        (localStorage.getItem("worker_access_token") != null && localStorage.getItem("worker_firstname") != null && localStorage.getItem("worker_surname") != null ) 
        && 
        (localStorage.getItem("worker_access_token").trim() != "" && localStorage.getItem("worker_firstname").trim() != "" && localStorage.getItem("worker_surname").trim() != ""))
        {
            return true;
        } else {
            return false;
        }
}

// CHECKING IF USER COMPLETED PASSCODE VERIFICATION
function user_has_completed_passcode_verification()
{
    if(
        (localStorage.getItem("worker_passcode_completed") != null && localStorage.getItem("worker_passcode").trim() != null)
        &&
        (localStorage.getItem("worker_passcode_completed") === "1" && localStorage.getItem("worker_passcode").trim() === "149")
        ){
            return true;
        } else {
            return false;
        }
}

// LOGGING USER OUT BY DELETING ACCESS TOKEN
function delete_user_authentication()
{
    localStorage.clear();
    show_log_in_console("user_deleted");
}

function user_token_is_no_longer_valid()
{
    delete_user_authentication();
    redirect_to_next_page(worker_web_login_page_url, false); 
}

function sign_out_success(response)
{
    delete_user_authentication(); 
    user_token_is_no_longer_valid()
}

function sign_out_error(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
    fade_out_loader_and_fade_in_form("loader", "logoutspan");   
}

function sign_me_out()
{    
    fade_in_loader_and_fade_out_form("logoutloader", "logoutspan");     
    var bearer = "Bearer " + localStorage.getItem("worker_access_token"); 
    send_restapi_request_to_server_from_form("get", worker_api_logout_url, bearer, "", "json", sign_out_success, sign_out_error);
}


function hide_notification(){
    document.getElementById('msg_div').style.display = "none";
}

// SHOWING A NOTIFICATION ON THE SCREEN
function show_notification(id, type, title, message)
{
    $('#'+id).html(
        '<div id="msg_div" class="' + type + '"><b>' + title +'</b> '+ message +'<a id="close-bar" onclick="hide_notification();">×</a></div>'
    );
}


// SHOWING A LOADER AND DISAPPEARING FORM
function fade_in_loader_and_fade_out_form(loader_id, form_id)
{
    if(loader_id != ""){
        $('#'+loader_id).fadeIn();
    }

    if(form_id != ""){
        $('#'+form_id).fadeOut();        
    }
}

// SHOWING A FORM AND DISAPPEARING LOADER
function fade_out_loader_and_fade_in_form(loader_id, form_id)
{
    if(loader_id != ""){
        $('#'+loader_id).fadeOut();
    }

    if(form_id != ""){
        $('#'+form_id).fadeIn();       
    }

}

// SENDING USER TO NEW PAGE
function redirect_to_next_page(url, can_return_to_page)
{
    if(can_return_to_page){// Simulate a mouse click:
        setTimeout(window.location.href = url, 7000);
    } else {
        setTimeout(window.location.replace(url), 7000);
    }
}

function send_request_to_server_from_form(method, url_to_server, form_data, data_type, success_response_function, error_response_function)
{
    $.ajax({
        type: method,
        url: url_to_server,
        data:  form_data,
        dataType: data_type,
        success: function(response){ 
            show_log_in_console(response);
            if(response.status.trim() == "success"){
                success_response_function(response);
            } else {
                error_response_function(response.message);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            show_log_in_console(errorThrown);
            error_response_function(errorThrown);
        }
    });
}

function send_restapi_request_to_server_from_form(method, url_to_server, authorization, form_data, data_type, success_response_function, error_response_function)
{
    $.ajax({
        type: method,
        url: url_to_server,headers: {
            'Authorization': authorization
         },
        data:  form_data,
        dataType: data_type,
        success: function(response){ 
            show_log_in_console(response);

            if(response == "Unauthorized"){
                user_token_is_no_longer_valid();
                return;
            } 
            if(response.status.trim() == "success"){
                success_response_function(response);
            } else {
                error_response_function(response.message);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            show_log_in_console(errorThrown);
            if(errorThrown == "Unauthorized"){
                user_token_is_no_longer_valid();
                return;
            }
            error_response_function(errorThrown);
        }
    });
}