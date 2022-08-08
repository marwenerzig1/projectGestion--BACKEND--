<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Employe;
use App\Models\Groupe;
use App\Models\Membre;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 
use App\Mail\SendMessage ;
use App\Models\Conges;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(session('id_RH') == -1){
        $admin = Admin::findOrFail(1);
        return view('admin.ModifierCompte',compact('admin')) ; 
        }
        else{
        $admin = Employe::findOrFail(session('id_RH'));
        return view('admin.ModifierCompte',compact('admin')) ;     
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {
        //
        if(session('id_RH') == -1){
            $admin = Admin::findOrFail(1);
            return view('admin.ModifierPassword',compact('admin')) ; 
        }
        else{
            $admin = Employe::findOrFail(session('id_RH'));
            return view('admin.ModifierPassword',compact('admin')) ;     
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create3()
    {
        //
        $employes = Employe::query() 
        ->get(); 

        return view('admin.employes',compact('employes')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create4()
    {
        //
        $employess = Employe::query() 
        ->get(); 

        $employes = Employe::query() 
        ->get(); 

        return view('admin.Responsable_RH',compact('employes','employess')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create5()
    {
        //
        $employess = Employe::query() 
        ->get();

        $employes = Employe::query() 
        ->get(); 

        return view('admin.Responsable',compact('employes','employess')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "login"=>'required|string|max:159', 
            "password"=>'required|string|min:8|max:159', 
        ]);  
        $login = $request->old('login');
        $password = $request->old('password');


            $admins = Admin::query()
            ->where('login' , 'LIKE' , "{$request->login}" )
            ->get(); 
            
            $responsables_RH = Employe::query()
            ->where('etat','=',3)
            ->where('login' , 'LIKE' , "{$request->login}" )
            ->get(); 

        if($admins != null ){   
            foreach($admins as $admin){
                if($admin->login == $request->login){
                    if($admin->password == $request->password){
                        session()->put('nom',$admin->nom);
                        session()->put('login',$admin->login);
                        session()->put('prenom',$admin->prenom);
                        session()->put('id_RH',-1);
                            return redirect('/tableau-de-bord') ; 
                    }
                    else{
                        session()->flash("flash_erreur","Mot de passe incorrecte !  ") ;
                        return back() ;
                    }
                }
                else{
                    session()->flash("flash_erreur","Login incorrecte !  ") ;
                    return back() ;
                }
            }
        }

        if($responsables_RH != null){
            foreach($responsables_RH as $responsable_RH){
                if($responsable_RH->login == $request->login){
                    if($responsable_RH->password == $request->password){
                        session()->put('nom',$responsable_RH->nom);
                        session()->put('prenom',$responsable_RH->prenom);
                        session()->put('login',$responsable_RH->login);
                        session()->put('id_RH',$responsable_RH->id);
                            return redirect('/tableau-de-bord') ; 
                    }
                    else{
                        session()->flash("flash_erreur","Mot de passe incorrecte !  ") ;
                        return back() ;
                    }
                }
                else{
                    session()->flash("flash_erreur","Login incorrecte !  ") ;
                    return back() ;
                }
            }
        }

        session()->flash("flash_erreur","Login incorrecte !  ") ;
        return back() ;


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCompte(Request $request)
    {
        //
        //if(session('id_RH' == -1)){
            $request->validate([
                "nom"=>'required|string|max:159', 
                "prenom"=>'required|string|max:159', 
                "login"=>'required|string|max:159', 
                "password"=>'required|string|min:8'
            ]); 


        if(session('id_RH') == -1 ){

            $verif = Employe::query()
            ->where('login' , 'LIKE' , "$request->login" )
            ->get();   
    
            if(!$verif->isEmpty()){
                session()->flash("flash_erreur","Login existe") ;
                return back();  
            }

            $data = Admin::findOrFail(1);   
            if($request->password == $data->password ){
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->login = $request->login ; 
                $data->save() ;  
                session()->put('nom',$request->nom);
                session()->put('prenom',$request->prenom);
                session()->flash("flash_message","Modifié avec succes") ;
                return back() ; 
            }
            else{
                session()->flash("flash_erreur","Password incorrect ") ;
                return back() ; 
            }
        }
        else{
                $verif = Admin::query()
                ->where('login' , 'LIKE' , "$request->login" )
                ->get();   
        
                if(!$verif->isEmpty()){
                    session()->flash("flash_erreur","Login existe") ;
                    return back();  
                }

            $data = Employe::findOrFail(session('id_RH'));   
            if($request->password == $data->password ){
                $data->nom = $request->nom ; 
                $data->prenom = $request->prenom ; 
                $data->login = $request->login ; 
                $data->cin = $request->cin ; 
                $data->telephone = $request->telephone ; 
                $data->adresse = $request->adresse ;
                $data->date_de_naissance = $request->date_de_naissance ;
                $data->save() ;  
                session()->put('nom',$request->nom);
                session()->put('prenom',$request->prenom);
                session()->flash("flash_message","Modifié avec succes") ;
                return back() ; 
            }
            else{
                session()->flash("flash_erreur","Password incorrect ") ;
                return back() ; 
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMotDePasse(Request $request)
    {
        //
        $request->validate([
            "password"=>'required|string|min:8' ,
            "nouveau_password"=>'required|string|min:8' ,
            "confirmation_password"=>'required|string|min:8'
        ]); 
        if(session('id_RH') == -1 ){
            $data = Admin::findOrFail(1);   
            if($request->password == $data->password ){
                if($request->nouveau_password == $request->confirmation_password){
                    $data->password = $request->nouveau_password ; 
                    $data->save() ;  
                    session()->flash("flash_message","Modifié avec succes") ;
                    return back() ; 
                }
                else{
                    session()->flash("flash_erreur","Password incorrect ") ;
                    return back() ; 
                }
            }
            else{
                session()->flash("flash_erreur","Password incorrect ") ;
                return back() ; 
            }
        }
        else{
            $data = Employe::findOrFail(session('id_RH'));   
            if($request->password == $data->password ){
                if($request->nouveau_password == $request->confirmation_password){
                    $data->password = $request->nouveau_password ; 
                    $data->save() ;  
                    session()->flash("flash_message","Modifié avec succes") ;
                    return back() ; 
                }
                else{
                    session()->flash("flash_erreur","Password incorrect ") ;
                    return back() ; 
                }
            }
            else{
                session()->flash("flash_erreur","Password incorrect ") ;
                return back() ; 
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        //resource Humaine 
        $employe = Employe::query()
        ->count();
        $responsable = Employe::query()
        ->where('etat', 'LIKE', 1 )
        ->count();
        $responsable_RH = Employe::query()
        ->where('etat', 'LIKE', 3 )
        ->count();
        $groupe = Groupe::query()
        ->count();

        //conges
        $Congess = Conges::select(DB::raw("COUNT(*) as count") , DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("month_name"))
        ->orderBy('id','ASC')
        ->pluck('count','month_name');
        $Congesss = Conges::select(DB::raw("COUNT(*) as count") , DB::raw("MONTH(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("month_name"))
        ->orderBy('id','ASC')
        ->pluck('month_name');

        $tableau_congess_encours = array() ; 
        $tableau_congess_accepter = array() ; 
        $tableau_congess_refuser = array() ; 
        foreach($Congesss as $conge){
            
            $rr0 = Conges::select( DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('etat', 0 )
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $conge)
            ->count() ; 
            $rr1 = Conges::select( DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('etat', 1 )
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $conge)
            ->count() ; 
            $rr2 = Conges::select( DB::raw("MONTHNAME(created_at) as month_name"))
            ->where('etat', 2 )
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $conge)
            ->count() ; 
            
            array_push($tableau_congess_encours , $rr0) ; 
            array_push($tableau_congess_accepter , $rr1) ; 
            array_push($tableau_congess_refuser , $rr2) ; 
        }

        $labels = $Congess->keys();
        $data_line = $Congess->values();
        $data_encours = $tableau_congess_encours ;
        $data_accepter = $tableau_congess_accepter ;
        $data_refuser = $tableau_congess_refuser ;

        // disponabilite actuelle 

        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $nbr_employes = Employe::query() 
        ->count(); 

        $nbr_employe_presences = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.etat','pointage.*' )
        ->count() ; 

        $nbr_employe_absence = $nbr_employes - $nbr_employe_presences ; 

        

        //pointage
        $pointages = Pointage::select(DB::raw("COUNT(*) as count") , DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("month_name"))
        ->orderBy('id','ASC')
        ->pluck('count','month_name');      
        $pointagee = Pointage::select(DB::raw("COUNT(*) as count") , DB::raw("MONTH(created_at) as month_name"))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw("month_name"))
        ->orderBy('id','ASC')
        ->pluck('month_name');
        $tableau_absences = array() ; 
        $tableau_precences = array() ; 
        $tableau_precences_moins = array() ; 
        foreach($pointagee as $pointage){
            
            $rr0 = Pointage::query()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $pointage)
            ->select("net_heures" , "regular_heures" , "created_at" ) 
            ->get() ; 

            $absences = 0 ; 
            $presences = 0 ; 
            $presneces_absences = 0  ; 

            foreach($rr0 as $pointaged){
                if($pointaged["net_heures"] == "00:00:00"){
                    $absences = $absences + 1 ;  
                }
                else if( $pointaged["net_heures"] < $pointaged["regular_heures"]){
                    $presneces_absences = $presneces_absences + 1 ;
                }
                else{
                    $presences = $presences + 1 ; 
                }
            } 

            array_push($tableau_absences , $absences) ; 
            array_push($tableau_precences  , $presences) ; 
            array_push($tableau_precences_moins , $presneces_absences) ; 
        } 

        $labels_pointage = $pointages->keys();




        return view('admin.tableau_de_bord',compact('tableau_absences','tableau_precences','tableau_precences_moins','labels_pointage','employe','responsable','responsable_RH' , 'labels' , 'data_encours' , 'data_accepter' ,'groupe', 'data_refuser' , 'data_line' , 'nbr_employe_presences' , 'nbr_employe_absence' )) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $data = Employe::find($id); 
            $data->delete(); 
            session()->flash("flash_message","supprimer avec succes") ;
            return back();
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Suppression impossible") ;
            return back(); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AjouterEmploye(Request $request)
    {
        $request->validate([
            "nom"=>'required|string|max:159', 
            "prenom"=>'required|string|max:159', 
            "cin"=>'required|integer', 
            "telephone"=>'required|integer', 
            "adresse"=>'required|string|max:159', 
            "date_de_naissance"=>'required|date', 
            "status"=>'required|string', 
            "solde_conge"=>'required|numeric', 
            "salaire"=>'required|numeric', 
            "login"=>'required|string', 
            "password"=>'required|string|min:8', 
            "password2"=>'required|string|min:8', 
        ]); 

        $admin = Admin::query()
        ->where('login', 'LIKE', "$request->login" )
        ->get(); 

        if(!$admin->empty()){
            session()->flash("flash_erreur","Login existe ! ") ;
            return back(); 
        }


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
                //send mail
                session()->put('nom_email',$request->nom);
                session()->put('prenom_email',$request->prenom);
                session()->put('login_email',$request->login);
                session()->put('password_email',$request->password);
                Mail::to($request->login)->send(new SendMessage) ; 
                //end
                session()->flash("flash_message","Ajouté avec succes") ;
                return back();
            }
            catch(\Illuminate\Database\QueryException $e){
                session()->flash("flash_erreur","Login existe") ;
                return back(); 
            }
        }
        else{
            session()->flash("flash_erreur","Password incorrect") ;
            return back(); 
        }
    } 
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employe = Employe::findOrFail($id);
        return view('admin.ModifierEmploye', compact('employe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmploye(Request $request, $id)
    {
        //
        $request->validate([
            "nom"=>'required|string|max:159', 
            "prenom"=>'required|string|max:159', 
            "cin"=>'required|integer', 
            "telephone"=>'required|integer', 
            "adresse"=>'required|string|max:159', 
            "date_de_naissance"=>'required|date', 
            "status"=>'required|string', 
            "solde_conge"=>'required|numeric', 
            "salaire"=>'required|numeric', 
            "login"=>'required|string', 
            "password"=>'required|string|min:8', 
        ]); 

            $admin = Admin::query()
            ->where('login', 'LIKE', "$request->login" )
            ->get(); 

            if(!$admin->empty()){
                session()->flash("flash_erreur","Login existe ! ") ;
                return back(); 
            }

            try{
                $data = Employe::findOrFail($id);
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

                session()->flash("flash_message","Modifié avec succes") ;
                return redirect('/employes'); 
            }
            catch(\Illuminate\Database\QueryException $e){
                session()->flash("flash_erreur","Login existe") ;
                return back(); 
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChercherEmploye(Request $request)
    {
        //

        $employes = Employe::query()
        ->where('nom', 'LIKE', "%{$request->nom_prenom}%")
        ->orWhere('prenom', 'LIKE', "%{$request->nom_prenom}%")
        ->get();

        return view('admin.employes',compact('employes')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChercherResponsableRH(Request $request)
    {
        //
        $employess = Employe::query() 
        ->get(); 



        $employes = DB::table('Employe')
           ->where('etat', '=', 3 )
           ->where(function ($query) use ($request) {
               $query->where('nom', 'LIKE', "%{$request->nom_prenom}%")
                      ->orWhere('prenom', 'LIKE', "%{$request->nom_prenom}%");
           })
           ->get();

        return view('admin.Responsable_RH',compact('employes','employess')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChercherResponsable(Request $request)
    {
        //
        $employess = Employe::query() 
        ->get();

        $employes = DB::table('Employe')
           ->where('etat', '=', 1 )
           ->where(function ($query) use ($request) {
               $query->where('nom', 'LIKE', "%{$request->nom_prenom}%")
                      ->orWhere('prenom', 'LIKE', "%{$request->nom_prenom}%");
           })
           ->get();

        return view('admin.Responsable',compact('employes','employess')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ChercherGroupe(Request $request)
    {
        //

        $groupes = DB::table('groupe')
        ->join('employe', 'groupe.id_responsable', '=', 'employe.id')
        ->where('nom_projet', 'LIKE', "%{$request->nom_projet}%")
        ->orWhere('employe.prenom', 'LIKE', "%{$request->nom_projet}%")
        ->orWhere('employe.nom', 'LIKE', "%{$request->nom_projet}%")
        ->select('groupe.*', 'employe.nom' , 'employe.prenom' )
        ->get();  

        

        return view('admin.Groupe',compact('groupes')) ;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AnnulerResponsableRH($id)
    {
        //
        try{
            $data = Employe::find($id); 
            $data->etat = 0 ; 
            $data->save() ;  
            session()->flash("flash_message","Annuler Tâche avec succes") ;
            return back();
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Annulation Tâche impossible") ;
            return back(); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AnnulerResponsable($id)
    {
        //
        try{
            $data = Employe::find($id); 
            $data->etat = 0 ; 
            $data->save() ;  
            session()->flash("flash_message","Annuler Tâche avec succes") ;
            return back();
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Annulation Tâche impossible") ;
            return back(); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AjouterResponsableRH(Request $request)
    {
        $request->validate([
            "employe"=>'required|integer', 
        ]); 

        try{
            $data = Employe::find($request->employe); 
            $data->etat = 3 ; 
            $data->save() ;  
            session()->flash("flash_message","Ajouter Responsable RH avec succes") ;
            return back();
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Ajouter impossible") ;
            return back(); 
        }
        
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AjouterResponsable(Request $request)
    {
        $request->validate([
            "employe"=>'required|integer', 
        ]); 

        try{
            $data = Employe::find($request->employe); 
            $data->etat = 1 ; 
            $data->save() ;  
            session()->flash("flash_message","Ajouter Responsable avec succes") ;
            return back();
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Ajouter impossible") ;
            return back(); 
        }   
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Groupe()
    {
        //
        $groupes = DB::table('groupe')
        ->join('employe', 'groupe.id_responsable', '=', 'employe.id')
        ->select('groupe.*', 'employe.nom' , 'employe.prenom' )
        ->get();

        return view('admin.Groupe',compact('groupes')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ConsulterGroupe($id)
    {
        //
        $groupes = DB::table('groupe')
        ->join('employe', 'groupe.id_responsable', '=', 'employe.id')
        ->where('id_groupe','=', $id) 
        ->select('groupe.*', 'employe.nom' , 'employe.prenom' )
        ->get();

      /*  $membres = DB::table('membre') 
        ->join('employe', 'membre.id_employe', '=', 'employe.id')
        ->where('membre.id_groupe','=',$id)
        ->select('employe.*' ) ;  */
        $membres = DB::table('membre')
        ->where('id_groupe' , '=' , $id)
        ->join('employe' , 'membre.id_employe' , '=' , 'employe.id')
        ->select('employe.*' )
        ->get() ; 

        return view('admin.PlusGroupe',compact('groupes','membres')) ;
    }

    //emploi 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getemploiSP($id,$date_deb,$date_fin)
    {
        //

        $employes = Employe::query()
        ->get(); 

        if($date_deb==0){
            $pointages = DB::table('pointage')
            ->where('id_employe','=', $id ) 
            ->join('employe', 'pointage.id_employe', '=', 'employe.id') 
            ->select('pointage.*','employe.etat AS etat_employe')
            ->orderBy('id', 'desc')
            ->get() ; 
        }
        else{
            $Date_debut = date('Y-m-d', strtotime($date_deb));
            $Date_fin = date('Y-m-d', strtotime($date_fin));
            $pointages = DB::table('pointage')
            ->where('id_employe','=', $id )  
            ->whereDate('date', '>=', date($Date_debut))
            ->whereDate('date', '<=', date($Date_fin))
            ->join('employe', 'pointage.id_employe', '=', 'employe.id') 
            ->select('pointage.*','employe.etat AS etat_employe')
            ->orderBy('id', 'desc')
            ->get() ;

        }
        $data = Employe::find($id); 
        session()->put('id_employe',$data->id);
        session()->put('nom_employe',$data->nom);
        session()->put('prenom_employe',$data->prenom); 
        session()->put('date_debut',$date_deb); 
        session()->put('date_fin',$date_fin); 

        $table_overtime = array();
        $table_breaks = array();
        $table_regular_houres = array();
        $table_totale_heures = array();
        foreach ($pointages as $pointage){

            if($pointage->overtime != null){
            array_push($table_overtime, $pointage->overtime );
            }

            array_push($table_breaks, $pointage->break_heures );

            if($pointage->regular_heures != null){
            array_push($table_regular_houres, $pointage->regular_heures );
            }

            if($pointage->net_heures != null){
            array_push($table_totale_heures, $pointage->net_heures );
            }
        }

        //overtime
        $seconds = 0; 
        foreach ($table_overtime as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        $overtime = (($hours < 10 ) ? "0"."{$hours}".":" : "{$hours}".":") . (($minutes < 10 ) ? "0"."{$minutes}".":" : "{$minutes}".":") . (($seconds < 10 ) ? "0"."{$seconds}" : "{$seconds}")  ;
        //breaks
        $seconds = 0;
        foreach ($table_breaks as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        $breaks = (($hours < 10 ) ? "0"."{$hours}".":" : "{$hours}".":") . (($minutes < 10 ) ? "0"."{$minutes}".":" : "{$minutes}".":") . (($seconds < 10 ) ? "0"."{$seconds}" : "{$seconds}")  ;
        //regular_houres
        $seconds = 0;
        foreach ($table_regular_houres as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        $regular_houres = (($hours < 10 ) ? "0"."{$hours}".":" : "{$hours}".":") . (($minutes < 10 ) ? "0"."{$minutes}".":" : "{$minutes}".":") . (($seconds < 10 ) ? "0"."{$seconds}" : "{$seconds}")  ;
        //totale_heures
        $seconds = 0;
        foreach ($table_totale_heures as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        $totale_heuress = (($hours < 10 ) ? "0"."{$hours}".":" : "{$hours}".":") . (($minutes < 10 ) ? "0"."{$minutes}".":" : "{$minutes}".":") . (($seconds < 10 ) ? "0"."{$seconds}" : "{$seconds}")  ;
        $date1 = strtotime($totale_heuress);
        $date2 = strtotime($overtime);
        $totale_heures = date('H:i:s',$date1-$date2) ;


        return view('admin.EmploiDeTempsSP',compact('employes','pointages','overtime','breaks','regular_houres','totale_heures')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function FiltreEmploiSP(Request $request)
    {   

        //date
        if( $request->date_dep != null ){
            if($request->date_fin != null){
                return redirect('/emploiDeTempsSpecifique/'.$request->employe.'/'.$request->date_dep.'/'.$request->date_fin ) ; 
            }
            return redirect('/emploiDeTempsSpecifique/'.$request->employe.'/'.$request->date_dep.'/'. "03-03-2035" ) ; 
        }

        return redirect('/emploiDeTempsSpecifique/'.$request->employe.'/'. 0 .'/'. 0 ) ; 
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePointage(Request $request, $id)
    {
        //
        $request->validate([
            "temps_dentree"=>'required', 
            "date_de_sortie"=>'required', 
            "break_heures"=>'required', 
            "regular_heures"=>'required', 
        ]); 


                $date1 = strtotime($request->temps_dentree);
                $date2 = strtotime($request->date_de_sortie);
                if($date2 < $date1){
                    session()->flash("flash_erreur","Time de sortie incorrect !") ;
                    return back(); 
                }
                


            try{
                $data = Pointage::findOrFail($id);
                
                //totale heures 
                $date1 = strtotime($request->temps_dentree);
                $date2 = strtotime($request->date_de_sortie);
                if($date2 > $date1){
                    $totale_heures = date('H:i:s',$date2-$date1) ;
                }
                else{
                    $totale_heures = "00:00:00" ;
                }
                //net heures 
                $date1 = strtotime($totale_heures);
                $date2 = strtotime($request->break_heures);
                if($date2 < $date1){
                    $net_heures = date('H:i:s',$date1-$date2) ;
                }
                else{
                    $net_heures = "00:00:00" ;
                }
                //overtime 
                $date1 = strtotime($net_heures);
                $date2 = strtotime($request->regular_heures);
                if($date2 < $date1){
                    $overtime = date('H:i:s',$date1-$date2) ;
                }
                else{
                    $overtime = "00:00:00" ;
                } 


                $data->temps_dentree = $request->temps_dentree ; 
                $data->date_de_sortie = $request->date_de_sortie ; 
                $data->break_heures = $request->break_heures ; 
                $data->regular_heures = $request->regular_heures ; 
                $data->totale_heures = $totale_heures ; 
                $data->net_heures = $net_heures ; 
                $data->overtime = $overtime ; 
                $data->save(); 

                session()->flash("flash_message","Modifié avec succes") ;
                return back(); 
            }
            catch(\Illuminate\Database\QueryException $e){
                session()->flash("flash_erreur","dd") ;
                return back(); 
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Disponibilite()
    {
        //
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        $nbr_employes = Employe::query() 
        ->count(); 

        $pointages = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.etat','pointage.*' )
        ->get() ;

        $nbr_pointages = DB::table('pointage')
        ->where('date' , '=' , $date->format('Y-m-d') )
        ->join('employe' , 'pointage.id_employe' , '=' , 'employe.id')
        ->select('employe.nom','employe.prenom','employe.etat','pointage.*' )
        ->count() ; 

        return view('admin.Disponibilite',compact('pointages','nbr_pointages','nbr_employes')) ;

    }


}
