<?php

namespace App\Http\Controllers;

use App\Models\Configurationpointage;
use Illuminate\Http\Request;

class ConfigurationPointageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $configurations = Configurationpointage::query() 
        ->get(); 

        return view('admin.ConfigurationPointage',compact('configurations')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateConfigurationPointage(Request $request, $id)
    {
        //
        $request->validate([
            "lantitudeSociete"=>'required', 
            "longitudeSociete"=>'required', 
            "distanceInKM"=>'required', 
            "temps_denvoi"=>'required', 
            "etat"=>'required', 
        ]); 

        try{
            $data = Configurationpointage::findOrFail($id);
            $data->lantitudeSociete = $request->lantitudeSociete ; 
            $data->longitudeSociete = $request->longitudeSociete ; 
            $data->distanceInKM = $request->distanceInKM ; 
            $data->temps_denvoi = $request->temps_denvoi ; 
            $data->etat = $request->etat ;  
            $data->save(); 
            session()->flash("flash_message","Modifié avec succes") ;
            return back(); 
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Modification impossible ! ") ;
            return back(); 
        }
    }



}
