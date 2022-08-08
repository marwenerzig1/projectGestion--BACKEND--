<?php

namespace App\Http\Controllers;
use App\Models\Days;
use App\Models\Pointage;
use App\Models\Historique;
Use \Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointageAPIController extends Controller
{

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function StartDayAPI(Request $request)
    {
        // request : id_employe , longitude , latitude 
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $verif = Pointage::query()
        ->where('id_employe','LIKE',$request->id_employe)
        ->where('date','LIKE', $date->format('Y-m-d') )
        ->get(); 

        if (!$verif->isEmpty()){
            return response([["message" => "Déjà pointé  !" , "code" => "401" ]],401);
        }
         
        $day = $date->dayOfWeek ; 
        $days = Days::findOrFail($day);

        if ( ($days->date_debut == "00:00:00") && ($days->date_fin == "00:00:00") ){
            return response([["message" => "Pointage Impossible ?!" , "code" => "401" ]],401);
        }

        $date1 = strtotime($days->date_debut);
        $date2 = strtotime($days->date_fin);
        $date3 = strtotime($date->format('H:i:s'));

        if (!(($date3 >= $date1) && ($date3 < $date2))){
            return response([["message" => "Pointage Impossible ?!" , "code" => "401" ]],401);
        }


        $data = new Pointage() ; 
        $data->id_employe = $request->id_employe ; 
        $data->date = $date->format('Y-m-d') ; 
        $data->temps_dentree = $date->format('H:i:s') ; 
        $data->break_heures = $days->break_houres ;
        $data->regular_heures = $days->regular_houres ; 
        $result = $data->save() ; 

        if($result){

            $localisation = new Historique() ; 
            $localisation->id_pointage = $data->id ; 
            $localisation->latitude = $request->latitude ; 
            $localisation->longitude = $request->longitude ; 
            $localisation->etat = 0 ; 
            $localisation->temps = $date->format('H:i:s') ; 
            $localisation->save() ; 

            return response([["message" => "Pointage avec succès!", "id_pointage"=>$data->id , "code" => "201" ]],201);
        } 
        else{
            return response([["message" => "not Adedd !" , "code" => "401" ]],401);
        }
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function MilieuDayAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        try{
            $localisation = new Historique() ; 
            $localisation->id_pointage = $request->id_pointage ; 
            $localisation->latitude = $request->latitude ; 
            $localisation->longitude = $request->longitude ; 
            $localisation->etat = 1 ; 
            $localisation->temps = $date->format('H:i:s') ; 
            $localisation->save() ; 

            return response([["message" => "localisation envoyes avec succes!","code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => $e , "code" => "401" ]],401);
        }
        
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function FinDayAPI(Request $request)
    {
       
        // request : id(id_pointage) , 

        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $data = Pointage::findOrFail($request->id_pointage); 

                //calcule date (totale_heures)
                $date1 = strtotime($data->temps_dentree);
                $date2 = strtotime($date->format('H:i:s'));
                if($date2 > $date1){
                    $result1 = date('H:i:s',$date2-$date1) ;
                }
                else{
                    $result1 = "00:00:00" ;
                }
                //fin  
                //calcule date (net_heures)
                $date1 = strtotime($data->break_heures);
                $date2 = strtotime($result1);
                if($date2 > $date1){
                    $result2 = date('H:i:s',$date2-$date1) ;
                }
                else{
                    $result2 = "00:00:00" ;
                }
                //fin  
                //calcule date (overtime)
                $date1 = strtotime($data->regular_heures);
                $date2 = strtotime($result2);
                if($date2 > $date1){
                    $result3 = date('H:i:s',$date2-$date1) ;
                }
                else{
                    $result3 = "00:00:00" ;
                }
                //fin  
        
        $data->date_de_sortie = $date->format('H:i:s') ; 
        $data->totale_heures = $result1 ; 
        $data->net_heures = $result2 ; 
        $data->overtime = $result3 ; 
        $resultt=$data->save() ; 

        if($resultt){

            $localisation = new Historique() ; 
            $localisation->id_pointage = $request->id_pointage ; 
            $localisation->latitude = $request->latitude ; 
            $localisation->longitude = $request->longitude ; 
            $localisation->etat = 2 ; 
            $localisation->temps = $date->format('H:i:s') ; 
            $localisation->save() ; 

            return response([["message" => "Fin de journée!" , "code" => "201" ]],201);
        } 
        else{
            return response([["message" => "not Adedd !" , "code" => "401" ]],401);
        }
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function getPointageAPI(Request $request)
    {
        $pointages = Pointage::query()
        ->where('id_employe', 'LIKE', $request->id_employe)
        ->orderBy('id', 'desc')
        ->get();

        if(!$pointages->isEmpty()){
            return response($pointages,201);
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
    public function getALLPointageAPI()
    {
        $pointages = DB::table('pointage')
        ->join('employe','pointage.id_employe','=','employe.id')
        ->select('employe.id AS idd','employe.nom','employe.prenom','pointage.*')
        ->orderBy('id', 'desc')
        ->get() ;

        if(!$pointages->isEmpty()){
            return response($pointages,201);
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
    public function AddAbsenceAPI(Request $request)
    {
        // request date , request id_employe 

        $pointages = Pointage::query()
        ->where('id_employe', 'LIKE', $request->id_employe)
        ->where('date', 'LIKE', $request->date)
        ->get();

        if(!$pointages->isEmpty()){
            return response([["message" => "Date not valid !" , "code" => "401" ]],401);
        }
        else{
            $date = Carbon::now();
            $date->timezone('Africa/Tunis');
    
            $currentDate = date('Y-m-d', strtotime($date->format('Y-m-d')));   
            $date = date('Y-m-d', strtotime($request->date));
    
            if($date > $currentDate){
                $data = new Pointage() ; 
                $data->id_employe = $request->id_employe ; 
                $data->date = $request->date ; 
                $data->temps_dentree = "00:00:00" ; 
                $data->date_de_sortie = "00:00:00" ; 
                $data->totale_heures = "00:00:00" ; 
                $data->break_heures = "00:00:00" ;
                $data->net_heures = "00:00:00" ;
                $data->regular_heures = "00:00:00" ; 
                $data->overtime = "00:00:00" ; 
                $result = $data->save() ; 
        
                if($result){
                    return response([["message" => "Add Absence avec succès!" , "code" => "201" ]],201);
                } 
                else{
                    return response([["message" => "Absence not Adedd !" , "code" => "401" ]],401);
                }
            }
            else{
                return response([["message" => "Date not valid !" , "code" => "401" ]],401);
            }
        }
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function GetAbsenceAPI(Request $request)
    {
        // request id_employe 
        $pointages = Pointage::query()
        ->where('id_employe', 'LIKE', $request->id_employe)
        ->where('net_heures', 'LIKE', "00:00:00")
        ->orderBy('id', 'desc')
        ->get();

        if(!$pointages->isEmpty()){
            return response($pointages,201);
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
    public function DeleteAbsenceAPI(Request $request)
    {
        // request id_employe 
        try{
            $data = Pointage::find($request->id_pointage); 
            $data->delete(); 
            return response([["message" => "Deleted valid!" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Deleted not valid!" , "code" => "401" ]],401);
        }
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function getLocationAPI(Request $request)
    {
        $locations = Historique::query()
        ->where('id_pointage', 'LIKE', $request->id_pointage)
        ->get();

        if(!$locations->isEmpty()){
            return response($locations,201);
        }
        else{
            return response([],401);
        }
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function BreakAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $date1 = strtotime($request->break_entre);
        $date2 = strtotime($request->break_fin);
        $result = date('H:i:s',$date2-$date1) ;

      //  return response([["message" => $result , "code" => "201" ]],201);

        try{
            $data = Pointage::findOrFail($request->id_pointage); 
            $data->break_heures = $result ; 
            $data->save();
            return response([["message" => "Fin pause !" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "not Adedd !" , "code" => "401" ]],401);
        }
    }

}
