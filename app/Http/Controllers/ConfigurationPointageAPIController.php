<?php

namespace App\Http\Controllers;

use App\Models\Configurationpointage;
use Illuminate\Http\Request;

class ConfigurationPointageAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConfigurationPointageAPI()
    {
        //
        $configurationPointage = Configurationpointage::query()
        ->get(); 

        if(!$configurationPointage->isEmpty()){
            return response($configurationPointage,201);
        }
        else{
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierConfigurationPointageAPI(Request $request)
    {
        //
        try{
            $data = Configurationpointage::findOrFail($request->id);
            $data->lantitudeSociete = $request->lantitudeSociete ; 
            $data->longitudeSociete = $request->longitudeSociete ; 
            $data->distanceInKM = $request->distanceInKM ; 
            $data->temps_denvoi = $request->temps_denvoi ; 
            if($request->etat == false ){
                $data->etat = 0 ;  
            }else{
                $data->etat = 1 ;
            }
            $data->save(); 
            return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "forme inccorect !" , "code" => "401" ]],401);
        }
    }


}
