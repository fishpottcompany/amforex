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
   $("#form").submit(function (e) 
   { 
       e.preventDefault(); 
       fade_in_loader_and_fade_out_form("loader", "form");
       var form_data = $("#form").serialize();
       var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
       show_log_in_console("form_data: " + form_data);
       
       show_log_in_console("url: " + admin_api_administrators_add_administrator_url);
       
       send_restapi_request_to_server_from_form("post", admin_api_administrators_add_administrator_url, bearer, form_data, "json", add_administrator_success_response_function, add_administrator_error_response_function);
   });
   
    /*
    |--------------------------------------------------------------------------
    | EDITING ADMIN FUNCTION
    |--------------------------------------------------------------------------
    |
    */
    $("#eform").submit(function (e) 
    { 
        e.preventDefault(); 
        fade_in_loader_and_fade_out_form("loader", "eform");
        var form_data = $("#eform").serialize();
        var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
        show_log_in_console("form_data: " + form_data);
        
        show_log_in_console("url: " + admin_api_administrators_edit_administrator_url);
        
        send_restapi_request_to_server_from_form("post", admin_api_administrators_edit_administrator_url, bearer, form_data, "json", add_administrator_success_response_function, add_administrator_error_response_function);
    });

/*
    |--------------------------------------------------------------------------
    | WHEN A BUREAU LIST ITEM IS CLICKED, WE SEND THEM TO THE EDIT PAGE.
    |--------------------------------------------------------------------------
    | FOR SOME REASON, I COULD NOT PUT AN <A> TAG DIRECTLY IN THE TABLE
    |--------------------------------------------------------------------------
    |
    */
    $(document).on('click', '.thisworker', function () {
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
function add_administrator_success_response_function(response)
{
    show_notification("msg_holder", "success", "Success:", response.message);
    fade_out_loader_and_fade_in_form("loader", "form"); 
    $('#form')[0].reset();
}

function add_administrator_error_response_function(errorThrown)
{
    fade_out_loader_and_fade_in_form("loader", "form"); 
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF ADMINS FOR A SPECIFIC PAGE RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_admins_for_page_success_response_function(response)
{
    fade_out_loader_and_fade_in_form("loader", "list_table"); 
    if(response.data.data.length > 0){
        for (let index = 0; index < response.data.data.length; index++) {
            const element = response.data.data[index];
            if(element.admin_flagged == 0){
                admin_flagged = "No";
            } else {
                admin_flagged = "Yes";
            }
            url = host + "/admin/administrators/edit/" + element.admin_id;
            $('#table_body_list').append(
                '<tr style="cursor: pointer;"  class="thisworker" data-url="' + url + '">'
                + '<td>' + element.admin_id + '</td>'
                + '<td>' + element.admin_surname + ' ' + element.admin_firstname +  '</td>'
                + '<td>' + element.admin_phone_number + '</td>'
                + '<td>' + element.admin_email + '</td>'
                + '<td>' + admin_flagged + '</td>'
                + '<td>' + element.creator_name + '</td>'
                + '</tr>'
            );
            
        }
        document.getElementById("next_btn").style.display = "";
    } else {
        show_notification("msg_holder", "danger", "", "No admins found");
    }
}

function get_admins_for_page_error_response_function(errorThrown)
{
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| GETTING THE LIST OF admins FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
function get_admins_for_page(page_number)
{
    fade_in_loader_and_fade_out_form("loader", "list_table");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_admins_get_admins_list_url + page_number;
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_admins_for_page_success_response_function, get_admins_for_page_error_response_function);
}


/*
|--------------------------------------------------------------------------
| GETTING THE A SINGLE BUREAU TO BE EDITED AND IT'S RESPONSE FUNCTIONS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Phone Number</label>
                          <input type="text" maxlength="10" id="admin_phone_number" name="admin_phone_number" class="form-control" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Admin Email</label>
                          <input type="text" maxlength="100" id="admin_email" name="admin_email" class="form-control" >
                        </div>
                      </div>
                    </div>
*/
function get_this_admin_success_response_function(response)
{
    if(response.data != null && response.data.admin_id != ""){
            const element = response.data[0];
            $("#admin_surname").val(element.admin_surname);
            $("#admin_firstname").val(element.admin_firstname);
            $("#admin_othernames").val(element.admin_othernames);
            //$("#admin_phone_number").val(element.admin_phone_number);
            //$("#admin_email").val(element.admin_email);

            if(element.admin_flagged == 0){
                admin_flagged = "Un-flagged";
            } else {
                admin_flagged = "Flagged";
            }
            
            document.getElementById("admin_flagged_label").innerHTML = " |   Current Status: " + admin_flagged;
            document.getElementById("button_holder").innerHTML = '<button type="submit" class="btn btn-primary pull-right">Edit</button>';
            $('#loader').hide();
            $('#eform').fadeIn();
    } else {
        $('#loader').fadeOut();
        show_notification("msg_holder", "danger", "", "Admin not found");
    }
}

function get_this_admin_error_response_function(errorThrown)
{
    $('#loader').fadeOut();
    show_notification("msg_holder", "danger", "Error", errorThrown);
}


/*
|--------------------------------------------------------------------------
| FETCHING A SINGLE WORKER FUNCTION
|--------------------------------------------------------------------------

|
*/

function get_this_admin(admin_id)
{
    fade_in_loader_and_fade_out_form("loader", "form");   
    var bearer = "Bearer " + localStorage.getItem("admin_access_token"); 
    url = admin_api_admins_get_one_admin_url + admin_id;
    show_log_in_console("url: " + url);
    send_restapi_request_to_server_from_form("get", url, bearer, "", "json", get_this_admin_success_response_function, get_this_admin_error_response_function);
}