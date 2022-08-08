<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Conges;
use App\Models\Membre;
use App\Models\Groupe;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class CongesController extends Controller
{

     //emploi 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getcongeSP($id,$date_deb,$date_fin)
    {
        //

        $employes = Employe::query()
        ->get(); 

        if($date_deb==0){
            if($id == "vide" ){
                $conges = DB::table('conges')
                ->join('employe' , 'conges.id_employe' , '=' , 'employe.id')
                ->select('employe.nom','employe.prenom','conges.*' )
                ->orderBy('id', 'desc')
                ->get() ; 
            }
            else{
              $conges = Conges::query()
              ->where('id_employe','=', $id ) 
              ->join('employe' , 'conges.id_employe' , '=' , 'employe.id')
              ->select('employe.nom','employe.prenom','conges.*' ) 
              ->orderBy('id', 'desc')
              ->get() ; 
            }
        }
        else{
            $Date_debut = date('Y-m-d', strtotime($date_deb));
            $Date_fin = date('Y-m-d', strtotime($date_fin));
            if($id == "vide" ){
                $conges = DB::table('conges')
                ->join('employe' , 'conges.id_employe' , '=' , 'employe.id') 
                ->whereDate('date_debut', '>=', date($Date_debut))
                ->whereDate('date_debut', '<=', date($Date_fin))
                ->select('employe.nom','employe.prenom','conges.*' )
                ->orderBy('id', 'desc')
                ->get() ;
            }
            else{
                $conges = DB::table('conges')
                ->join('employe' , 'conges.id_employe' , '=' , 'employe.id')
                ->where('id_employe','=', $id )  
                ->whereDate('date_debut', '>=', date($Date_debut))
                ->whereDate('date_debut', '<=', date($Date_fin))
                ->select('employe.nom','employe.prenom','conges.*' )
                ->orderBy('id', 'desc')
                ->get() ;
            }
        }
        if($id != "vide" ){
            $data = Employe::find($id); 
            session()->put('conge_id_employe',$data->id);
            session()->put('conge_nom_employe',$data->nom);
            session()->put('conge_prenom_employe',$data->prenom); 
        } 
        session()->put('conge_date_debut',$date_deb); 
        session()->put('conge_date_fin',$date_fin); 
        

        return view('admin.DemandeDeConges',compact('employes','conges')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function FiltreCongeSP(Request $request)
    {   

        //date
        if( $request->date_dep != null ){
            if($request->date_fin != null){
                return redirect('/conges/'.$request->employe.'/'.$request->date_dep.'/'.$request->date_fin ) ; 
            }
            return redirect('/conges/'.$request->employe.'/'.$request->date_dep.'/'. "03-03-2035" ) ; 
        }

        return redirect('/conges/'.$request->employe.'/'. 0 .'/'. 0 ) ; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function traitementConges($id_conge,$id_employe)
    {   
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        //get responsables des groupes  
        $responsables = DB::table('membre')
        ->where('id_employe','=',$id_employe)
        ->join('groupe' , 'membre.id_groupe' , '=' , 'groupe.id_groupe')
        ->join('employe' , 'groupe.id_responsable' , '=' , 'employe.id')
        ->distinct()
        ->select('employe.*')
        ->get(); 


        $responsables_etat = DB::table('traitement')
        ->where('id_conge','=', $id_conge )
        ->join('employe','traitement.id_responsable','=','employe.id')
        ->select('employe.nom','employe.prenom','employe.id','traitement.updated_at','traitement.etat')
        ->get(); 

        $conge = Conges::findOrFail($id_conge); 

        if($date->format('Y-m-d') > $conge->date_debut){
            $verif = 0 ;
            $conge->etat = 2 ; 
            $conge->save() ; 
        }
        else{
            $verif = 1 ; 
        }

        if($conge->etat == 0 ){
            $conge = "En Cours" ; 
        }
        else if($conge->etat == 1 ){
            $conge = "Accepter" ; 
        }
        else{
            $conge = "Refuser" ; 
        }

        return view('admin.TraitementConge',compact('responsables','responsables_etat','id_conge','conge','verif')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AccepterConge($id_conge)
    {   
        //
        $date = Carbon::now();
        $date->timezone('Africa/Tunis');

        try{
            $data = Conges::find($id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
                if($data->etat != 1){
                    if($data->etat == 2 ){
                        $dataa = Employe::find($data->id_employe); 
                        if($data->nombre_jours > $dataa->solde_conge){
                            session()->flash("flash_message","solde conge est insuffisant ! ") ; 
                        }
                        else{
                            $dataa->solde_conge = $dataa->solde_conge - $data->nombre_jours ; 
                            $dataa->save() ; 
                        }    
                    }
                $data->etat = 1 ; 
                $data->save() ;  
                session()->flash("flash_message","Accepter avec succes") ;
                return back();}
                else{
                    session()->flash("flash_erreur","Congé deja accepté ") ;
                    return back();
                }
            }
            else{
                session()->flash("flash_erreur","Acceptation impossible ! congé debut ou termine ") ;
                return back();
            }
        }

        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Acceptation impossible") ;
            return back(); 
        }   
    } 


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function RefuserConge($id_conge)
    {   
        //
        $date = Carbon::now();
        $date->timezone('Africa/Tunis'); 
        
        try{
            $data = Conges::find($id_conge); 
            $debut = strtotime($data->date_debut) ; 
            $now = strtotime($date) ;  
            if($now < $debut){
            if( $data->etat != 2 ){
            $dataa = Employe::find($data->id_employe); 
            $dataa->solde_conge = $dataa->solde_conge + $data->nombre_jours ; 
            $dataa->save() ; 
            $data->etat = 2 ; 
            $data->save() ;  
            session()->flash("flash_message","Refuser avec succes") ;
            return back();
            }
            else{
                session()->flash("flash_erreur","Congé deja refusé") ;
                return back();
            }
            }
            else{
                session()->flash("flash_erreur","Refuse impossible ! congé debut ou termine ") ;
                return back();
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            session()->flash("flash_erreur","Refuser impossible") ;
            return back(); 
        }   
        
    }




}
