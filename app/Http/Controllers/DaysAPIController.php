<?php

namespace App\Http\Controllers;

use App\Models\Conges;
use Illuminate\Http\Request;
use App\Models\Days;
use App\Models\Employe;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DaysAPIController extends Controller
{


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ModifierDayAPI(Request $request)
    {


        //calcule date
        $date1 = strtotime($request->date_debut);
        $date2 = strtotime($request->date_fin);
        if($date2 > $date1){
            $regular_houres = date('H:i:s',$date2-$date1) ;
        }
        else{
            $regular_houres = "00:00:00" ;
        }
        //fin  


        $data = Days::findOrFail($request->id);
        $data->date_debut = $request->date_debut ; 
        $data->date_fin = $request->date_fin ; 
        $data->break_houres = $request->break_houres ; 
        $data->regular_houres = $regular_houres ; 
        $data->date_finale = $request->date_finale ; 
        $data->etat = $request->etat ;    
        $result = $data->save() ; 

        if($result){
            return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
        } 
        else{
            return response([["message" => "not Updated !" , "code" => "401" ]],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gethoraireAPI()
    {         
        $days = Days::query()
        ->get(); 

        if(!$days->isEmpty()){
            return response($days,201);
        }
        else{
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getsoldeAPI(Request $request)
    {    
        $solde = Employe::query()
        ->where( "id" , "=" , $request->id_employe )
        ->select("solde_conge","salaire")
        ->get(); 

        if(!$solde->isEmpty()){
            return response($solde,201);
        }
        else{
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }


}
