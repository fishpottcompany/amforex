
    if(!user_has_api_token()){
        redirect_to_next_page(admin_web_login_page_url, false);
    }

    if(user_has_api_token() && user_has_completed_passcode_verification()){
        redirect_to_next_page(admin_web_dashboard_page_url, false);
    }