@extends('admin.base.Navfooter') 
@section('title','Administrateur') 
@section('text0','nav-item active')

@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')
<style>

    @media screen and (max-width: 1499px) {
           #rows{
                margin-left: 14% ; 
           }
    }

    @media screen and (min-width: 768px){
            .containerr{
                width: 100% ;
            }
            #rows{
                width: 98% ;
                margin-left: 0px ; 
            }
    }

    .containerr{
        position: relative ; 
        left: 40px ; 
        top: 20px ; 
    }
    #bloc1{
        width: 310px ; 
        height: 150px;
        background-color: #2C6975 ; 
    }
    #bloc2{
        width: 310px ; 
        height: 150px;
        background-color: #68B2A0 ; 
    }
    #bloc3{
        width: 310px ; 
        height: 150px;
        background-color: #b4e7ad ; 
    }
    #bloc4{
        width: 310px ; 
        height: 150px;
        background-color: #ceccb4 ; 
    }
    #bloc11{
        width: 310px ; 
        height: 150px;
        background-color: #194568 ; 
    }
    #bloc22{
        width: 310px ; 
        height: 150px;
        background-color: #546CBC ; 
    }
    #bloc33{
        width: 310px ; 
        height: 150px;
        background-color: #8895B1 ; 
    }
    #bloc44{
        width: 310px ; 
        height: 150px;
        background-color: #BCC2D7 ; 
    }
    .yy{
        color:white ; 
        position: relative ;
    }
    .yy:hover{
        text-decoration: none ;
        color: white ; 
    }
    .mb-0{
        position: relative ; 
        top: 12px ; 
    }
    .petite_text1{
        margin-top: 30px ; 
        color: #aeb1b1 ; 
    }
    .petite_text{
        margin-top: 30px ; 
        color: #6A6E6E ; 
    }
    .courbe1{
        width: 40% ; 
    }
    .courbe2{
        width: 20% ;   
    }
    .courbe3{
        width: 20% ;   
    }
    #jj{
        margin-left: -90px
    }

</style>

<div class="containerr"  >
    <h3>Congés : </h3> <br>
    <div class="d-flex justify-content-around" >
        <div class="courbe1" >
            <canvas id="myChart"></canvas>
        </div>
        <div class="courbe4" style="width: 550px">
            <canvas id="myChart4"></canvas>
        </div>
    </div>
    <h3>Ressources : </h3> <br>
    <div class="d-flex justify-content-around"  id="jj" >
        <div class="courbe5" style="width: 550px" >
            <canvas id="myChart5"></canvas>
        </div>
        <div class="courbe3" >
            <canvas id="myChart3"></canvas>
        </div>
    </div>
    <div class="d-flex justify-content-around" >
        <h3 style="margin-left: -148px">Pointage : </h3> <br>
        <h3>Disponibilité Actuelle : </h3> <br>
    </div>
    <div class="d-flex justify-content-around" id="jj" >
        <div class="courbe6" style="width: 550px" >
            <canvas id="myChart6"></canvas>
        </div>
        <div class="courbe2" >
            <canvas id="myChart2"></canvas>
        </div>
    </div>
    <h3>Ressources Humaines : </h3> <br>
    <div class="row" style="display: flex; justify-content: center;" id="rows" >
        <div class="row text-center" >
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/employes" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc1">
                        <h5 class="mb-0">Employés</h5>
                        <p class="petite_text1">Nombre des Employés : {{$employe}}</p>
                    </div>
                </a>
            </div>      
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/responsable_RH" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc2">
                        <h5 class="mb-0">Responsables RH</h5>
                        <p class="petite_text">Nombre des Responsables RH : {{$responsable_RH}}</p>
                    </div>
                </a>
            </div>      
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/responsable" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc3">
                        <h5 class="mb-0">Responsables</h5>
                        <p class="petite_text">Nombre des Responsables : {{$responsable}}</p>
                    </div>
                </a>
            </div>                             
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/groupes" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc4">
                        <h5 class="mb-0">Groupes</h5>
                        <p class="petite_text">Nombre des Groupes : {{$groupe}}</p>
                    </div>
                </a>
            </div>                                                          
        </div>
    </div>
</div> 

