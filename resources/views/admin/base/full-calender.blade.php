<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Emploi de temps specifique mode calender</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
</head>
<body>
<style>
    .fc-toolbar .fc-state-active , .fc-toolbar .ui-state-active{
        background-color: '#C8C9C4'; 
    }
    .fc-title{
        font-weight: 800 ; 
    }
    .fc-event-container{
        background-color: white ; 
    }
</style>
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
    .filtre{
        margin-left: 40px ; 
        margin-top: 20px ; 
    }
    #pp{
        margin-left: 10px ; 
        margin-top: -20px ; 
    }
    #btn{
        margin-left: 15px ; 
        position: relative;
        top: -9.8px ; 
    }
    .ligne{
        width: 95% ; 
        margin-top: 4px ; 
    }
    .container_calendar{
        width: 40% ; 
        height: 40% ;
        position: relative; 
        left: 750px;
    }
    .box1{
        background-color: #3ADC14 ; 
        width: 100px ; 
        height: 50px ;
        float: left;
    }
    .box1_1{
        position: relative; 
        left: 20px ; 
        top: 10px ; 
    }
    .box2{
        background-color: #ECAA27 ; 
        width: 100px ; 
        height: 50px ;
        float: left;
    }
    .box2_2{       
        position: relative; 
        left: 20px ; 
    }
    .box3{
        background-color: #EC3027 ; 
        width: 100px ; 
        height: 50px ;
        float: left;
    }
    .box4{
        background-color: #fff ; 
        border-style: solid ; 
        width: 100px ; 
        height: 50px ;
        float: left;
    }
    .box3_3{       
        position: relative; 
        left: 20px ; 
        top: 10px ; 
    }
    .information{
        position: absolute ; 
        left: 40px ; 
        top: 400px ; 
    }
    .button{
        margin-top: 30px ; 
    }
    #btn1{
        padding: 10px ; 
        width: 500px ; 
    }
    #btn2{
        padding: 10px ; 
        width: 500px ; 
    }

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="#"> <img  src="{{ asset('images/logo.png') }}" alt="tag" width="250px" height="80%"> </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" >
                <a class="nav-link" href="/tableau-de-bord">Tableau de bord<span class="sr-only">(current)</span></a>
            </li>
            <li class="dropdown" >
                <a class="nav-link" href="#">Ressources Humaines<span class="sr-only">(current)</span></a>
                <div class="dropdown-content">
                    <a href="/employes" class="txt">Employés</a>
                    <a href="/responsable_RH" class="txt">Responsables RH</a>
                    <a href="/responsable" class="txt">Responsables des groupes</a>
                </div>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="/groupes">Groupes<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="/disponibilite">Disponibilité Actuelle<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active" >
                <a class="nav-link" href="/emploiDeTempsSpecifique/1/0/0">Emploi Du Temps<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item" >
                <a class="nav-link" href="/conges/vide/0/0">Demandes De Congés<span class="sr-only">(current)</span></a>
            </li>
            <li class="dropdown" >
                <a class="nav-link" href="#">Configuration<span class="sr-only">(current)</span></a>
                <div class="dropdown-content">
                    <a href="/configurationDays" class="txt">Configuration de planification</a>
                    <a href="/configurationPointage" class="txt">Configuration de pointage</a>
                </div>
            </li>
        </ul>

            <div class="dropdown" >   
                <div class="form-inline my-2 my-lg-0" >   
                <img src="{{ asset('images/icon.png') }}" alt="tag" width="50px" height="50px">
                <p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
                </div>
                <div class="dropdown-content">
                    <a href="/modifierCompte" class="txt" id="btn"><i class="fa fa-edit"></i> Gérer Compte</a>
                    <a href="/connexion" class="txt"><i class="fa-solid fa-right-from-bracket"></i> Deconnexion</a>
                </div>
            </div>
    </div>
</nav>


<center>
    <div class="button"> 
    <a class="btn btn-outline-secondary" id="btn1" href="/emploiDeTempsSpecifique/1/0/0" > <i class="fa fa-table"></i> Tableau </a>
    <a class="btn btn-secondary" id="btn2" href="" > <i class="fa fa-calendar-o"></i> Calendrier </a>
    </div>
</center>


<div class="filtre">
    <form class="form-inline my-2 my-lg-0" action="{{route('calender.filtre')}}" method="POST" enctype="multipart/form-data">
        @csrf 
        <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
        <select class="js-example-basic-multiple form-control" id="pp" name="employe" >
            @if($employe != null )
                <option value={{$employe->id}}>{{$employe->nom}} {{$employe->prenom}}</option>
                @foreach ($employes as $employee)
                @if($employee->id != $employe->id )
                    <option value={{$employee->id}}>{{$employee->nom}} {{$employee->prenom}}</option>
                @endif
                @endforeach
            @endif
        </select> 
        <button class="btn btn-outline-primary my-2 my-sm-0" id="btn" type="submit">Valider</button>
        <hr class="ligne">
    </form>
</div>

<div class="information"> 
    <div class="box1"></div><h4 class="box1_1">Precences</h4> <br>
    <div class="box2"></div><h4 class="box2_2">Precences (Temps n'est pas terminer)</h4> <br>
    <div class="box3"></div><h4 class="box3_3">Absences</h4><br>
    <div class="box4"></div><h4 class="box2_2">Weekend ou Employé ne respecte pas son pointage</h4>
</div>

<div class="container_calendar">
    <div id="calendar"></div>
</div>
<br><br>

<footer class="bg-dark text-center text-white" id="footer">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <a class="text-white" href="#">Gestion.com</a>
    </div>
</footer>
   
<script>

$(document).ready(function () {

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#calendar').fullCalendar({
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events:'/full-calender/'+{{$employe->id}},
    });

});
  
</script>
  
</body>
</html>
