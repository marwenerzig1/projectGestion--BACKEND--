<?php

namespace App\Http\Controllers;

use App\Models\Days;
use Illuminate\Http\Request;

class DaysController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $days = Days::query() 
        ->get(); 

        return view('admin.Configuration',compact('days')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDays(Request $request, $id)
    {
        //
        $request->validate([
            "date_debut"=>'required', 
            "date_fin"=>'required', 
            "break_houres"=>'required', 
            "date_finale"=>'required', 
            "etat"=>'required', 
        ]); 

        $date1 = strtotime($request->date_debut);
        $date2 = strtotime($request->date_fin);
        if($date2 < $date1){
            session()->flash("flash_erreur","Time de sortie incorrect !") ;
            return back(); 
        }


            try{
                $data = Days::findOrFail($id);
                if($request->etat == 0){
                    $data->date_debut = $request->date_debut ; 
                    $data->date_fin = $request->date_fin ; 
                    $data->break_houres = $request->break_houres ; 
                    $data->date_finale = $request->date_finale ; 
                    $data->regular_houres = date('H:i:s',$date2-$date1) ; 
                    $data->etat = $request->etat ;            
                }
                else{
                    $data->date_debut = "00:00:00" ; 
                    $data->date_fin = "00:00:00" ; 
                    $data->break_houres = "00:00:00" ; 
                    $data->date_finale = "00:00:00" ; 
                    $data->regular_houres = "00:00:00" ; 
                    $data->etat = $request->etat ;  
                }

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
