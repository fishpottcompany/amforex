<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Bureau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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


    public function get_all_bureaus($pagination)
    {
        
        $current_bureaus = DB::table('bureaus')
        ->join('administrators', 'bureaus.admin_id', '=', 'administrators.admin_id')
        ->join('workers', 'bureaus.bureau_id', '=', 'workers.bureau_id')
        ->select('bureaus.*', 'administrators.admin_surname', 'administrators.admin_firstname', 'workers.worker_surname', 'workers.worker_firstname', 'workers.worker_phone_number')
        ->where("workers.worker_was_first", "=", true)
        ->simplePaginate($pagination);

        return $current_bureaus;
        
    }


    public function search_for_bureaus($pagination, $where_array, $or_where_array)
    {
        
        if(count($or_where_array) > 0){
            return DB::table('bureaus')
                ->join('administrators', 'bureaus.admin_id', '=', 'administrators.admin_id')
                ->join('workers', 'bureaus.bureau_id', '=', 'workers.bureau_id')
                ->select('bureaus.*', 'administrators.admin_surname', 'administrators.admin_firstname', 'workers.worker_surname', 'workers.worker_firstname', 'workers.worker_phone_number')
                ->where($where_array)
                ->orWhere($or_where_array)
                ->simplePaginate($pagination);
    
        } else {
            return DB::table('bureaus')
            ->join('administrators', 'bureaus.admin_id', '=', 'administrators.admin_id')
            ->join('workers', 'bureaus.bureau_id', '=', 'workers.bureau_id')
            ->select('bureaus.*', 'administrators.admin_surname', 'administrators.admin_firstname', 'workers.worker_surname', 'workers.worker_firstname', 'workers.worker_phone_number')
            ->where($where_array)
            ->simplePaginate($pagination);

        }
        
    }

}
