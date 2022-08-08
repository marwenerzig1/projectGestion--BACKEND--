@extends('admin.base.Navfooter') 
@section('title','Administrateur') 
@section('text0','nav-item active')

@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')  

<style>
    #footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: red;
        color: white;
        text-align: center;
    }
    .interface{
        position: absolute; 
        left: 430px ;  
        top: 90px ; 
    }
    .bg-secondary{
        width: 800px ; 
        height: 100% ;
        position: relative;
        left:430px ; 
        top: 72px ; 
        border-radius: 10px ; 
    }
    #yy{
        padding: 15px ;
    }
    h6{
        color: white ; 
        position: relative; 
        left: 5px ; 
    }
    #b{
        padding: 12px;
        width: 100px ;
        position: relative ; 
        left: 50px ; 
        top: 93% ; 
    }
    .container{
        position: relative;
        left : -380px ; 
        top: 20px ; 
    }
    </style>


<div class="interface" >
    <a href="/modifierCompte" class="btn btn-secondary" id="yy">Modifier Compte</a>
    <a href="/modifierMotdePasse" class="btn btn-light">Change Mot de Passe</a>
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
</div>

<div class="bg-secondary" id="bb">
    <form name="myForm"  action="{{route('compte.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf 
        @method('PATCH')
        <div class="form-group col-md-6">
            <br>
          <label><h6>Nom :</h6></label>
          <input type="text" class="form-control" name="nom" value="{{$admin->nom}}" placeholder="Nom">
          @if ($errors->has('nom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('nom') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group col-md-6">
          <label><h6>Prenom :</h6></label>
          <input type="text" class="form-control" name="prenom" value="{{$admin->prenom}}" placeholder="Prenom">
          @if ($errors->has('prenom'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('prenom') }}</strong>
          </span>
          @endif
        </div> 
        @if(session('id_RH') != -1)
        <div class="form-group col-md-6">
            <label><h6>Cin :</h6></label>
            <input type="number" class="form-control" name="cin" value="{{$admin->cin}}" placeholder="Cin">
            @if ($errors->has('cin'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('cin') }}</strong>
            </span>
            @endif
        </div> 
  
        <div class="form-group col-md-6">
            <label><h6>Telephone :</h6></label>
            <input type="number" class="form-control" name="telephone" value="{{$admin->telephone}}" placeholder="Entrer Telephone">
            @if ($errors->has('telephone'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('telephone') }}</strong>
            </span>
            @endif
          </div>
    
          <div class="form-group col-md-6">
            <label><h6>Adresse :</h6></label>
            <input type="text" class="form-control" name="adresse" value="{{$admin->adresse}}" placeholder="Entrer adresse">
            @if ($errors->has('adresse'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('adresse') }}</strong>
            </span>
            @endif
          </div>
    
          <div class="form-group col-md-6">
            <label><h6>Date de Naissance :</h6></label>
            <input type="date" class="form-control" name="date_de_naissance" value="{{$admin->date_de_naissance}}" placeholder="Entrer date de naissance">
            @if ($errors->has('date_de_naissance'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('date_de_naissance') }}</strong>
            </span>
            @endif
          </div>
        @endif
        <div class="form-group col-md-6">
          <label><h6>Login :</h6></label>
          <input type="email" class="form-control" name="login" value="{{$admin->login}}" placeholder="Login">
          @if ($errors->has('login'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('login') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group col-md-6">
          <label><h6>Mot de passe :</h6></label>
          <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Mot de passe">
          @if ($errors->has('password'))
          <span class="help-block">
              <strong style="color: red" >{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
            <br><center><button type="submit" class="btn btn-primary" id="b" >Modifier</button></center><br>
        </form>
</div> <br><br><br><br><br><br><br><br>

@endsection
