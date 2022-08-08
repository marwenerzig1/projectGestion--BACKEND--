<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Admin;
use App\Models\Groupe;
use Illuminate\Support\Facades\Mail; 
use App\Mail\SendMessage ;
use App\Models\Conges;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeAPIController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAPI(Request $request)
    {
        //


            $employes = Employe::query()
            ->where('login' , 'LIKE' , "{$request->login}")
            ->get();  

            $admin = Admin::query()
            ->where('login' , 'LIKE' , "{$request->login}" )
            ->get(); 

        if($admin != null){
            foreach($admin as $adminn){
                if($adminn->login == $request->login){
                    if($adminn->password == $request->password){
    
                        $adminnn = Admin::where('id', $adminn->id)->get()->toJson(JSON_PRETTY_PRINT);
                        return response($adminnn, 201);    
    
                    }
                    else{
                        return response()->json(["message" => "Mot de passe incorrecte ! "], 404);
                    }
                }
                else{
                    return response()->json(["message" => "Login incorrecte ! "], 404);
                }
            }
        }
            foreach($employes as $employe){
                if($employe->login == $request->login){
                    if($employe->password == $request->password){
    
                        $employee = Employe::where('id', $employe->id)->get()->toJson(JSON_PRETTY_PRINT);
                        return response($employee, 201);    
    
                    }
                    else{
                        return response()->json(["message" => "Mot de passe incorrecte ! "], 404);
                    }
                }
                else{
                    return response()->json(["message" => "Login incorrecte ! "], 404);
                }
            }


        return response()->json(["message" => "Login incorrecte ! "], 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countAPI()
    {
        //
        $employe = Employe::query()
        ->count();
        $responsable = Employe::query()
        ->where('etat', 'LIKE', 1)
        ->count(); 
        $responsable_RH = Employe::query()
        ->where('etat', 'LIKE', 3)
        ->count(); 
        $teamleader = Groupe::query()
        ->count(); 

        
        $Conges_encours = Conges::query()
        ->where('etat', 'LIKE', 0 )
        ->count();
        $Conges_accepter = Conges::query()
        ->where('etat', 'LIKE', 1 )
        ->count();
        $Conges_refuser = Conges::query()
        ->where('etat', 'LIKE', 2 )
        ->count();

        $users = Pointage::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("month_name"))
        ->orderBy('id','ASC')
        ->pluck('count', 'month_name');

        $labels = $users->keys();
        $data = $users->values();

        return response()->json([["employe" => $employe , "responsable" => $responsable , "responsable_RH" => $responsable_RH , "team_leader" => $teamleader , "Conges_encours" => $Conges_encours , "Conges_accepter" => $Conges_accepter , "Conges_refuser" => $Conges_refuser , "labels" => $labels , "data" => $data ]], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeAPI()
    {
        //
        $users = Employe::query()
        ->get();

        if($users != null){
            return response($users, 201); 
        }
        else{
            return response(["message" => "Il n'y a aucun employe ! " ],401); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmploye2API()
    {
        //
        $users = Employe::query()
        ->where('etat','LIKE',0)
        ->get();

        if($users != null){
            return response($users, 201); 
        }
        else{
            return response(["message" => "Il n'y a aucun employe ! " ],401); 
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ModifierPersonneAPI(Request $request)
    {
            try{
                $data = Employe::findOrFail($request->id);
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->cin = $request->cin ; 
                $data->telephone = $request->telephone ; 
                $data->adresse = $request->adresse ; 
                $data->date_de_naissance = $request->date_de_naissance ; 
                $data->status = $request->status ;
                $data->solde_conge = $request->solde_conge ; 
                $data->salaire = $request->salaire ;  
                $data->etat = $request->etat ;  
                $data->login = $request->login ; 
                $data->password = $request->password ; 
                $data->save(); 
                return response([["message" => "Successfully Updated!" , "code" => "201" ]],201);
            }
            catch(\Illuminate\Database\QueryException $e){
                return response([["message" => "login ou password deja existe !" , "code" => "401" ]],401);
            }
    }  

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddUserAPI(Request $request)
    {
        if($request->password == $request->password2){
            try{
                $data = new Employe() ; 
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->cin = $request->cin ; 
                $data->telephone = $request->telephone ; 
                $data->adresse = $request->adresse ; 
                $data->date_de_naissance = $request->date_de_naissance ; 
                $data->status = $request->status ;
                $data->solde_conge = $request->solde_conge ; 
                $data->salaire = $request->salaire ;  
                $data->login = $request->login ; 
                $data->password = $request->password ; 
                $data->save(); 
                session()->put('nom_email',$request->nom);
                session()->put('prenom_email',$request->prenom);
                session()->put('login_email',$request->login);
                session()->put('password_email',$request->password);
                Mail::to($request->login)->send(new SendMessage) ; 
                return response([["message" => "Successfully Added!" , "code" => "201" ]],201);
            }
            catch(\Illuminate\Database\QueryException $e){
                return response([["message" => "login ou password existe" , "code" => "401" ]],401);
            }
        }
        else{
            return response([["message" => "Password incorrect ! ", "code" => "401" ]],401);
        }
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAPI(Request $request)
    {
        //
        $data = Employe::find($request->id); 
        $result = $data->delete();
        if ($result) {
            return response(["message" => "Successfully Deleted!" ],201);
        } else {
            return response(["message" => "Not Deleted, Try Again!" ],401);
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getResponsableAPI()
    {
        //
        /*$responsables = Responsable::query()
        ->get(); */ 
        $responsables = Employe::query()
        ->where('etat' , 'LIKE' , 1 )
        ->get();  

        if($responsables != null){
            return response($responsables, 201); 
        }
        else{
            return response(["message" => "Il n'y a aucun responsable ! " ],401); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getResponsableRHAPI()
    {
        //
        /*$responsables = Responsable::query()
        ->get(); */ 
        $responsables = Employe::query()
        ->where('etat' , 'LIKE' , 3 )
        ->get();  

        if($responsables != null){
            return response($responsables, 201); 
        }
        else{
            return response(["message" => "Il n'y a aucun responsable ! " ],401); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyResponsableAPI(Request $request)
    {
        //
            $data = Employe::findOrFail($request->id);
            $data->etat = 0 ;
            $result = $data->save() ; 

            if ($result) {
                return response(["message" => "Successfully Deleted!" ],201);
            } else {
                return response(["message" => "Not Deleted, Try Again!" ],401);
            }    
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AjouterResponsableAPI(Request $request)
    {
        //
        $data = Employe::findOrFail($request->id); 

        if ($data->etat == 0 ) {
                $data->etat = 1 ; 
                $data->save() ; 
                return response([["message" => "Successfully Added!" , "code" => "201" ]],201);
        }
        else{
                return response([["message" => "Deja responsable !" , "code" => "401"]],401);
        }  
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AjouterResponsableRHAPI(Request $request)
    {
        //
        $data = Employe::findOrFail($request->id); 

        if ($data->etat == 0 ) {
                $data->etat = 3 ; 
                $data->save() ; 
                return response([["message" => "Successfully Added!" , "code" => "201" ]],201);
        }
        else{
                return response([["message" => "Deja responsable !" , "code" => "401"]],401);
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDisponibiliteAPI()
    {
        //
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        /*$nbr_employes = Employe::query() 
        ->count(); */

        $pointages = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.telephone','employe.etat','pointage.*' )
        ->get() ;

        /*$nbr_pointages = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.etat','pointage.*' )
        ->count() ; */

        if(!$pointages->isEmpty()){
            return response($pointages,201);
        }
        else{
            return response([["message" => "Vide !" , "code" => "401" ]],401);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNombreDisponibiliteAPI()
    {
        //
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $nbr_pointages = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.etat','pointage.*' )
        ->count() ; 

        return response($nbr_pointages,201);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNombreEmployesAPI()
    {
        //
        $nbr_employes = Employe::query() 
        ->count(); 

        return response($nbr_employes,201);
    }

}
