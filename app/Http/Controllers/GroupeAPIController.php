<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Groupe;
use App\Models\Membre;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class GroupeAPIController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getgroupeResponsableAPI(Request $request)
    {
        //
        $groupes = Groupe::query()
        ->where('id_responsable','LIKE',$request->id)
        ->get();

        $counte = Groupe::query()
        ->where('id_responsable','LIKE',$request->id)
        ->count();

        if($counte != 0 ){
            return response($groupes, 201); 
        }
        else{
            return response()->json(["message" => "Il n'y a aucun groupe ! "], 404);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AjouterGroupeAPI(Request $request)
    {
        //
        try{
            $data = new Groupe() ;
            $data->id_responsable = $request->id_responsable ;
            $data->nom_projet = $request->nom_projet ;
            $data->description = $request->description ;
            $data->save() ; 
            return response([["message" => "Successfully Added!" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Not Adedd, Try Again!" , "code" => "401" ]],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllgroupeAPI()
    {
        //
        /* $groupes = Groupe::query()
        ->get();  */

        $groupes = FacadesDB::table('groupe')
            ->join('employe', 'groupe.id_responsable', '=', 'employe.id')
            ->select('groupe.*', 'employe.nom' , 'employe.prenom')
            ->get();
        if($groupes != null){
            return response($groupes, 201);
        }
        else{
            return response(["message" => "il n y a aucun groupe !" ],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteGroupeAPI(Request $request)
    {
        //
        try {
            $result = FacadesDB::table('groupe')->where('id_groupe',$request->id_groupe)->delete();
            if ($result) {
                return response(["message" => "Successfully Deleted!" ],201);
            } 
        } catch(\Exception $exception){
            return response(["message" => "Not Deleted, Try Again!" ],401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ModifierGroupeAPI(Request $request)
    {
        //
            $result = FacadesDB::table('groupe')
            ->where('id_groupe',$request->id_groupe)
            ->update(array('nom_projet' => $request->nom_projet , 'description' => $request->description ));
        try {
            if ($result) {
                return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
            } 
        } catch(\Exception $exception){
            return response([["message" => "Not Updated, Try Again!","code" => "201"]],401);
        }
        return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMembregroupeAPI(Request $request)
    {
        //
        $membres = FacadesDB::table('membre')
        ->where('id_groupe','LIKE',$request->id_groupe)
        ->join('employe', 'membre.id_employe', '=', 'employe.id')
        ->select('employe.*', 'membre.*' )
        ->get();

       // return ($membres) ; 

        if($membres != [] ){
            return response($membres, 201);
        }
        else{
            return response(["message" => "il n y a aucun groupe !" ],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getgroupeMembreAPI(Request $request)
    {
        //
        $membres = FacadesDB::table('membre')
        ->where('id_employe','LIKE',$request->id)
        ->join('groupe', 'membre.id_groupe', '=', 'groupe.id_groupe')
        ->join('employe', 'groupe.id_responsable', '=', 'employe.id')
        ->select('groupe.*' , 'employe.nom' ,'employe.prenom')
        ->get();

       // return ($membres) ; 

        if($membres != [] ){
            return response($membres, 201);
        }
        else{
            return response(["message" => "il n y a aucun groupe !" ],401);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteMembreAPI(Request $request)
    {
        //
        try {
            $result = FacadesDB::table('membre')->where('id_employe',$request->id_employe)->delete();
            if ($result) {
                return response(["message" => "Successfully Deleted!" ],201);
            } 
        } catch(\Exception $exception){
            return response(["message" => "Not Deleted, Try Again!" ],401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMembreAPI(Request $request)
    {
        //

        $membres_existe = Membre::query() 
        ->where('id_groupe' , '=' , $request->id_groupe) 
        ->get() ; 

        $mem = [] ; 

        foreach($membres_existe as $existe){
            array_push($mem, $existe->id_employe);
        }

        $membres = Employe::query()
        ->where('employe.id' , '<>' , $request->id_responsable )
        ->where('employe.etat' , '<>' , 3 )
        ->whereNotIn('employe.id' , $mem )
        ->get();

        if($membres == []){
            return response(["message" => "Il n'y a aucun responsable ! " ],401); 
        }
        else{
            return $membres ; 
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AjouterMembreAPI(Request $request)
    {
        //
        try{
            $data = new Membre() ;
            $data->id_employe = $request->id_employe;
            $data->id_groupe = $request->id_groupe ;
            $data->save() ; 
            return response([["message" => "Successfully Added!" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Not Adedd, Try Again!" , "code" => "401" ]],401);
        }
    }


}
