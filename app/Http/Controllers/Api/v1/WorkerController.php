<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Worker;
use App\Models\v1\Passcode;
use Illuminate\Http\Request;
use App\Mail\bureau\PassCodeMail;
use App\Http\Controllers\Controller;
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
    $tokenResult = $worker->createToken("authToken");
    //$accessToken = auth()->user()->createToken("authToken", [$worker->worker_scope])->accessToken;
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
| THIS FUNCTION REVOKES AN ADMIN'S ACCESS TOKEN
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
        $log_controller->save_log("worker", auth()->user()->worker_id, "Login Admin", "Resend passcode failed because worker is flagged");
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
        $log_controller->save_log("worker", auth()->user()->worker_id, "Login Admin", "Passcode verification failed because worker is flagged");
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
