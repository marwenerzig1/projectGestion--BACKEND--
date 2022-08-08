<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationAPIController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendTokenAPI(Request $request)
    {
        //
        $notification = Notification::query()
        ->where('token', 'LIKE', $request->token )
        ->first();

        if($notification){
            try{
                $data = Notification::findOrFail($notification->id);   
                $data->token = $request->token ; 
                $data->role = $request->role ; 
                $data->save() ; 
                return response([["message" => "badaltha" , "code" => "201" ]],201);
            }
            catch(\Illuminate\Database\QueryException $e){
                return response([["message" => "error" , "code" => "401" ]],201);
            } 
        }
        else {
            try{
                $data = new Notification() ; 
                $data->token = $request->token ; 
                $data->role = $request->role ; 
                $data->save(); 
                return response([["message" => "ok" , "code" => "201" ]],201); 
            }
            catch(\Illuminate\Database\QueryException $e){
                return response([["message" => "error" , "code" => "201" ]],201);
            } 
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTokenCongeAPI()
    {
        //
                $notification = Notification::query()
                ->where('role','<>', 2 )
                ->get("token");

                return response($notification,201);


    }
    
}
