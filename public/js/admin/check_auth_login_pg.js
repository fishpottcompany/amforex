if(user_has_api_token() && user_has_completed_passcode_verification()){
    redirect_to_next_page(admin_web_dashboard_page_url, false);
}