@extends('admin.base.Navfooter') 
@section('title','Configuration Days') 
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
    <h2 class="h2"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Configuration des jours </h2>
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
    @if($days->isNotEmpty())
        <table class="table table-striped" id="table" >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jour</th>
                    <th scope="col">Temps d'entree</th>
                    <th scope="col">Temps de sortie </th> 
                    <th scope="col">Break Heures</th>
                    <th scope="col">Regular Heures</th>
                    <th scope="col">Temps Finale</th>
                    <th scope="col">Etat</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($days as $day)
                <form name="myForm" action="{{route('days.updateDays' , $day->id)}}" method="POST" enctype="multipart/form-data" >
                <tr>
                    @csrf
                    @method('PATCH')
                        <td>{{$day->id}}</td>
                        <td>{{$day->day}}</td>
                        @if ($day->etat == 0)
                            <td><input type="time" name="date_debut" value="{{$day->date_debut}}" step="2"></td>
                            <td><input type="time" name="date_fin" value="{{$day->date_fin}}" step="2"></td>
                            <td><input type="time" name="break_houres" value="{{$day->break_houres}}" step="2"></td>
                            <td>{{$day->regular_houres}}</td>
                            <td><input type="time" name="date_finale" value="{{$day->date_finale}}" step="2"></td>
                        @else
                            <td><input type="time" name="date_debut" step="2"></td>
                            <td><input type="time" name="date_fin" step="2"></td>
                            <td><input type="time" name="break_houres"  step="2"></td>
                            <td>{{$day->regular_houres}}</td>
                            <td><input type="time" name="date_finale"  step="2"></td>
                        @endif
                        <td><select class="js-example-basic-multiple form-control" @if($day->etat == 0) style="color: rgb(0, 128, 32)"  @else style="color: rgb(74, 107, 180)" @endif name="etat" >
                            @if($day->etat == 0)
                                <option value="0" style="color: rgb(0, 128, 32)">Work</option>
                            @else
                                <option value="1" style="color: rgb(74, 107, 180)">Weekend</option>
                            @endif
                            @if($day->etat == 1 )
                            <option value="0" style="color: rgb(0, 128, 32)">Work</option>
                            @else
                            <option value="1" style="color: rgb(74, 107, 180)">Weekend</option>
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
                <h4 class="d">Il n'y a aucun pointage aujourd'hui ! </h4> 
                @endif 
    </div> 


<br><br><br>

@endsection