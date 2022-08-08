@component('mail::message')
# Application dédiée au pointage des ressources et la gestion des conges .

Hello {{session('nom_email')}} {{session('prenom_email')}} ! . <br>
your Login is : {{session('login_email')}} <br>
your Password is : {{session('password_email')}} 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
