<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','title inconnu')</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

<style>
        body {font-family: Arial, Helvetica, sans-serif;}
        
        /* The Modal (background) */
        .modal{
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
        .modal-content  {
          background-color: #fefefe;
          margin: auto;
          padding: 20px;
          border: 1px solid #888;
          width: 40%;
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
        .close2 {
          color: #aaaaaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }
        
        .close2:hover,
        .close2:focus {
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
        #b{
            width: auto ; 
            height: auto ; 
        }
</style>
<style>
    .liste {
    padding-top: 50px;
    padding-right: 30px;
    padding-bottom: 50px;
    padding-left: 80px;
    }
    
    
    .footer{
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height:100px;
    background:#ccc;
    }
    
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    
    .dropdown-content a:hover {
        background-color: #ddd;
    }
    
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .pp{
        font-size: 20px ; 
        color: white ; 
        position: relative; 
        top:6px ; 
        left: 4px ;
    }

    .txt{
        font-size: 15px ;
    }
    
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .recherche{
        position: relative ; 
        left: -140px ; 
    }
    footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;
    }
    @media screen and (max-width: 1499px) {
        nav{
            width: 100% ; 
        }
        footer{
            width: 100% ; 
        }
        .bloc{
            width: 80%;
        }


    }


    @media screen and (min-width: 768px){
        nav{
            width: 100% ; 
        }
        footer{
            width: 100% ; 
        }
        .bloc{
            width: 95%;
        }
        #uu{
           font-size: 90% ; 
        }
    }
</style>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="#"> <img src="{{ asset('images/logo.png') }}" alt="tag" width="250px" height="80%"> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" id="uu">
                <li class="@yield('text0','nav-item')" >
                    <a class="nav-link" href="/tableau-de-bord">Tableau de bord<span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('text1','dropdown')" >
                    <a class="nav-link" href="#">Ressources Humaines<span class="sr-only">(current)</span></a>
                    <div class="dropdown-content">
                        <a href="/employes" class="txt">Employés</a>
                        <a href="/responsable_RH" class="txt">Responsables RH</a>
                        <a href="/responsable" class="txt">Responsables des groupes</a>
                    </div>
                </li>
                <li class="@yield('text2','nav-item')" >
                    <a class="nav-link" href="/groupes">Groupes<span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('text3','nav-item')" >
                    <a class="nav-link" href="/disponibilite">Disponibilité Actuelle<span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('text4','nav-item')" >
                    <a class="nav-link" href="/emploiDeTempsSpecifique/1/0/0">Pointage<span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('text5','nav-item')" >
                    <a class="nav-link" href="/conges/vide/0/0">Demandes De Congés<span class="sr-only">(current)</span></a>
                </li>
                <li class="@yield('text6','dropdown')" >
                    <a class="nav-link" href="#">Configuration<span class="sr-only">(current)</span></a>
                    <div class="dropdown-content">
                        <a href="/configurationDays" class="txt">Configuration de planification</a>
                        <a href="/configurationPointage" class="txt">Configuration de pointage</a>
                    </div>
                </li>
            </ul>

            <div class="recherche">
                @yield('recherche') 
            </div>
            

                <div class="dropdown" >   
                    <div class="form-inline my-2 my-lg-0" >   
                    <img src="{{ asset('images/icon.png') }}" alt="tag" width="50px" height="50px">
                    @yield('content2')
                    </div>
                    <div class="dropdown-content">
                        <a href="/modifierCompte" class="txt" id="btn"><i class="fa fa-edit"></i> Gérer Compte</a>
                        <a href="/deconnexion" class="txt"><i class="fa-solid fa-right-from-bracket"></i> Deconnexion</a>
                    </div>
                </div>
        </div>
    </nav>

<div class="bloc">
    @yield('content')
</div>

@yield('br')
     
    <footer class="bg-dark text-center text-white" id="footer">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright:
            <a class="text-white" href="#">Gestion.com</a>
        </div>
    </footer>

</body>
</html>