@extends('admin.base.Navfooter') 
@section('title','Demandes des Congés') 
@section('text5','nav-item active')


@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')
<style>
    .h2{
        margin-left: 2px ; 
        margin-top: 40px ; 
    }
    .h4{
        margin-left: 30px ; 
    }
    .d{
        margin-left: 30px ; 
    }
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
    #table{
        margin-left: 30px ; 
    }
</style>

<div class="filtre"> 
    <h2 class="h2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> DEMANDES DES CONGES </h2>
    <form class="form-inline my-2 my-lg-0" action="{{route('conges.DemanderConge')}}" method="POST" enctype="multipart/form-data">
        @csrf 
        <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
        <select class="js-example-basic-multiple form-control" id="pp" name="employe" >
            @if ( request()->route('id') == "vide" )
                <option value="vide">Toutes les employes</option>
            @else
                <option value={{session('conge_id_employe')}}>{{session('conge_nom_employe')}} {{session('conge_prenom_employe')}}</option>
            @endif
            @if ( request()->route('id') != "vide" )
                <option value="vide">Toutes les employes</option>
            @endif
            @foreach ($employes as $employe)
                
                    <option value={{$employe->id}}>
                        {{$employe->nom}} {{$employe->prenom}}
                    </option>
                
            @endforeach
        </select> 
        <button class="btn btn-outline-primary my-2 my-sm-0" id="btn" type="submit">Valider</button>
        <hr class="ligne">
        <div class="cc"> 
        A Partir de : 
        @if(session('conge_date_debut') == 0)  
            <input type="date" class="js-example-basic-multiple form-control" id="date1" name="date_dep" >
        @else
            <input type="date" class="js-example-basic-multiple form-control" value="{{session('conge_date_debut')}}" id="date1" name="date_dep" >
        @endif
        @if ($errors->has('date_dep'))
        <span class="help-block">
            <strong style="color: red" >{{ $errors->first('date_dep') }}</strong>
        </span>
        @endif 
        Jusqu'au : 
        @if(session('conge_date_fin') == 0)
            <input type="date" class="js-example-basic-multiple form-control" id="date2" name="date_fin" >
        @else
            <input type="date" class="js-example-basic-multiple form-control" value="{{session('conge_date_fin')}}" id="date2" name="date_fin" >
        @endif
        </div>
    </form>
</div>

<br><br>

<div>
    @if($conges->isNotEmpty())
        <table class="table table-striped" id="table" >
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Date Debut</th>
                    <th scope="col">Date Fin</th>
                    <th scope="col">Nombres des jours</th> 
                    <th scope="col">Cause</th>
                    <th scope="col">Date de demande</th>
                    <th scope="col">Etat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conges as $conge)
                    <td></td>
                    <td>{{$conge->nom}}</td>
                    <td>{{$conge->prenom}}</td>     
                    <td>{{$conge->date_debut}}</td>
                    <td>{{$conge->date_fin}}</td>
                    <td>{{$conge->nombre_jours}}</td>
                    <td>{{$conge->cause}}</td>
                    <td>{{$conge->created_at}}</td>
                    @if ($conge->etat == 0) 
                        <td><a class="btn btn-secondary btn-sm" href="/traitementConge/{{$conge->id}}/{{$conge->id_employe}}" > <i class="fa fa-search"></i> En Cours</a></td>
                    @elseif ($conge->etat == 1)
                        <td><a class="btn btn-primary btn-sm" href="/traitementConge/{{$conge->id}}/{{$conge->id_employe}}" > <i class="fa fa-search"></i> Accepter</a></td>
                    @elseif ($conge->etat == 2)
                        <td><a class="btn btn-danger btn-sm" href="/traitementConge/{{$conge->id}}/{{$conge->id_employe}}" > <i class="fa fa-search"></i> Refuser</a></td>
                    @endif  
                </tr>
                @endforeach
            </tbody>
        </table>  
                @else
                <br> 
                <h4 class="d">Il n'y a aucun demandes de congés ! </h4> 
                @endif <br> <br> <br> <br> <br> <br>
    </div> 




@endsection