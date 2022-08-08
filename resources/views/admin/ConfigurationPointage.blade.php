@extends('admin.base.Navfooter') 
@section('title','Configuration Pointage') 
@section('text6','dropdown active')

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
    .container{
        margin-left: 450px ; 
        position: relative;
        top: -50px ; 
    }
    #table{
        margin-left: 30px ; 
    }
</style>

<div class="first">
    <div>
    <h2 class="h2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Configuration du pointage</h2>
    <div class="container">
        <div class="row">
            <div class="col-6">
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
    </div>
    <hr class=ligne>
</div>

<br><br>

<div>
    @if($configurations->isNotEmpty())
        <table class="table table-striped" id="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Altitude du societe</th>
                    <th scope="col">Longitude du societe</th>
                    <th scope="col">Distance en KM</th> 
                    <th scope="col">Temps d'envoi </th>
                    <th scope="col">Etat</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($configurations as $configuration)
                <form name="myForm" action="{{route('configurations.updateConfigurationPointage' , $configuration->id)}}" method="POST" enctype="multipart/form-data" >
                <tr>
                    @csrf
                    @method('PATCH')
                        <td>{{$configuration->id}}</td>
                        <td><input type="number" step=any  name="lantitudeSociete" value="{{$configuration->lantitudeSociete}}" ></td>
                        <td><input type="number" step=any name="longitudeSociete" value="{{$configuration->longitudeSociete}}" ></td>
                        <td><input type="number" step=any name="distanceInKM" value="{{$configuration->distanceInKM}}" ></td>
                        <td><input type="time" name="temps_denvoi" value="{{$configuration->temps_denvoi}}" ></td>
                        <td><select class="js-example-basic-multiple form-control" @if($configuration->etat == 0) style="color: rgb(197, 24, 24)"  @else style="color: rgb(0, 128, 32)" @endif name="etat" >
                            @if($configuration->etat == 0)
                                <option value="0" style="color: rgb(197, 24, 24)">Desactive</option>
                            @else
                                <option value="1" style="color: rgb(0, 128, 32)">Active</option>
                            @endif
                            @if($configuration->etat == 1 )
                            <option value="0" style="color: rgb(197, 24, 24)">Desactive</option>
                            @else
                            <option value="1" style="color: rgb(0, 128, 32)">Active</option>
                            @endif
                        </td>
                        <td> <button class="btn btn-dark btn-sm" type="submit"><i class="fa fa-edit"></i>Modifier</button> </td>
                </tr>
                </form>
                @endforeach
            </tbody>
        </table>  
                @else
                <br> 
                <h4 class="d">Il n'y a aucun configuration d'aujourd'hui ! </h4> 
                @endif 
    </div> 


<br><br><br>

@endsection