<div class="containerr">
    <h3>Autres Fonctionnalités : </h3> <br>
    <div class="row" style="display: flex; justify-content: center;" id="rows" >
        <div class="row text-center">
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/disponibilite" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc11">
                        <h5 class="mb-0">Disponibilité Actuelle</h5> 
                    </div>
                </a>
            </div>      
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/emploiDeTempsSpecifique/1/0/0" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc22">
                        <h5 class="mb-0">Pointage</h5>
                    </div>
                </a>
            </div>      
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/conges/vide/0/0" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc33">
                        <h5 class="mb-0">Demandes De Congés</h5>
                    </div>
                </a>
            </div>                             
            <div class="col-xl-3 col-sm-6 mb-5">
                <a href="/configurationDays" class="yy">
                    <div class="rounded shadow-sm py-5 px-4" id="bloc44">
                        <h5 class="mb-0">Configuration</h5>
                    </div>
                </a>
            </div>                                                          
        </div>
    </div>
</div> 
<br><br>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
  
    var labels =  {{ Js::from($labels) }};
    var labels_pointage =  {{ Js::from($labels_pointage) }};
    var conge_encours =  {{ Js::from($data_encours) }};
    var conge_accepter =  {{ Js::from($data_accepter) }};
    var conge_refuser =  {{ Js::from($data_refuser) }};
    var data_line =  {{ Js::from($data_line) }};
    var absences =  {{ Js::from($tableau_absences) }};
    var precences =  {{ Js::from($tableau_precences) }};
    var precences_moins =  {{ Js::from($tableau_precences_moins) }};

    console.log(conge_encours) ; 
  
    const data1 = {
        labels: labels,
        datasets: [{
            label: 'Congés en cours',
            data: conge_encours,
            backgroundColor: 'rgb(255, 205, 86)',
            borderColor: '#fffff',
            borderWidth : 1 , 
            order : 1
        },
        {
            label: 'Congés acceptés',
            data: conge_accepter,
            backgroundColor: 'rgb(54, 162, 235)',
            borderColor: '#fffff',
            borderWidth : 1 ,
            order : 2
        },
        {
            label: 'Congés refusés',
            data: conge_refuser,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: '#fffff',
            borderWidth : 1 , 
            order : 3
        }]
    };

    const data_pointage = {
        labels: labels_pointage,
        datasets: [{
            label: 'Absences',
            data: absences,
            backgroundColor: '#EC3027',
            borderColor: '#fffff',
            borderWidth : 1 , 
            order : 1
        },
        {
            label: 'Presences',
            data: precences ,
            backgroundColor: '#3ADC14',
            borderColor: '#fffff',
            borderWidth : 1 ,
            order : 2
        },
        {
            label: 'Precences (Temps n est pas terminer)',
            data: precences_moins,
            backgroundColor: '#ECAA27',
            borderColor: '#fffff',
            borderWidth : 1 , 
            order : 3
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1 ,
        options: {
            scales: {
          y: {
            beginAtZero: true
          }
        }
        }
    }
    
    const config_pointage = {
        type: 'bar',
        data: data_pointage ,
        options: {
            scales: {
          y: {
            beginAtZero: true
          }
        }
        }
    }
    
    const data_linee = {
        labels: labels,
        datasets: [{
            label: 'Congés',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: data_line,
        },
    ]
    };

    const config4 = {
        type: 'line',
        data: data_linee ,
        options: {
            scales: {
          y: {
            beginAtZero: true , 
          }
        }
        }
    }

    const data2 = {
        labels: [
            'Indesponible',
            'Disponible',
        ],
        datasets: [{
            label: 'Disponibilé Actuelle',
            data: [{{ Js::from($nbr_employe_absence) }},{{ Js::from($nbr_employe_presences) }} ],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
        }]
    };

    const config2 = {
        type: 'pie',
        data: data2,
    };
  
    const data3 = {
        labels: [
            'Employés',
            'Responsables RH',
            'Responsables des groupes'
        ],
        datasets: [{
            label: 'Ressources Humaines',
            data: [{{ Js::from($employe) }},{{ Js::from($responsable_RH) }} , {{ Js::from($responsable) }}],
            backgroundColor: [
            '#194568',
            '#546CBC',
            '#8895B1'
            ],
            borderColor: '#000',
            hoverOffset: 4
        }]
    };
    const config3 = {
        type: 'doughnut',
        data: data3,
    };
    const config_bar = {
        type: 'bar',
        data: data3,
    };
  
    const myChart = new Chart(
        document.getElementById('myChart'),
        config1
    );
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );
    const myChart4 = new Chart(
        document.getElementById('myChart4'),
        config4
    );
    const myChart5 = new Chart(
        document.getElementById('myChart5'),
        config_bar
    );
    const myChart6 = new Chart(
        document.getElementById('myChart6'),
        config_pointage
    );
  
</script>


@endsection