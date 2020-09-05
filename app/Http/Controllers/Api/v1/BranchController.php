<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\v1\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{

    public function make_branch_ext_id($branch_gps_location, $bureau_tin, $branch_phone_1)
    {
        return $branch_gps_location . "_" . $bureau_tin . "_" . $branch_phone_1;
    }

    public function save_branch($branch_name, $bureau_tin, $branch_gps_location, $branch_address, $branch_phone_1, $branch_phone_2, $branch_email_1, $branch_email_2, $creator_user_type, $creator_id, $branch_flagged,  $branch_was_first, $bureau_id)
    {
        $branch = new Branch();
        $branch->branch_ext_id = $this->make_branch_ext_id($branch_gps_location, $bureau_tin, $branch_phone_1); 
        $branch->branch_name = $branch_name; 
        $branch->branch_gps_location = $branch_gps_location; 
        $branch->branch_address = $branch_address;
        $branch->branch_phone_1 = $branch_phone_1;
        $branch->branch_phone_2 = $branch_phone_2;
        $branch->branch_email_1 = $branch_email_1;
        $branch->branch_email_2 = $branch_email_2;
        $branch->branch_was_first = $branch_was_first;
        $branch->branch_flagged = $branch_flagged;
        $branch->creator_user_type = $creator_user_type;
        $branch->creator_id = $creator_id;
        $branch->bureau_id = $bureau_id;
        $branch->save();
        return $branch;
    }

    public function update_branch($branch_id, $branch_gps_location, $branch_address, $branch_phone_1, $branch_phone_2, $branch_email_1, $branch_email_2, $creator_user_type, $creator_id, $branch_flagged, $bureau_id)
    {
        $branch = Branch::find($branch_id);
        $branch->branch_gps_location = $branch_gps_location; 
        $branch->branch_address = $branch_address;
        $branch->branch_phone_1 = $branch_phone_1;
        $branch->branch_phone_2 = $branch_phone_2;
        $branch->branch_email_1 = $branch_email_1;
        $branch->branch_email_2 = $branch_email_2;
        $branch->branch_flagged = $branch_flagged;
        $branch->creator_user_type = $creator_user_type;
        $branch->creator_id = $creator_id;
        $branch->bureau_id = $bureau_id;
        $branch->save();
        return $branch;
    }


    public function get_all_branches($where_array)
    {
        return DB::table('branches')
            ->select('branches.*')
            ->where($where_array)
            ->get();
    }
}
