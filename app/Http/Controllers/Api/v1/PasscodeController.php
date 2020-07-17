<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Passcode;

class PasscodeController extends Controller
{
    public function generate_passcode()
    {
        return rand(10000,99999);
    }

    public function save_passcode($user_type, $user_id, $thispasscode)
    {
        $passcode = new Passcode();
        $passcode->user_type = $user_type; 
        $passcode->user_id = $user_id;
        $passcode->passcode = $thispasscode;
        $passcode->used = false;
        $passcode->save();

    }

    public function update_passcode($thispasscode_id, $user_type, $user_id, $thispasscode, $used_status){
        $passcode = new Passcode();
        $passcode->passcode_id = $thispasscode_id; 
        $passcode->user_type = $user_type; 
        $passcode->user_id = $user_id;
        $passcode->passcode = $thispasscode;
        $passcode->used = $used_status;
        $passcode->save();
    }

    //public function get_user_recent_passcode()
}
