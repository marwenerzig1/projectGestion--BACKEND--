@extends('admin.base.Navfooter') 
@section('title','Groupes') 
@section('text2','nav-item active')


@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection


@section('content')
<style>
    .d{
        padding: 2% ; 
    }
</style>
<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    
    /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }
    
    /* Modal Content */
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }
    
    /* The Close Button */
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
    .pp{
        font-size: 20px ; 
        color: white ; 
        position: relative; 
        top:6px ; 
        left: 4px ;
    }
    .aa{
        position: relative;
        top: -110px ; 
        left: 1350px ; 
    }
    #btn1{
        position: relative;
        left: 1300px ; 
        top: -92px ; 
    }
    .Ajouter{
        margin-top: -30px ; 
    }
    .tt{
        font-size: 22px ; 
        margin-left: 80px ;       
    }
    #pp{
        margin-left: 14px ; 
    }
    .btn{
        margin-left: 14px ; 
    }
    .recherchee{
        margin-left: 880px ; 
        margin-top: -100px ; 
        margin-bottom: 100px ; 
    }

    </style>
<article>

      <h1 class="liste">Liste des groupes : </h1> 
      <div class="recherchee">
        <form class="form-inline my-2 my-lg-0" action="{{route('groupe.ChercherGroupe')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            <input class="form-control mr-sm-2" name="nom_projet" type="search" placeholder="Responsable ... " aria-label="Search">
            @if ($errors->has('nom_projet'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('nom_projet') }}</strong>
            </span>
            @endif
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Chercher</button>
        </form>
      </div>

    @if($groupes->isNotEmpty())
    <div class="container">
      <div class="row text-center">
            @foreach ($groupes as $groupe)
            <div class="col-xl-6 col-sm-6 mb-5">
              <div class="bg-WhiteSmoke rounded shadow-sm py-5 px-4" id="rr">
                  <h5 class="mb-0">Nom de Projet : {{$groupe->nom_projet}}</h5>
                  <span class="small text-uppercase text-muted">Responsable : {{$groupe->nom}} {{$groupe->prenom}}</span>
                  <p class="mb-2" style="font-size: 14px">Description : {{$groupe->description}} </p>
                  <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a class="btn btn-warning btn-sm" href="/ConsulterGroupe/{{$groupe->id_groupe}}"  > <i class="fa fa-newspaper-o"></i> Consulter </a></li>
                  </ul>
              </div>
            </div>
            @endforeach
            <br> <br> <br> <br> <br> <br> 
      </div>
    </div>      
            @else
            <br> 
            <h4 class="d">Il n'y a aucun Groupes ! </h4> 
            @endif 
</article>

@endsection