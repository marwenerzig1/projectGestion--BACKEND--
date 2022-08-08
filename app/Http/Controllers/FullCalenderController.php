<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Pointage;

class FullCalenderController extends Controller
{
    public function index(Request $request , $id )
    {
        $employe = Employe::find($id); 
        
        $employes = Employe::query()
        ->get() ; 


    	if($request->ajax())
    	{
    		$pointages = Pointage::whereDate('date', '>=', $request->start)
                       ->where('id_employe', '=' , $id)
                       ->whereDate('date',   '<=', $request->end)
                       ->get(); 

            foreach($pointages as $pointage){
                    if($pointage["net_heures"] == "00:00:00"){
                        $result = "Absences"  ;
                        $color = "#EC3027" ; 
                    }
                    else if( $pointage["net_heures"] < $pointage["regular_heures"]){
                        $result = "Precences (Temps n'est pas terminer)" ;
                        $color = "#ECAA27" ;
                    }
                    else{
                        $result = "Presences" ;
                        $color = "#3ADC14" ;
                    }
                $data[] = array(
                    'id'   => $pointage["id"],  
                    'title'   =>    $result , 
                    'color'  => $color ,
                    'start'   => $pointage["date"]." ".$pointage["temps_dentree"] ,
                    'end'   => $pointage["date"]." ".$pointage["date_de_sortie"]
                );}
                       
            return response()->json($data);
    	}
        return view('admin.base.full-calender',compact('employes','employe'));
    }

    public function action(Request $request)
    {
        return redirect('/full-calender/'.$request->employe ) ;  
    }
}
?>