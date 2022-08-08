@extends('admin.base.Navfooter') 
@section('title','Traitement de conge') 
@section('text5','nav-item active')


@section('content2')
<p class="pp"> {{session('nom')}} {{session('prenom')}}</p>
@endsection

@section('content')

<style>
    .timeline {
        border-left: 3px solid #727cf5;
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
        background: rgba(114, 124, 245, 0.09);
        margin: 0 auto;
        letter-spacing: 0.2px;
        position: relative;
        line-height: 1.4em;
        font-size: 1.03em;
        padding: 50px;
        list-style: none;
        text-align: left;
        max-width: 40%;
    }

    @media (max-width: 767px) {
        .timeline {
            max-width: 98%;
            padding: 25px;
        }
    }

    .timeline h1 {
        font-weight: 300;
        font-size: 1.4em;
    }

    .timeline h2,
    .timeline h3 {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .timeline .event {
        border-bottom: 1px dashed #e8ebf1;
        padding-bottom: 25px;
        margin-bottom: 25px;
        position: relative;
    }

    @media (max-width: 767px) {
        .timeline .event {
            padding-top: 30px;
        }
    }

    .timeline .event:last-of-type {
        padding-bottom: 0;
        margin-bottom: 0;
        border: none;
    }

    .timeline .event:before,
    .timeline .event:after {
        position: absolute;
        display: block;
        top: 0;
    }

    .timeline .event:before {
        left: -207px;
        content: attr(data-date);
        text-align: right;
        font-weight: 100;
        font-size: 0.9em;
        min-width: 120px;
    }

    @media (max-width: 767px) {
        .timeline .event:before {
            left: 0px;
            text-align: left;
        }
    }

    .timeline .event:after {
        -webkit-box-shadow: 0 0 0 3px #727cf5;
        box-shadow: 0 0 0 3px #727cf5;
        left: -55.8px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 5px;
    }

    @media (max-width: 767px) {
        .timeline .event:after {
            left: -31.8px;
        }
    }

    .rtl .timeline {
        border-left: 0;
        text-align: right;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 4px;
        border-top-left-radius: 4px;
        border-right: 3px solid #727cf5;
    }

    .rtl .timeline .event::before {
        left: 0;
        right: -170px;
    }

    .rtl .timeline .event::after {
        left: 0;
        right: -55.8px;
    }
    .container{
        position: relative;
        top: 40px ;
    }
    .accepter{
        color: green ; 
    }
    .refuser{
        color: red ; 
    }
    .encours{
        color: rgb(39, 39, 39) ; 
    }
    .txt{
        margin-top: 5px ; 
    }
</style>

<article>  
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Traitement de congé :</h6>
                        <div id="content">
                            <ul class="timeline">
                                        @foreach ( $responsables as $responsable )
                                        <li class="event" data-date="">
                                            <h3 class="encours">En Cours</h3>
                                            <p>{{$responsable->nom}} {{$responsable->prenom}}</p>
                                        </li>
                                        @endforeach
                                        @foreach ( $responsables_etat as $responsable )
                                        <li class="event" data-date="{{$responsable->updated_at}}">
                                            @if ($responsable->etat == 0)
                                            <h3 class="accepter">Accepter</h3>
                                            @elseif ($responsable->etat == 1)
                                            <h3 class="refuser">Refuser</h3>
                                            @endif
                                            <p>{{$responsable->nom}} {{$responsable->prenom}}</p>
                                        </li>
                                        @endforeach
                                        @if ($verif == 1 )
                                            <li class="event" data-date="Etat congé : {{$conge}}">
                                                <a class="btn btn-success btn-sm" href="/accepterConge/{{$id_conge}}" ><i class="fa fa-check-circle-o"></i> Accepter </a>
                                                <a class="btn btn-danger btn-sm" href="/refuserConge/{{$id_conge}}" ><i class="fa fa-times"></i> Refuser </a>
                                                <p class="txt">{{session('nom')}} {{session('prenom')}}</p>
                                            </li>      
                                        @else
                                            <li class="event" data-date="Etat congé : {{$conge}}">
                                                <p class="txt">{{session('nom')}} {{session('prenom')}}</p>
                                            </li>     
                                        @endif
                   
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<br>

@endsection