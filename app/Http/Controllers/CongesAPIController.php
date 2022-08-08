<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Conges;
use App\Models\Membre;
use App\Models\Traitement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class CongesAPIController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AjouterDemanderCongeAPI(Request $request)
    {

        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $debut = strtotime($request->date_debut) ;   
        $fin = strtotime($request->date_fin) ;

        $dif = ceil(abs($fin - $debut) / 86400);

        $data = Employe::find($request->id_employe); 
        if($dif > $data->solde_conge){
            return response([["message" => "Desole ! votre solde conge est insuffisant !" , "code" => "402" ]],402); 
        }
        else{
            $data->solde_conge = $data->solde_conge - $dif ; 
            $data->save() ; 
        }

        try{
            $data = new Conges() ; 
            $data->id_employe=$request->id_employe ;
            $data->date_debut=$request->date_debut ;
            $data->date_fin=$request->date_fin ;
            $data->nombre_jours=$dif ;
            $data->cause=$request->cause ;
            $data->date_demande= $date ;
            $data->save() ;  
            return response([["message" => "Ajoute Congé avec succes !" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "not Adedd !" , "code" => "401" ]],401); 
        }   
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCongesEmployeAPI(Request $request)
    {
        $conges = Conges::query()
        ->where('id_employe', '=' , $request->id_employe)
        ->orderBy('id', 'desc')
        ->get(); 

        if(!$conges->isEmpty()){
            return response($conges,201);
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
    public function getCongesAPI(Request $request)
    {
        $conges = FacadesDB::table('groupe')
        ->where('groupe.id_responsable','=',$request->id_employe)
        ->join('membre', 'groupe.id_groupe', '=', 'membre.id_groupe')
        ->join('employe','membre.id_employe', '=' , 'employe.id')
        ->join('conges','employe.id', '=' , 'conges.id_employe')
        ->distinct()
        ->select('employe.nom' , 'employe.prenom','conges.*')
        ->get();

        if(!$conges->isEmpty()){
            return response($conges,201);
        }
        else{
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCongesAPI()
    {
        $conges = FacadesDB::table('conges')
        ->join('employe','conges.id_employe', '=' , 'employe.id')
        ->select('employe.nom' , 'employe.prenom','employe.etat AS etat_employe','conges.*')
        ->orderBy('id', 'desc')
        ->get();

        if(!$conges->isEmpty()){
            return response($conges,201);
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
    public function DeleteCongeAPI(Request $request)
    {
        $data = Conges::find($request->id_conge); 

        $dataa = Employe::find($request->id_employe); 
        $dataa->solde_conge = $dataa->solde_conge + $data->nombre_jours ; 
        $dataa->save() ; 

        try{
            $data->delete(); 
            return response([["message" => "Deleted valid!" , "code" => "201" ]],201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Deleted not valid!" , "code" => "401" ]],401);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AccepterCongesResponsableAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        try{
            $data = Conges::find($request->id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
                $traitement = Traitement::query()
                ->where('id_conge','=', $request->id_conge )
                ->where('id_responsable','=', $request->id_responsable )
                ->get();
                if(!$traitement->isEmpty()){
                    if($traitement[0]['etat'] == 0){
                    return response([["message" => "Congé deja accepté !" , "code" => "401" ]],401);
                    }
                    else{
                        $result = FacadesDB::table('traitement')
                        ->where('id',$traitement[0]['id'])
                        ->update(array('etat' => 0));
                        return response([["message" => "Congé Accepter avec succes !" , "code" => "201" ]],201); 
                    }
                    return response([["message" => "Congé deja accepté !" , "code" => "401" ]],401);
                }
                else{
                    $data = new Traitement() ; 
                    $data->id_conge = $request->id_conge ; 
                    $data->id_responsable  = $request->id_responsable ; 
                    $data->etat = 0 ; 
                    $data->save() ; 
                    return response([["message" => "Congé Accepter avec succes !" , "code" => "201" ]],201); 
                }
            }
            else{
                return response([["message" => "Acceptation impossible ! congé debut ou termine" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Acceptation impossible!" , "code" => "401" ]],401);
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AccepterCongesAdminAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        try{
            $data = Conges::find($request->id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
                if($data->etat != 1){
                    if($data->etat == 2 ){
                        $dataa = Employe::find($data->id_employe); 
                        if($data->nombre_jours > $dataa->solde_conge){
                            return response([["message" => "solde conge est insuffisant !" , "code" => "401" ]],401);
                        }
                        else{
                            $dataa->solde_conge = $dataa->solde_conge - $data->nombre_jours ; 
                            $dataa->save() ; 
                        }    
                    }
                $data->etat = 1 ; 
                $data->save() ;  
                return response([["message" => "Congé Accepter avec succes !" , "code" => "201" ]],201); 
            }
                else{
                    return response([["message" => "Congé deja accepté !" , "code" => "401" ]],401);
                }
            }
            else{
                return response([["message" => "Acceptation impossible ! congé debut ou termine" , "code" => "401" ]],401);
            }
        }

        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Acceptation impossible!" , "code" => "401" ]],401);
        }   
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function RefuserCongesResponsableAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        try{
            $data = Conges::find($request->id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
                $traitement = Traitement::query()
                ->where('id_conge','=', $request->id_conge )
                ->where('id_responsable','=', $request->id_responsable )
                ->get();
                if(!$traitement->isEmpty()){
                    if($traitement[0]['etat'] == 1){
                        return response([["message" => "Congé deja refusé !" , "code" => "401" ]],401);
                        }
                        else{ 
                            $result = FacadesDB::table('traitement')
                            ->where('id',$traitement[0]['id'])
                            ->update(array('etat' => 1));
                            return response([["message" => "Congé refuse avec succes !" , "code" => "201" ]],201); 
                        }
                        return response([["message" => "Congé deja refusé !" , "code" => "401" ]],401);
                }
                else{
                    $data = new Traitement() ; 
                    $data->id_conge = $request->id_conge ; 
                    $data->id_responsable  = $request->id_responsable ; 
                    $data->etat = 1 ; 
                    $data->save() ; 
                    return response([["message" => "Congé Refuser avec succes !" , "code" => "201" ]],201); 
                }
            }
            else{
                return response([["message" => "Refuse impossible ! congé debut ou termine" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Refuse impossible!" , "code" => "401" ]],401);
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function RefuserCongesAdminAPI(Request $request)
    {
        $date = Carbon::now();
        $date->timezone('Africa/Tunis'); 
        
        try{
            $data = Conges::find($request->id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
            if( $data->etat != 2 ){
            $dataa = Employe::find($data->id_employe); 
            $dataa->solde_conge = $dataa->solde_conge + $data->nombre_jours ; 
            $dataa->save() ; 
            $data->etat = 2 ; 
            $data->save() ;  
            return response([["message" => "Congé Refuser avec succes !" , "code" => "201" ]],201);
            }
            else{
                return response([["message" => "Congé deja refusé !" , "code" => "401" ]],401);
            }
            }
            else{
                return response([["message" => "Refuse impossible ! congé debut ou termine" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Refuse impossible!" , "code" => "401" ]],401);
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function TraitementCongesAPI(Request $request)
    {   
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        //get responsables des groupes  
        $responsables = DB::table('membre')
        ->where('id_employe','=',$request->id_employe)
        ->join('groupe' , 'membre.id_groupe' , '=' , 'groupe.id_groupe')
        ->join('employe' , 'groupe.id_responsable' , '=' , 'employe.id')
        ->distinct()
        ->select('employe.*')
        ->get(); 

        return response($responsables,201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function TraitementCongesACEPAPI(Request $request)
    {   
        $responsables_etat = DB::table('traitement')
        ->where('id_conge','=', $request->id_conge )
        ->join('employe','traitement.id_responsable','=','employe.id')
        ->select('employe.nom','employe.prenom','employe.id','traitement.updated_at','traitement.etat')
        ->get(); 

        return response($responsables_etat,201);
    }








    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEmployeModifierAPI(Request $request)
    {
        try{
            $data = Employe::find($request->id_employe); 
            return response($data,201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAdminModifierAPI(Request $request)
    {
        try{
            $data = Admin::find($request->id_admin); 
            return response($data,201);
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierPersonneInfoAPI(Request $request)
    {
        $admin = Admin::query()
        ->where('login', 'LIKE', "$request->login" )
        ->get(); 

        if(!$admin->empty()){
            return response([["message" => "Login existe !" , "code" => "401" ]],401);
        }
        try{
            $data = Employe::findOrFail($request->id);
            if($request->password == $data->password ){
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->cin = $request->cin ; 
                $data->telephone = $request->telephone ; 
                $data->adresse = $request->adresse ; 
                $data->date_de_naissance = $request->date_de_naissance ; 
                $data->login = $request->login ; 
                $data->password = $request->password ; 
                $data->save(); 
                return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
            }
            else{         
                return response([["message" => "Password incorrect !" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "update impossible !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierAdminInfoAPI(Request $request)
    {
        $employe = Employe::query()
        ->where('login', 'LIKE', "$request->login" )
        ->get(); 

        if(!$employe->empty()){
            return response([["message" => "Login existe !" , "code" => "401" ]],401);
        }
        try{
            $data = Admin::findOrFail($request->id);
            if($request->password == $data->password ){
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->login = $request->login ; 
                $data->password = $request->password ; 
                $data->save(); 
                return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
            }
            else{         
                return response([["message" => "Password incorrect !" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "update impossible !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierPasswordAPI(Request $request)
    {
        try{
            $data = Employe::findOrFail($request->id);   
            if($request->password == $data->password ){
                if($request->nouveau_password == $request->confirmation_password){
                    $data->password = $request->nouveau_password ; 
                    $data->save() ;  
                    return response([["message" => "Modifié avec succes!" , "code" => "201" ]],201);
                }
                else{
                    return response([["message" => "Password incorrect!" , "code" => "401" ]],401);
                }
            }
            else{ 
                return response([["message" => "Password incorrect!" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "update impossible !" , "code" => "401" ]],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierAdminPasswordAPI(Request $request)
    {
        try{
            $data = Admin::findOrFail($request->id);   
            if($request->password == $data->password ){
                if($request->nouveau_password == $request->confirmation_password){
                    $data->password = $request->nouveau_password ; 
                    $data->save() ;  
                    return response([["message" => "Modifié avec succes!" , "code" => "201" ]],201);
                }
                else{
                    return response([["message" => "Password incorrect!" , "code" => "401" ]],401);
                }
            }
            else{ 
                return response([["message" => "Password incorrect!" , "code" => "401" ]],401);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            return response([["message" => "update impossible !" , "code" => "401" ]],401);
        }
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCountEmployeAPI(Request $request)
    {
        $Conges_encours = Conges::query()
        ->where('etat', 'LIKE', 0 )
        ->where('id_employe' , 'LIKE' , $request->id_employe)
        ->count();
        $Conges_accepter = Conges::query()
        ->where('etat', 'LIKE', 1 )
        ->where('id_employe' , 'LIKE' , $request->id_employe)
        ->count();
        $Conges_refuser = Conges::query()
        ->where('etat', 'LIKE', 2 )
        ->where('id_employe' , 'LIKE' , $request->id_employe)
        ->count();

        return response()->json([["Conges_encours" => $Conges_encours , "Conges_accepter" => $Conges_accepter , "Conges_refuser" => $Conges_refuser ]], 201);
    }





}
