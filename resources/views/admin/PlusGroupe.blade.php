<!DOCTYPE html>
<html>
<head>
    <title>Consulter Groupe</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

* {
  box-sizing: border-box;
}

.bg-image {
  
  /* Add the blur effect */
  filter: blur(8px);
  -webkit-filter: blur(8px);
  
  /* Full height */
  height: 100%; 
  
  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* Position text in the middle of the page/image */
.bg-text {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  border: 3px solid #000000;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  width: 80%;
  padding: 20px;
}
.txt{
    text-align: center;
}
.vv{
    margin-left: 10px ; 
    color: #000000 ; 
}

</style>
</head>
<body>

<div class="bg-image">
    <img src="{{ asset('images/background_flou.png') }}" alt="tag" width="100%" height="100%">
</div>


<div class="bg-text">
    <div class="txt">
        @foreach ( $groupes as $groupe )
            <h2 class="mb-0">Nom de Projet : {{$groupe->nom_projet}}</h2>
            <h1>Responsable : {{$groupe->nom}} {{$groupe->prenom}}</h1>
            <p class="mb-2" style="font-size: 19px">Description : {{$groupe->description}} </p>
        @endforeach
    </div>

    <h3 class="vv">Les membres du groupe : </h3>
   
    @if($membres->isNotEmpty())
    <div class="container">
      <div class="row text-center">
            @foreach ($membres as $membre)
            <div class="col-xl-3 col-sm-6 mb-5">
              <div class="bg-WhiteSmoke rounded shadow-sm py-5 px-4">
                  <img src="{{ asset('images/icon2.png') }}" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                  @if ($membre->etat == 0)
                    <h5 class="mb-0">{{$membre->nom}} {{$membre->prenom}}</h5><span class="small text-uppercase ">EMPLOYE - {{$membre->status}}</span>
                  @elseif ($membre->etat == 1)
                    <h5 class="mb-0">{{$membre->nom}} {{$membre->prenom}}</h5><span class="small text-uppercase ">RESPONSABLE - {{$membre->status}}</span>
                  @elseif ($membre->etat == 3)
                  <h5 class="mb-0">{{$membre->nom}} {{$membre->prenom}}</h5><span class="small text-uppercase ">RESPONSABLE RH - {{$membre->status}}</span>
                  @endif
              </div>
            </div>
            @endforeach
            <br> <br> <br> <br> <br> <br>
      </div>
    </div>      
    @else
        <br> 
        <h4 class="d">Il n'y a aucun membres ! </h4> 
    @endif 


    <div class="txt">
        <a class="btn btn-warning btn-danger" href="/groupes"> Terminer </a>
    </div>

</div>

</body>
</html>