<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\v1\Worker;

class WorkerController extends Controller
{
    
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
