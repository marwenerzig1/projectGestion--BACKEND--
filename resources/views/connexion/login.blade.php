<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connexion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>

<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .main-head{
        height: 150px;
        background: #FFF;
    
    }

    .sidenav {
        height: 100%;
        background-color: #000;
        overflow-x: hidden;
        padding-top: 20px;
    }


    .main {
        padding: 0px 10px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}

    }

    @media screen and (max-width: 450px) {
        .login-form{
            margin-top: 10%;
        }

        .register-form{
            margin-top: 10%;
        }

    }

    @media screen and (max-width: 1499px) {
        .main{
            margin-left: 6%; 
            margin-top: 25% ;  
            width: 90% ; 
        }
    }

    @media screen and (min-width: 768px){
        .main{
            margin-left: 50%; 
            margin-top: -6%;
            width: 50% ;  
        }

        .sidenav{
            width: 40%;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .login-form{
            margin-top: 80%;
        }

        .register-form{
            margin-top: 20%;
        }
    }


    .login-main-text{
        margin-top: 20%;
        padding: 60px;
        color: #fff;
        position: relative;
        top: -180px; 
    }

    .login-main-text h2{
        font-weight: 300;
    }

    .btn-black{
        background-color: #000 !important;
        color: #fff;
    }



    .container{
        position: relative; 
        left: 600px ; 
        top: 120px ; 
    } 

    #btnn{
        position: relative;
        top : 10px ; 
    }

    

</style>


<nav>
    <div class="sidenav">
        <div class="login-main-text">
        <img src="{{ asset('images/logo.png') }}" alt="tag" width="100%" height="100%" style="margin-top: 120px; margin-bottom:20px; ">
           <h3>Application dédiée au pointage des ressources et la gestion des conges . <br><br>Page de connexion</h3>
           <p><br>Connectez-vous à partir d'ici pour accéder.</p> 
        </div>
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


     <div class="main">
        <div class="col-md-6 col-sm-12">
           <div class="login-form">
            <div class="title">
                <center><h3 style="font-family: cursive">S'identifier</h3><br></center>
            </div>
            <form name="myForm"  action="{{route('connexion.store')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                 <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="email" name="login" class="form-control" value="{{ old('login') }}" placeholder="Nom d'utilisateur">
                    @if ($errors->has('login'))
                    <span class="help-block">
                        <br><strong style="color: red">{{ $errors->first('login') }}</strong>
                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Mot de passe">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <br><strong style="color: red">{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                 </div>
                <center> <button type="submit" class="btn btn-black" style="font-size: 20px" >Connexion</button> </center> <br> 
              </form>
           </div>
        </div>
     </div>
</nav>



</body>
</html>