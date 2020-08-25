<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Worker;
use App\Models\v1\Passcode;
use Illuminate\Http\Request;
use App\Mail\bureau\PassCodeMail;
use App\Http\Controllers\Controller;
use App\Models\v1\BureauRate;
use App\Models\v1\CurrencyStock;
use App\Models\v1\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class WorkerController extends Controller
{
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'worker_phone_number';
    }

    /*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION PROVIDES A REGISTERED WORKER WITH AN ACCESS TOKEN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    
public function login(Request $request)
{
    $log_controller = new LogController();
    $passcode_controller = new PasscodeController();

    $login_data = $request->validate([
        "worker_phone_number" => "required|regex:/(0)[0-9]{9}/",
        "password" => "required"
    ]);

    // get user object
    $worker = Worker::where('worker_phone_number', request()->worker_phone_number)->first();
    // do the passwords match?

    if ($worker == null || !Hash::check(request()->password, $worker->password)) {
        // no they don't
        $log_controller->save_log("worker", $request->worker_phone_number, "Login Worker", "1st-layer login failed");
        return response(["status" => "fail", "message" => "Invalid Credentials"]);
    }

    if ($worker->worker_flagged) {
        $log_controller->save_log("worker", $request->worker_phone_number, "Login Worker", "1st-layer login failed because worker is flagged");
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }


    // get new token
    //$tokenResult = $worker->createToken("authToken");
    $tokenResult = $worker->createToken("authToken", [$worker->worker_scope]);
    
    //$tokenResult = auth()->user()->createToken("authToken", [$worker->worker_scope])->accessToken;
    $log_controller->save_log("worker", $request->worker_phone_number, "Login Worker", "1st-layer login successful");

    $passcode = $passcode_controller->generate_passcode();

    $email_data = array(
        'pass_code' => $passcode,
        'time' => date("F j, Y, g:i a")
    );

    $passcode_controller->save_passcode("worker", $worker->worker_id, strval($passcode));

    Mail::to($worker->worker_email)->send(new PassCodeMail($email_data));
    $log_controller->save_log("worker", $request->worker_phone_number, "Login Worker", "Passcode sent for verification");

    return response([
        "status" => "success",
        "worker_firstname" => $worker->worker_firstname,
        "worker_surname" => $worker->worker_surname,
        "access_token" => $tokenResult->accessToken
    ]);

}

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION REVOKES A WORKER'S ACCESS TOKEN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function logout(Request $request)
{
    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    $request->user()->token()->revoke();
    return response(["status" => "success", "message" => "Logged out successfully"]);
}


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION RESENDS THE PASSCODE USED FOR THE SECOND LAYER LOGIN VERIFICATION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function resend_passcode(Request $request)
{
    $log_controller = new LogController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Login Worker", "Resend passcode failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $passcode = Passcode::where([
        'user_id' => auth()->user()->worker_id,
        'user_type' => "worker",
        'used' => false
    ])
    ->orderBy('passcode_id', 'desc')
    ->take(1)
    ->get();

    if (isset($passcode[0]["user_id"]) && $passcode[0]["user_id"] == auth()->user()->worker_id) {
        Mail::to(auth()->user()->worker_email)->send(new PassCodeMail(['pass_code' => $passcode[0]["passcode"], 'time' => date("F j, Y, g:i a")]));
        $log_controller->save_log("worker", auth()->user()->worker_id, "Login Worker", "Passcode re-sent for verification");
        return response(["status" => "success", "message" => "Passcode re-sent successfully"]);
    } else {
        return response(["status" => "fail", "message" => "Failed to send passcode. Restart login."]);
    }
}



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION VERIFIES THE PASSCODE ENTERED
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function verify_passcode(Request $request)
{
    $log_controller = new LogController();
    $passcode_controller = new PasscodeController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Login Worker", "Passcode verification failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $request->validate([
        "passcode" => "bail|required|max:5"
    ]);

    $passcode = Passcode::where([
        'user_id' => auth()->user()->worker_id,
        'user_type' => "worker",
        'passcode' => $request->passcode,
        'used' => false
    ])
        ->orderBy('passcode_id', 'desc')
        ->take(1)
        ->get();


    if (isset($passcode[0]["user_id"]) && $passcode[0]["user_id"] == auth()->user()->worker_id) {
        $passcode_controller->update_passcode($passcode[0]["passcode_id"], $passcode[0]["user_type"], $passcode[0]["user_id"], $passcode[0]["passcode"], true);
        return response(["status" => "success", "message" => "Verification successful"]);
    } else {
        return response(["status" => "fail", "message" => "Verification failed. Try with the correct passcode and if this continues, restart login."]);
    }
}


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION ADD A NEW CUSTOMER TO THE DATABASE
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function add_customer(Request $request)
{
    $log_controller = new LogController();
    $customer_controller = new CustomerController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (!$request->user()->tokenCan('worker_add-customer')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Customers Worker", "Permission denined for trying to add customer");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    $request->validate([
        "customer_firstname" => "bail|required|max:100",
        "customer_surname" => "bail|required|max:100",
        "customer_othernames" => "bail|max:100",
        "customer_phone_number" => "bail|required|regex:/^\+\d{1,3}[0-9]{9}/|min:10|max:15",
        "customer_email" => "bail|required|max:100",
        "customer_nationality" => "bail|required|max:100",
        "customer_id_1_type" => "bail|required|max:50",
        "customer_id_1_number" => "bail|required|max:50",
        "worker_pin" => "bail|required|min:4|max:8",
    ]);

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Customers Worker", "Addition of currency failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    if (!Hash::check($request->worker_pin, auth()->user()->worker_pin)) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Customers Worker", "Addition of customer failed because of incorrect pin");
        return response(["status" => "fail", "message" => "Incorrect pin."]);
    }

    $where_array = array(
        ['customer_id_1_type', '=', $request->customer_id_1_type],
        ['customer_id_1_number', '=', $request->customer_id_1_number],
    ); 


    if (Customer::where($where_array)->exists() || Customer::where("customer_phone_number", "=", $request->customer_phone_number)->exists()) {
        return response(["status" => "fail", "message" => "Customer already exists."]);
    } else {
        
        for ($i=0; $i < 100; $i++) { 
            $customer_amforex_id_number = rand(1000000000000, 9999999999999);
            if(!Customer::where("customer_am_id_number", "=", $customer_amforex_id_number)->exists()){
                break;
            } else if($i == 99){
                $log_controller->save_log("worker", auth()->user()->worker_id, "Customers Worker", "Addition of customer failed because of failed generation of Unique AM Forex ID.");
                return response(["status" => "fail", "message" => "Incorrect pin."]);
            }
        }

        $customer_controller->add_customer($customer_amforex_id_number, $request->customer_surname, $request->customer_firstname, $request->customer_othernames, $request->customer_phone_number, $request->customer_email, $request->customer_nationality, $request->customer_id_1_type, $request->customer_id_1_number, auth()->user()->bureau_id, auth()->user()->worker_id);
        $log_text = "New customer added. Name: " . $request->customer_surname . " " . $request->customer_firstname . ". ID TYPE: " . $request->customer_id_1_type . ". ID NUMBER: " . $request->customer_id_1_number;
        $log_controller->save_log("worker", auth()->user()->worker_id, "Customer Worker", $log_text);
        return response(["status" => "success", "message" => "Customer added successfully"]);
    }
}

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION GETS THE LIST OF ALL THE CURRENCIES
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function get_all_currencies(Request $request)
{
    $log_controller = new LogController();
    $currency_controller = new CurrencyController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (!$request->user()->tokenCan('worker_view-currencies')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Permission denined for trying to view all currencies");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Currencies Worker", "Fetching all currencies failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $currencies =  $currency_controller->get_all_currencies();

    return response(["status" => "success", "message" => "Operation successful", "data" => $currencies]);
}



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION LETS YOU ADD RATES
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function add_rate(Request $request)
{
    $log_controller = new LogController();
    $currency_controller = new CurrencyController();
    $rate_controller = new BureauRateController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_add-rate')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Permission denined for trying to add rate");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    $request->validate([
        "currency_from_id" => "bail|required|integer",
        "currency_to_id" => "bail|required|integer",
        "rate" => "bail|required|regex:/[\d]{1,2}.[\d]{2}/",
        "worker_pin" => "bail|required|min:4|max:8",
    ]);

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Addition of rate failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    if (!Hash::check($request->worker_pin, auth()->user()->worker_pin)) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Addition of rate failed because of incorrect pin");
        return response(["status" => "fail", "message" => "Incorrect pin."]);
    }

    $currency_from = $currency_controller->get_currency("currency_id", $request->currency_from_id);
    $currency_to = $currency_controller->get_currency("currency_id", $request->currency_to_id);
    
    if($currency_from[0]->currency_abbreviation == "" || $currency_to[0]->currency_abbreviation == ""){
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Addition of rate failed because one of the currencies were not found in the database");
        return response(["status" => "fail", "message" => "Currency not found"]);
    }

    $old_rate = BureauRate::where('bureau_rate_ext_id', '=', $rate_controller->make_rate_ext_id(auth()->user()->bureau_id, $currency_from[0]->currency_abbreviation, $currency_to[0]->currency_abbreviation))->first();

    if (isset($old_rate->bureau_rate_id)) {
        $log_text = "Rate updated. RATE-ID" . $old_rate->bureau_rate_ext_id . ". RATE: 1: " . $request->rate;
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", $log_text);
        $rate_controller->update_rate(auth()->user()->bureau_id, $old_rate->bureau_rate_id, $old_rate->bureau_rate_ext_id, $old_rate->currency_from_id, $old_rate->currency_to_id, $request->rate, auth()->user()->worker_id);
        return response(["status" => "success", "message" => "Rate updated successfully"]);
    } else {
        $log_text = "New rate added. CURRENCY-FROM: " . $currency_from[0]->currency_abbreviation . ". CURRENCY-TO: " . $currency_to[0]->currency_abbreviation . ". RATE: 1: " . $request->rate;
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", $log_text);
        $rate_controller->add_rate(auth()->user()->bureau_id, $currency_from[0]->currency_id, $currency_from[0]->currency_abbreviation, $currency_to[0]->currency_id, $currency_to[0]->currency_abbreviation, $request->rate, auth()->user()->worker_id);
        return response(["status" => "success", "message" => "Rate added successfully"]);
    }
}



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION GETS THE LIST OF ALL THE RATES
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function get_all_rates(Request $request)
{
    $log_controller = new LogController();
    $rate_controller = new BureauRateController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_view-rates')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Permission denined for trying to view rates");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Fetching all rates failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $request->validate([
        "page" => "bail|required|integer",
    ]);


    $rates =  $rate_controller->get_all_rates(50);

    return response(["status" => "success", "message" => "Operation successful", "data" => $rates]);
}


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION SEARCHES FOR RATES USING A KEYWORD
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function search_for_rates(Request $request)
{
    $log_controller = new LogController();
    $rate_controller = new BureauRateController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_view-rates')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Permission denined for trying to view rates");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Fetching all rates failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $request->validate([
        "kw" => "bail|required",
    ]);

    $like_keyword = '%' . $request->kw . '%';

    $where_array = array(
        ['currencies.currency_full_name', 'LIKE', $like_keyword],
    ); 
    $orwhere_array = array(
        ['currencies.currency_abbreviation', 'LIKE', $like_keyword],
    ); 

    $rates = $rate_controller->search_for_rates(50, $where_array, $orwhere_array);
    
    return response(["status" => "success", "message" => "Operation successful", "data" => $rates, "kw" => $request->kw]);
}



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION LETS YOU ADD STOCKS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function add_currency_stock(Request $request)
{
    $log_controller = new LogController();
    $currency_controller = new CurrencyController();
    $currency_stock_controller = new CurrencyStockController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_add-rate')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Rates Worker", "Permission denined for trying to add stock");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    $request->validate([
        "currency_id" => "bail|required|integer",
        "stock" => "bail|required",
        "worker_pin" => "bail|required|min:4|max:8",
    ]);

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Addition of stock failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    if (!Hash::check($request->worker_pin, auth()->user()->worker_pin)) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Addition of stock failed because of incorrect pin");
        return response(["status" => "fail", "message" => "Incorrect pin."]);
    }

    $stock_currency = $currency_controller->get_currency("currency_id", $request->currency_id);
    
    if($stock_currency[0]->currency_abbreviation == ""){
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Addition of stock failed because the currency was not found in the database");
        return response(["status" => "fail", "message" => "Currency not found"]);
    }

    $old_stock = CurrencyStock::where('stock_ext_id', '=', $currency_stock_controller->make_stock_ext_id($stock_currency[0]->currency_abbreviation, auth()->user()->bureau_id))->first();

    if (isset($old_stock->stock_id)) {
        $log_text = "Stock updated. Stock-ID" . $old_stock->stock_ext_id . ". NEW STOCK: " . $stock_currency[0]->currency_abbreviation . $request->stock;
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stock Worker", $log_text);
        $currency_stock_controller->update_currency_stock($old_stock->stock_id, $request->stock, auth()->user()->worker_id);
        return response(["status" => "success", "message" => "Stock updated successfully"]);
    } else {
        $log_text = "New stock added. CURRENCY: " . $stock_currency[0]->currency_abbreviation . ". STOCK: " . $request->stock;
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stock Worker", $log_text);
        $currency_stock_controller->add_currency_stock($stock_currency[0]->currency_id, $stock_currency[0]->currency_abbreviation, auth()->user()->bureau_id, $request->stock, auth()->user()->worker_id);
        return response(["status" => "success", "message" => "Stock added successfully"]);
    }
}



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION GETS THE LIST OF ALL THE STOCKS
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function get_all_stocks(Request $request)
{
    $log_controller = new LogController();
    $currency_stock_controller = new CurrencyStockController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_view-stocks')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stock Worker", "Permission denined for trying to view stocks");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Fetching all stocks failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $request->validate([
        "page" => "bail|required|integer",
    ]);

    $stocks =  $currency_stock_controller->get_currency_stocks(50);

    return response(["status" => "success", "message" => "Operation successful", "data" => $stocks]);
}

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION SEARCHES FOR STOCKS USING A KEYWORD
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
public function search_for_stocks(Request $request)
{
    $log_controller = new LogController();
    $currency_stock_controller = new CurrencyStockController();

    if (!Auth::guard('worker')->check()) {
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }
    
    if (!$request->user()->tokenCan('worker_view-stocks')) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Permission denined for trying to view stocks");
        return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
    }

    if (auth()->user()->worker_flagged) {
        $log_controller->save_log("worker", auth()->user()->worker_id, "Stocks Worker", "Fetching all stocks failed because worker is flagged");
        $request->user()->token()->revoke();
        return response(["status" => "fail", "message" => "Account access restricted"]);
    }

    $request->validate([
        "kw" => "bail|required",
    ]);

    $like_keyword = '%' . $request->kw . '%';

    $where_array = array(
        ['currencies.currency_full_name', 'LIKE', $like_keyword],
    ); 
    $orwhere_array = array(
        ['currencies.currency_abbreviation', 'LIKE', $like_keyword],
    ); 

    $stocks = $currency_stock_controller->search_for_currency_stocks(50, $where_array, $orwhere_array);
    
    return response(["status" => "success", "message" => "Operation successful", "data" => $stocks, "kw" => $request->kw]);
}





    
    public function save_worker($worker_surname, $worker_firstname, $worker_othernames, $worker_home_gps_address, $worker_home_location, $worker_position, $worker_scope, $worker_flagged, $worker_is_first, $worker_phone_number, $worker_email, $worker_pin, $password, $creator_user_type, $creator_id, $branch_id, $bureau_id)
    {        
        $worker = new Worker();
        $worker->worker_surname = $worker_surname; 
        $worker->worker_firstname = $worker_firstname;
        $worker->worker_othernames = $worker_othernames;
        $worker->worker_home_gps_address = $worker_home_gps_address;
        $worker->worker_home_location = $worker_home_location;
        $worker->worker_position = $worker_position;
        $worker->worker_scope = $worker_scope;
        $worker->worker_phone_number = $worker_phone_number;
        $worker->worker_email = $worker_email;
        $worker->worker_pin = $worker_pin;
        $worker->password = $password;
        $worker->worker_flagged = $worker_flagged;
        $worker->worker_was_first = $worker_is_first;
        $worker->creator_user_type = $creator_user_type;
        $worker->creator_id = $creator_id;
        $worker->branch_id = $branch_id;
        $worker->bureau_id = $bureau_id;
        $worker->save();

    }


    public function update_worker($worker_id, $worker_surname, $worker_firstname, $worker_othernames, $worker_home_gps_address, $worker_home_location, $worker_position, $worker_scope, $worker_flagged, $worker_phone_number, $worker_email, $worker_pin, $password, $creator_user_type, $creator_id, $branch_id, $bureau_id)
    {
        $worker = Worker::find($worker_id);
        $worker->worker_surname = $worker_surname; 
        $worker->worker_firstname = $worker_firstname;
        $worker->worker_othernames = $worker_othernames;
        $worker->worker_home_gps_address = $worker_home_gps_address;
        $worker->worker_home_location = $worker_home_location;
        $worker->worker_position = $worker_position;
        $worker->worker_scope = $worker_scope;
        $worker->worker_phone_number = $worker_phone_number;
        $worker->worker_email = $worker_email;
        $worker->worker_pin = $worker_pin;
        $worker->password = $password;
        $worker->worker_flagged = $worker_flagged;
        $worker->creator_user_type = $creator_user_type;
        $worker->creator_id = $creator_id;
        $worker->branch_id = $branch_id;
        $worker->bureau_id = $bureau_id;
        $worker->save();

    }
}
