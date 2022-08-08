<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Modifier Employe</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

    <!-- Bootstrap core CSS -->





    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
            body {
        height: 100%;
        }

        body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }

        .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }

        #tt1{
            position: relative;
            left: -94px ; 
        }

        #tt2{
            position: relative;
            left: -83px ; 
        }

    </style>

  </head>
  <body class="text-center">

<main class="form-signin">

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

<form name="myForm" action="{{route('employe.ModifierEmploye', $employe->id )}}" method="POST" enctype="multipart/form-data" >
    @csrf
    @method('PATCH')
    <img class="mb-4" src="{{ asset('images/modifier.png') }}"  alt="" width="100" height="100">
    <h1 class="h3 mb-3 fw-normal" style="color: rgb(8, 24, 49)">Modification</h1> <br>

    <div class="form-row">
        <div class="form-group col-md-6">
          <label><h6>Nom :</h6></label>
          <input type="text" class="form-control" name="nom" value="{{$employe->nom}}" placeholder="Entrer nom">
          @if ($errors->has('nom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('nom') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Prenom :</h6></label>
          <input type="text" class="form-control" name="prenom" value="{{$employe->prenom}}" placeholder="Entrer prenom">
          @if ($errors->has('prenom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('prenom') }}</strong>
          </span>
          @endif
        </div> 
  
        <div class="form-group col-md-6">
          <label><h6>CIN :</h6></label>
          <input type="number" class="form-control" name="cin" value="{{$employe->cin}}" placeholder="Entrer cin" min="0" >
          @if ($errors->has('cin'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('cin') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Telephone :</h6></label>
          <input type="number" class="form-control" name="telephone" value="{{$employe->telephone}}" placeholder="Entrer Telephone" min="0" >
          @if ($errors->has('telephone'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('telephone') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Adresse :</h6></label>
          <input type="text" class="form-control" name="adresse" value="{{$employe->adresse}}" placeholder="Entrer adresse">
          @if ($errors->has('adresse'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('adresse') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Date de Naissance :</h6></label>
          <input type="date" class="form-control" name="date_de_naissance" value="{{$employe->date_de_naissance}}" placeholder="Entrer date de naissance">
          @if ($errors->has('date_de_naissance'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('date_de_naissance') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Status :</h6></label>
          <input type="text" class="form-control" name="status" value="{{$employe->status}}"  placeholder="Entrer desription">
          @if ($errors->has('status'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('status') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Solde congé :</h6></label>
          <input type="number" class="form-control" name="solde_conge" value="{{$employe->solde_conge}}" placeholder="Entrer Solde de congé" min="0" >
          @if ($errors->has('solde_conge'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('solde_conge') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Salaire :</h6></label>
          <input type="number" class="form-control" name="salaire" value="{{$employe->salaire}}" placeholder="Entrer salaire" min="0" >
          @if ($errors->has('salaire'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('salaire') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-6">
          <label><h6>Login :</h6></label>
          <input type="email" class="form-control" name="login" value="{{$employe->login}}" placeholder="Entrer login">
          @if ($errors->has('login'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('login') }}</strong>
          </span>
          @endif
        </div>
  
        <div class="form-group col-md-12">
          <label><h6>Mot de passe :</h6></label>
          <input type="password" class="form-control" name="password" value="{{$employe->password}}" placeholder="Entrer Mot de passe">
          @if ($errors->has('password'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
        
      </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Modifier</button>
</form>

        <br><a href="/employes" class="w-100 btn btn-lg btn-success" >Annuler</a>

</main>

  </body>
</html>