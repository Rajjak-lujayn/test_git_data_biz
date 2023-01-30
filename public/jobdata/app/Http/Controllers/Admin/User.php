<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register_User;
use App\Models\Tracking;


class User extends Controller
{
    // Sending users on page load on admin and on filter
    public function getAll(Request $request){

        $params = $request->all();

        $userEmail = isset($params['userEmail']);
        $userVarified = isset($params['userVarified']);

        // $users = Register_User::paginate($params['perPage']);

        if($userEmail && $userVarified){
            $users = Register_User::where([["email", "LIKE", "%".$params['userEmail']."%"], ["varified", $params['userVarified']]])->join('record_download_count', 'register_users.id', '=', 'record_download_count.id')
            ->paginate($params['perPage']);

            return response()->json($users, 200); 
        }

        if($userEmail){
            // dd($userEmail);
            $users = Register_User::where("email", "LIKE", "%".$params['userEmail']."%")->join('record_download_count', 'register_users.id', '=', 'record_download_count.id')
                ->paginate($params['perPage']);

            return response()->json($users, 200);    
        }

        if($userVarified){
            // dd($userEmail);
            $users = Register_User::where("varified", $params['userVarified'])->join('record_download_count', 'register_users.id', '=', 'record_download_count.id')
                ->paginate($params['perPage']);

            return response()->json($users, 200);    
        }
        
        $users = Register_User::join('record_download_count', 'register_users.id', '=', 'record_download_count.id')
                ->paginate($params['perPage']);

        return response()->json($users, 200);
    }

    // Return live user table after made changes by admin on user table
    public function getRemainingUsers(){

        return Register_User::join('record_download_count', 'register_users.id', '=', 'record_download_count.id')
        ->paginate(10);
    }


    // Action which are taken by admin on user table
    public function actions(Request $request){

        $params = $request->all();
        $actions = $params['action'];
        
        if($actions == 'delete'){
            Register_User::destroy($params['userId']);
            $users = $this->getRemainingUsers();
            return response()->json($users, 200);
        }elseif($actions == 'varifiedYes'){
            Register_User::find($params['userId'])->update(["varified" => 1]);
            $users = $this->getRemainingUsers();
            return response()->json($users, 200);        
        }elseif($actions == 'varifiedNo'){
            Register_User::find($params['userId'])->update(["varified" => 0]);
            $users = $this->getRemainingUsers();
            return response()->json($users, 200);         
        }
    }
    public function getTracking(Request $request){
        
        $params = $request->all();
        $users = Tracking::paginate($params['perPage']);
        return response()->json($users, 200);
    }
}
