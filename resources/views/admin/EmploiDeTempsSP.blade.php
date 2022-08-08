@extends('admin.base.Navfooter') 
@section('title','Emploi de temps specifique') 
@section('text4','nav-item active')


@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')
<style>
    .filtre{
        margin-left: 40px ; 
        margin-top: 20px ; 
    }
    #pp{
        margin-left: 10px ; 
        margin-top: -20px ; 
    }
    #btn{
        margin-left: 15px ; 
        position: relative;
        top: -9.8px ; 
    }
    .ligne{
        width: 95% ; 
        margin-top: 4px ; 
    }
    .infor{
        float: right; 
        margin-left: 140px ; 
    }
    .p2{
        float: left; 
        margin-left: 60px ; 
        text-align: center ;
        font-size: 20px ;  
    }
    .button{
        margin-top: 30px ; 
    }
    #btn1{
        padding: 10px ; 
        width: 500px ; 
    }
    #btn2{
        padding: 10px ; 
        width: 500px ; 
    }
    #table{
        margin-left: 30px ; 
    }

</style>

<center>
    <div class="button"> 
    <a class="btn btn-secondary" id="btn1" href="" > <i class="fa fa-table"></i> Tableau </a>
    <a class="btn btn-outline-secondary" id="btn2" href="/full-calender/1" > <i class="fa fa-calendar-o"></i> Calendrier </a>
    </div>
</center>

<div class="filtre">
    <form class="form-inline my-2 my-lg-0" action="{{route('employe.filtre')}}" method="POST" enctype="multipart/form-data">
        @csrf 
        <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
        <select class="js-example-basic-multiple form-control" id="pp" name="employe" >
                <option value={{session('id_employe')}}>{{session('nom_employe')}} {{session('prenom_employe')}}</option>
            @foreach ($employes as $employe)
                @if (session('id_employe') != $employe->id)
                    <option value={{$employe->id}}>
                        {{$employe->nom}} {{$employe->prenom}}
                    </option>
                @endif 
            @endforeach
        </select> 
        <button class="btn btn-outline-primary my-2 my-sm-0" id="btn" type="submit">Valider</button>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (session()->has('flash_message'))
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                        <ul>
                            <li>{{session()->get('flash_message')}}</li>
                        </ul>
                        </div>
                    @endif
                    @if (session()->has('flash_erreur'))
                        <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                        <ul>
                            <li>{{session()->get('flash_erreur')}}</li>
                        </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <hr class="ligne">
        <div class="cc"> 
        A Partir de : 
        @if(session('date_debut') == 0)  
            <input type="date" class="js-example-basic-multiple form-control" id="date1" name="date_dep" >
        @else
            <input type="date" class="js-example-basic-multiple form-control" value="{{session('date_debut')}}" id="date1" name="date_dep" >
        @endif
        @if ($errors->has('date_dep'))
        <span class="help-block">
            <strong style="color: red" >{{ $errors->first('date_dep') }}</strong>
        </span>
        @endif 
        Jusqu'au : 
        @if(session('date_fin') == 0)
            <input type="date" class="js-example-basic-multiple form-control" id="date2" name="date_fin" >
        @else
            <input type="date" class="js-example-basic-multiple form-control" value="{{session('date_fin')}}" id="date2" name="date_fin" >
        @endif
        <div class="infor">
            <p class="p2">Overtime <br> <span style="color: rgb(68, 120, 197)">{{$overtime}}<span> </p>
            <p class="p2">Breaks <br> <span style="color: rgb(68, 120, 197)">{{$breaks}}</span> </p>
            <p class="p2">Regular Heures <br> <span style="color: rgb(68, 120, 197)">{{$regular_houres}}</span> </p>
            <p class="p2">Totale Heures <br> <span style="color: rgb(68, 120, 197)">{{$totale_heures}}</span> </p>
        </div>
        </div>
    </form>
</div>

<br><br>

<div>
@if($pointages->isNotEmpty())
    <table class="table table-striped" id="table" >
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Date</th>
                <th scope="col">Temps d'entree</th>
                <th scope="col">Temps de sortie </th> 
                <th scope="col">Totale heures</th>  
                <th scope="col">Break heures</th> 
                <th scope="col">Net heures</th> 
                <th scope="col">Regular heures</th> 
                <th scope="col">Overtime</th> 
                <th scope="col">Etat</th> 
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pointages as $pointage)
            <form name="myForm" action="{{route('ModifierPointage', $pointage->id )}}" method="POST" enctype="multipart/form-data" >
                <td></td>
                <td style="font-weight: 600">{{$pointage->date}}</td>
                @csrf
                @method('PATCH')
                @if(($pointage->etat_employe == 3) && (session('id_RH') != -1 ))
                    <td>{{$pointage->temps_dentree}}</td>
                    <td>{{$pointage->date_de_sortie}}</td>
                @else
                    <td><input type="time" name="temps_dentree" value="{{$pointage->temps_dentree}}" step="2"></td>
                    <td><input type="time" name="date_de_sortie" value="{{$pointage->date_de_sortie}}" step="2"></td>
                @endif
                @if ($pointage->totale_heures != null)
                    <td>{{$pointage->totale_heures}}</td>
                @else
                    <td>--</td>
                @endif
                @if(($pointage->etat_employe == 3) && (session('id_RH') != -1 ))
                <td>{{$pointage->break_heures}}</td>
                @else
                <td><input type="time" name="break_heures" value="{{$pointage->break_heures}}" step="2"></td>
                @endif
                @if($pointage->net_heures == "00:00:00")
                <td style="color: red">{{$pointage->net_heures}}</td>
                @elseif ($pointage->net_heures == null)
                <td>--</td>
                @elseif( $pointage->net_heures < $pointage->regular_heures)
                <td style="color:orange">{{$pointage->net_heures}}</td>
                @else
                <td style="color: green">{{$pointage->net_heures}}</td>
                @endif
                @if(($pointage->etat_employe == 3) && (session('id_RH') != -1 ))
                <td>{{$pointage->regular_heures}}</td>
                @else
                <td><input type="time" name="regular_heures" value="{{$pointage->regular_heures}}" step="2"></td>
                @endif
                @if ($pointage->overtime != null)
                    <td>{{$pointage->overtime}}</td>
                @else
                    <td>--</td>
                @endif
                @if($pointage->net_heures == "00:00:00")
                    <td style="color: red">Absences</td>
                @elseif( $pointage->net_heures < $pointage->regular_heures)
                    <td style="color:orange">Precences</td>
                @else
                    <td style="color: green">Presences</td>
                @endif
                <td>
                    @if(session('id_RH') != $pointage->id_employe)
                    <button class="btn btn-dark btn-sm" type="submit"><i class="fa fa-edit"></i>Modifier</button>
                    @endif
                    <a class="btn btn-warning btn-sm" href="" >
                        <i class="fa fa-map"></i> Localisation sur Map 
                        </a>
                </td>
            </form>
            </tr>
            @endforeach
        </tbody>
    </table>  
            @else
            <br> 
            <h4 class="d" style="margin-left: 40px">Il n'y a aucun pointage ! </h4> 
            @endif  <br> <br> <br> <br> <br> <br>
</div> 

@endsection