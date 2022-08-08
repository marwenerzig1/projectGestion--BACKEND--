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
        height: 490px ;
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
        position: absolute ; 
        left: 360px ; 
        top: 400px ; 
    }
    .container{
        position: relative;
        left : -380px ; 
        top: 20px ; 
    }
    </style>



<div class="interface" >
    <a href="/modifierCompte" class="btn btn-light" >Modifier Compte</a>
    <a href="/modifierMotdePasse" class="btn btn-secondary" id="yy">Change Mot de Passe</a>
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
    <form name="myForm"  action="{{route('motdepasse.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        @method('PATCH') 
          <div class="form-group col-md-6">
            <br>
            <label><h6>Ancien Mot de passe :</h6></label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Ancien mot de passe">
            @if ($errors->has('password'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group col-md-6">
            <label><h6>Nouveau Mot de passe :</h6></label>
            <input type="password" class="form-control" name="nouveau_password" value="{{ old('nouveau_password') }}" placeholder="Nouveau mot de passe">
            @if ($errors->has('nouveau_password'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('nouveau_password') }}</strong>
            </span>
            @endif
          </div> 
          <div class="form-group col-md-6">
            <label><h6>Confirmation Mot de passe :</h6></label>
            <input type="password" class="form-control" name="confirmation_password" value="{{ old('confirmation_password') }}" placeholder="Confirmation mot de passe">
            @if ($errors->has('confirmation_password'))
            <span class="help-block">
                <strong style="color: red" >{{ $errors->first('confirmation_password') }}</strong>
            </span>
            @endif
          </div>
          <br><center><button type="submit" class="btn btn-primary" id="b" >Modifier</button></center><br>
        </form>
</div>

@endsection