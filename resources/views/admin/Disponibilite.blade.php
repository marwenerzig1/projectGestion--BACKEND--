@extends('admin.base.Navfooter') 
@section('title','Disponibilité Actuelle') 
@section('text3','nav-item active')


@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')
<style>
    .ligne{
        width: 95% ; 
        margin-top: 4px ; 
    }
    .h2{
        margin-left: 30px ; 
        margin-top: 40px ; 
    }
    .h4{
        margin-left: 30px ; 
    }
    .d{
        margin-left: 30px ; 
    }
</style>

<div class="first">
    <h2 class="h2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> DISPONIBILITÉ ACTUELLE </h2>
    <hr class=ligne>
    <h4 class="h4"><span style="color:rgb(42, 141, 221)">{{$nbr_pointages}}</span><span style="color: rgb(168, 166, 166)">/{{$nbr_employes}}</span> employés pointés dans le système</h4>
</div>

<br><br>

<div>
    @if($pointages->isNotEmpty())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Fonctionalité</th>
                    <th scope="col">Temps d'entree</th>
                    <th scope="col">Temps de sortie </th> 
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pointages as $pointage)
                    <td></td>
                    <td>{{$pointage->nom}}</td>
                    <td>{{$pointage->prenom}}</td>
                    @if ($pointage->etat == 0) 
                        <td>Employe</td>
                    @elseif ($pointage->etat == 1)
                        <td>Responsable du groupe</td>
                    @elseif ($pointage->etat == 3)
                        <td>Responsable RH</td>
                    @endif       
                    <td>{{$pointage->temps_dentree}}</td>
                    @if ($pointage->date_de_sortie != null)
                        <td>{{$pointage->date_de_sortie}}</td>
                    @else
                        <td>--</td>
                    @endif
                    <td> <a class="btn btn-warning btn-sm" href="" > <i class="fa fa-map"></i> Localisation sur Map </a> </td>
                </tr>
                @endforeach
            </tbody>
        </table>  
                @else
                <br> 
                <h4 class="d">Il n'y a aucun pointage aujourd'hui ! </h4> 
                @endif <br> <br> <br> <br> <br> <br>
    </div> 


<br><br><br>

@endsection