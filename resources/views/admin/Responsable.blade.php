@extends('admin.base.Navfooter') 
@section('title','Employes') 
@section('text1','dropdown active')


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
    #recherchee{
        margin-left: 1020px ; 
        margin-top: -40px ; 
    }

    </style>
<article>
    <div>
      <h1 class="liste">Liste des comptes des Responsables de groupe : </h1> 
    <div id="recherchee" >
        <form class="form-inline my-2 my-lg-0" action="{{route('employe.ChercherResponsable')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            <input class="form-control mr-sm-2" name="nom_prenom" type="search" placeholder="Responsable ... " aria-label="Search">
            @if ($errors->has('nom_prenom'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('nom_prenom') }}</strong>
            </span>
            @endif
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Chercher</button>
        </form>
    </div>
      <div class="Ajouter">
        <form class="form-inline my-2 my-lg-0" action="{{route('responsable_RH.AjouterResponsable')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            <label class="tt">Ajouter Responsable :    </label> 
            <select class="js-example-basic-multiple form-control" id="pp" name="employe" >
                <option value="" selected disabled>---Employe---</option>
                @foreach ($employess as $employe)
                @if($employe->etat == 0)
                    <option value={{$employe->id}}>
                        {{$employe->nom}} {{$employe->prenom}}
                    </option>
                @endif
                @endforeach
            </select> 
            @if ($errors->has('employe'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('employe') }}</strong>
            </span>
            @endif 
            <button class="btn btn-outline-primary my-2 my-sm-0" id="btn" type="submit">Ajouter</button>
        </form>
      </div>
    </div><br>

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
    @if($employes->isNotEmpty())
    <div class="container">
      <div class="row text-center">
            @foreach ($employes as $employe)
            @if($employe->etat == 1)
            <div class="col-xl-3 col-sm-6 mb-5">
              <div class="bg-WhiteSmoke rounded shadow-sm py-5 px-4">
                  <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                  <h5 class="mb-0">{{$employe->nom}} {{$employe->prenom}}</h5><span class="small text-uppercase text-muted">RESPONSABLE - {{$employe->status}}</span>
                  <ul class="social mb-0 list-inline mt-3">
                      <li class="list-inline-item"><a class="btn btn-warning btn-sm" href="/AnnulerResponsableRH/{{$employe->id}}"  > <i class="fa fa-trash"></i> Annuler Tâche </a></li>
                  </ul>
              </div>
            </div>
            @endif
            @endforeach
            <br> <br> <br> <br> <br> <br> 
      </div>
    </div>      
            @else
            <br> 
            <h4 class="d">Il n'y a aucun Responsable ! </h4> 
            @endif 
</article>

@endsection