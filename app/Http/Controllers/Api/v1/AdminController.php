<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Currency;
use App\Models\v1\Passcode;
use Illuminate\Http\Request;
use App\Mail\admin\PassCodeMail;
use App\Models\v1\Administrator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\v1\LogController;

class AdminController extends Controller
{
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'admin_phone_number';
    }


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION REGISTES AN ADMIN AND PROVIDES THEM WITH AN ACCESS TOKEN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            "admin_surname" => "bail|required|max:55",
            "admin_firstname" => "bail|required|max:55",
            "admin_othernames" => "bail|max:55",
            "admin_phone_number" => "bail|required|regex:/(0)[0-9]{9}/|min:10|max:10",
            "admin_email" => "bail|email|required|max:100",
            "admin_pin" => "bail|required|confirmed|min:4|max:8",
            "password" => "bail|required|confirmed|min:8|max:30",
            "admin_scope" => "bail|required"
        ]);

        $validatedData["admin_pin"] = Hash::make($request->admin_pin);
        $validatedData["password"] = bcrypt($request->password);
        $validatedData["admin_flagged"] = false;

        $administrator = Administrator::create($validatedData);

        $accessToken = $administrator->createToken("authToken", [$validatedData["admin_scope"]])->accessToken;

        return response(["administrator" => $administrator, "access_token" => $accessToken]);
    }


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION PROVIDES A REGISTERED ADMIN WITH AN ACCESS TOKEN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    
    public function login(Request $request)
    {
        $log_controller = new LogController();
        $passcode_controller = new PasscodeController();

        $login_data = $request->validate([
            "admin_phone_number" => "required|regex:/(0)[0-9]{9}/",
            "password" => "required"
        ]);

        if (!auth()->attempt($login_data)) {
            $log_controller->save_log("administrator", $request->admin_phone_number, "Login Admin", "1st-layer login failed");
            return response(["status" => "fail", "message" => "Invalid Credentials"]);
        }

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", $request->admin_phone_number, "Login Admin", "1st-layer login failed because admin is flagged");
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        $accessToken = auth()->user()->createToken("authToken", [auth()->user()->admin_scope])->accessToken;

        $log_controller->save_log("administrator", $request->admin_phone_number, "Login Admin", "1st-layer login successful");

        $passcode = $passcode_controller->generate_passcode();

        $email_data = array(
            'pass_code' => $passcode,
            'time' => date("F j, Y, g:i a")
        );

        $passcode_controller->save_passcode("administrator", auth()->user()->admin_id, strval($passcode));

        Mail::to(auth()->user()->admin_email)->send(new PassCodeMail($email_data));
        $log_controller->save_log("administrator", $request->admin_phone_number, "Login Admin", "Passcode sent for verification");

        return response([
            "status" => "success",
            "admin_firstname" => auth()->user()->admin_firstname,
            "admin_surname" => auth()->user()->admin_surname,
            "access_token" => $accessToken
        ]);
    }

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION REVOKES AN ADMIN'S ACCESS TOKEN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    public function logout(Request $request)
    {
        if (!Auth::guard('api')->check()) {
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

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Login Admin", "Resend passcode failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        $passcode = Passcode::where([
            'user_id' => auth()->user()->admin_id,
            'user_type' => "administrator",
            'used' => false
        ])
            ->orderBy('passcode_id', 'desc')
            ->take(1)
            ->get();

        if (isset($passcode[0]["user_id"]) && $passcode[0]["user_id"] == auth()->user()->admin_id) {
            Mail::to(auth()->user()->admin_email)->send(new PassCodeMail(['pass_code' => $passcode[0]["passcode"], 'time' => date("F j, Y, g:i a")]));
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Login Admin", "Passcode re-sent for verification");
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

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Login Admin", "Passcode verification failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        $request->validate([
            "passcode" => "bail|required|max:5"
        ]);

        $passcode = Passcode::where([
            'user_id' => auth()->user()->admin_id,
            'user_type' => "administrator",
            'passcode' => $request->passcode,
            'used' => false
        ])
            ->orderBy('passcode_id', 'desc')
            ->take(1)
            ->get();


        if (isset($passcode[0]["user_id"]) && $passcode[0]["user_id"] == auth()->user()->admin_id) {
            $passcode_controller->update_passcode($passcode[0]["passcode_id"], $passcode[0]["user_type"], $passcode[0]["user_id"], $passcode[0]["passcode"], true);
            return response(["status" => "success", "message" => "Verification successful"]);
        } else {
            return response(["status" => "fail", "message" => "Verification failed. Try with the correct passcode and if this continues, restart login."]);
        }
    }



/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION ADD A NEW CURRENCY TO THE DATABASE
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    public function add_currency(Request $request)
    {
        $log_controller = new LogController();
        $currency_controller = new CurrencyController();

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        $request->validate([
            "currency_full_name" => "bail|required|max:100",
            "currency_abbreviation" => "bail|required|max:3",
            "currency_symbol" => "bail|required|max:20",
            "admin_pin" => "bail|required|min:4|max:8",
        ]);

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Addition failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        if (!Hash::check($request->admin_pin, auth()->user()->admin_pin)) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Addition failed because of incorrect pin");
            return response(["status" => "fail", "message" => "Incorrect pin."]);
        }

        if (Currency::where('currency_abbreviation', '=', $request->currency_abbreviation)->exists()) {
            return response(["status" => "fail", "message" => "Currency already exists. Try editing it instead"]);
        } else {
            $currency_controller->add_currency($request->currency_full_name, $request->currency_abbreviation, $request->currency_symbol, auth()->user()->admin_id);
            return response(["status" => "success", "message" => "Currency added successfully"]);
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

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Fetching all currencies failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        $currencies =  $currency_controller->get_all_currencies();

        return response(["status" => "success", "message" => "Operation successful", "data" => $currencies]);
    }

    public function get_one_currency(Request $request)
    {

        $log_controller = new LogController();
        $currency_controller = new CurrencyController();

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        $request->validate([
            "currency_id" => "bail|required|integer",
        ]);

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Addition failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        $this_currency = $currency_controller->get_one_currency("currency_id", $request->currency_id);
        return response(["status" => "success", "message" => "Operation successful", "data" => $this_currency]);
            
    }

    /*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| THIS FUNCTION ADD A NEW CURRENCY TO THE DATABASE
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
*/
    public function edit_currency(Request $request)
    {
        $log_controller = new LogController();
        $currency_controller = new CurrencyController();

        if (!Auth::guard('api')->check()) {
            return response(["status" => "fail", "message" => "Permission Denied. Please log out and login again"]);
        }

        $request->validate([
            "currency_id" => "bail|required|integer",
            "currency_full_name" => "bail|required|max:100",
            "currency_abbreviation" => "bail|required|max:3",
            "currency_symbol" => "bail|required|max:20",
            "currency_flagged" => "bail|required|integer|max:1",
            "admin_pin" => "bail|required|min:4|max:8",
        ]);

        if (auth()->user()->admin_flagged) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Currency editing failed because admin is flagged");
            $request->user()->token()->revoke();
            return response(["status" => "fail", "message" => "Account access restricted"]);
        }

        if (!Hash::check($request->admin_pin, auth()->user()->admin_pin)) {
            $log_controller->save_log("administrator", auth()->user()->admin_id, "Currencies Admin", "Currency editing failed because of incorrect pin");
            return response(["status" => "fail", "message" => "Incorrect pin."]);
        }

        if (Currency::where('currency_id', '=', $request->currency_id)->exists()) {
            $currency_controller->update_currency($request->currency_id, $request->currency_full_name, $request->currency_abbreviation, $request->currency_symbol, $request->currency_flagged, auth()->user()->admin_id);
            return response(["status" => "success", "message" => "Currency updated successfully"]);
        } else {
            return response(["status" => "fail", "message" => "Currency does not exists."]);
        }
    }


}
