@extends('admin.base.Navfooter') 
@section('title','Employees') 
@section('text0','nav-item active')

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
    </style>
<article>
    <div>
      <h1 class="liste">Liste des comptes des employés : </h1> 
      </div>
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
    <button class="btn btn-secondary" id="btn1"><i class="fa fa-plus-circle"></i> Ajouter Employé </button>
    @if($users->isNotEmpty())
    <div class="container">
      <div class="row text-center">
            @foreach ($users as $employe)
              @if ($employe->fonction == "Employe")
                <div class="col-xl-3 col-sm-6 mb-5">
                  <div class="bg-WhiteSmoke rounded shadow-sm py-5 px-4">
                      @if($employe->image == null)
                        <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                      @else
                        <img src="{{ asset('images/'.$employe->image) }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                      @endif
                        <h5 class="mb-0">{{$employe->nom}} {{$employe->prenom}}</h5><span class="small text-uppercase text-muted">{{$employe->fonction}} - {{$employe->description}}</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a class="btn btn-dark btn-sm" href="/modifier_user/{{$employe->id}}"> <i class="fa fa-edit"></i> Modifier </a></li>
                            <li class="list-inline-item"><a class="btn btn-danger btn-sm" href="/deleteUser/{{$employe->id}}" > <i class="fa fa-trash"></i> Supprimer </a></li>
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
            <h4 class="d">Il n'y a aucun employe ! </h4> 
            @endif 
</article>

<!-- Trigger/Open The Modal 
<button id="myBtn">Open Modal</button> -->

<!-- The Modal ajouter departement-->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <center><h4 style="color: rgb(4, 33, 44)">Ajouter Employé</h4></center><br><br>
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
    <form name="myForm"  action="{{route('users.AddUser')}}" method="POST" enctype="multipart/form-data" >
    @csrf 

    <div class="form-row">
        <div class="form-group col-md-6">
          <label><h6>Nom :</h6></label>
          <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" placeholder="Entrer nom">
          @if ($errors->has('nom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('nom') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Prenom :</h6></label>
          <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" placeholder="Entrer prenom">
          @if ($errors->has('prenom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('prenom') }}</strong>
          </span>
          @endif
        </div> 

        <div class="form-group col-md-6">
          <label><h6>CIN :</h6></label>
          <input type="number" class="form-control" name="cin" value="{{ old('cin') }}" placeholder="Entrer cin">
          @if ($errors->has('cin'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('cin') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Telephone :</h6></label>
          <input type="number" class="form-control" name="cnrps" value="{{ old('cnrps') }}" placeholder="Entrer cin">
          @if ($errors->has('cnrps'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('cnrps') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Adresse :</h6></label>
          <input type="text" class="form-control" name="adresse" value="{{ old('adresse') }}" placeholder="Entrer adresse">
          @if ($errors->has('adresse'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('adresse') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Lieu :</h6></label>
          <input type="text" class="form-control" name="lieu" value="{{ old('lieu') }}" placeholder="Entrer lieu">
          @if ($errors->has('lieu'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('lieu') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Date de Naissance :</h6></label>
          <input type="date" class="form-control" name="date_de_naissance" value="{{ old('date_de_naissance') }}" placeholder="Entrer date de naissance">
          @if ($errors->has('date_de_naissance'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('date_de_naissance') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Fonction :</h6></label>
          <input type="text" class="form-control" name="fonction" value="Employe" readonly>
        </div>

        <div class="form-group col-md-6">
          <label><h6>Description :</h6></label>
          <input type="text" class="form-control" name="description" value="{{ old('description') }}"  placeholder="Entrer desription">
          @if ($errors->has('description'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('description') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Image :</h6></label>
          <input type="file" class="form-control" value="{{ old('image') }}" name="image" >
          @if ($errors->has('image'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('image') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Login :</h6></label>
          <input type="email" class="form-control" name="login" value="{{ old('login') }}" placeholder="Entrer login">
          @if ($errors->has('login'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('login') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Mot de passe :</h6></label>
          <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Entrer Mot de passe">
          @if ($errors->has('password'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>

        <div class="form-group col-md-6">
          <label><h6>Confirmation Mot de passe :</h6></label>
          <input type="password" class="form-control" name="password2" value="{{ old('password2') }}" placeholder="Confirmation Mot de passe">
          @if ($errors->has('password2'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('password2') }}</strong>
          </span>
          @endif
        </div>
      </div>

        <br><center><button type="submit" class="btn btn-secondary">Ajouter</button></center><br>
    </form>

  </div>

</div> 



<script>
    // Get the modal
    var modal = document.getElementById("myModal");
    
    // Get the button that opens the modal
    var btn = document.getElementById("btn1");
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      modal.style.display = "block";
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
</script>


@endsection