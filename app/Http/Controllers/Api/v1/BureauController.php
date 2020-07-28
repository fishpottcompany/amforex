<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Bureau;
use Illuminate\Http\Request;

class BureauController extends Controller
{
    public function save_bureau($bureau_name, $bureau_hq_gps_address, $bureau_hq_location, $bureau_tin, $bureau_license_no, $bureau_registration_num, $bureau_phone_1, $bureau_phone_2, $bureau_email_1, $bureau_email_2, $bureau_flagged, $admin_id)
    {
        $bureau = new Bureau();
        $bureau->bureau_name = $bureau_name; 
        $bureau->bureau_hq_gps_address = $bureau_hq_gps_address; 
        $bureau->bureau_hq_location = $bureau_hq_location;
        $bureau->bureau_tin = $bureau_tin;
        $bureau->bureau_license_no = $bureau_license_no;
        $bureau->bureau_registration_num = $bureau_registration_num;
        $bureau->bureau_phone_1 = $bureau_phone_1;
        $bureau->bureau_phone_2 = $bureau_phone_2;
        $bureau->bureau_email_1 = $bureau_email_1;
        $bureau->bureau_email_2 = $bureau_email_2;
        $bureau->bureau_flagged = $bureau_flagged;
        $bureau->admin_id = $admin_id;
        $bureau->save();
        return $bureau;
    }


    public function update_bureau($bureau_id, $bureau_name, $bureau_hq_gps_address, $bureau_hq_location, $bureau_tin, $bureau_license_no, $bureau_registration_num, $bureau_phone_1, $bureau_phone_2, $bureau_email_1, $bureau_email_2, $bureau_flagged, $admin_id)
    {
        $bureau = Bureau::find($bureau_id);
        $bureau->bureau_name = $bureau_name; 
        $bureau->bureau_hq_gps_address = $bureau_hq_gps_address; 
        $bureau->bureau_hq_location = $bureau_hq_location;
        $bureau->bureau_tin = $bureau_tin;
        $bureau->bureau_license_no = $bureau_license_no;
        $bureau->bureau_registration_num = $bureau_registration_num;
        $bureau->bureau_phone_1 = $bureau_phone_1;
        $bureau->bureau_phone_2 = $bureau_phone_2;
        $bureau->bureau_email_1 = $bureau_email_1;
        $bureau->bureau_email_2 = $bureau_email_2;
        $bureau->bureau_flagged = $bureau_flagged;
        $bureau->admin_id = $admin_id;
        $bureau->save();
        return $bureau;
    }
}
