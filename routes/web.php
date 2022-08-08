<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\CongesController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\ConfigurationPointageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//connexion et deconnection 
Route::get('/connexion', function () {
    return view('connexion.login');
}); 

Route::post('/connexion', [AdminController::class, 'store'])->name('connexion.store'); 

Route::get('/deconnexion', function () {
    session()->forget('login');
    return redirect('connexion'); 
});



//securite

Route::group(['middleware' =>['adminAuth']],function(){

Route::get('/tableau-de-bord', [AdminController::class, 'count']) ; 
Route::get('/modifierCompte', [AdminController::class, 'create'])->name('admin') ; 
Route::get('/modifierMotdePasse', [AdminController::class, 'create2'])->name('admin') ; 
Route::match(['put', 'patch'],'/modifiercompte', [AdminController::class, 'updateCompte'])->name('compte.update');
Route::match(['put', 'patch'],'/modifiermotdepasse', [AdminController::class, 'updateMotDePasse'])->name('motdepasse.update');
Route::get('/employes', [AdminController::class, 'create3'])->name('employes') ;
Route::get('/deleteEmploye/{id}', [AdminController::class, 'destroy']) ;
Route::post('/ajouteEmploye', [AdminController::class, 'AjouterEmploye'])->name('employe.AjouterEmploye'); 
Route::match(['put', 'patch'],'/modifierEmploye/{id}', [AdminController::class, 'updateEmploye'])->name('employe.ModifierEmploye');
Route::get('/modifier_Employe/{id}', [AdminController::class, 'edit']) ;
Route::post('/employes', [AdminController::class, 'ChercherEmploye'])->name('employe.ChercherEmploye');
Route::get('/responsable_RH', [AdminController::class, 'create4'])->name('employes','employess') ;
Route::post('/responsable_RH', [AdminController::class, 'ChercherResponsableRH'])->name('employe.ChercherResponsableRH');
Route::get('/AnnulerResponsableRH/{id}', [AdminController::class, 'AnnulerResponsableRH']) ;
Route::post('/ajouteResponsableRH', [AdminController::class, 'AjouterResponsableRH'])->name('responsable_RH.AjouterResponsableRH'); 
Route::get('/responsable', [AdminController::class, 'create5'])->name('employes','employess') ;
Route::post('/responsable', [AdminController::class, 'ChercherResponsable'])->name('employe.ChercherResponsable');
Route::get('/AnnulerResponsable/{id}', [AdminController::class, 'AnnulerResponsable']) ;
Route::post('/ajouteResponsable', [AdminController::class, 'AjouterResponsable'])->name('responsable_RH.AjouterResponsable'); 
Route::get('/groupes', [AdminController::class, 'Groupe'])->name('groupes') ;
Route::post('/groupes', [AdminController::class, 'ChercherGroupe'])->name('groupe.ChercherGroupe');
Route::get('/ConsulterGroupe/{id}', [AdminController::class, 'ConsulterGroupe'])->name('groupes','membres') ; 
Route::get('/emploiDeTempsSpecifique/{id}/{date_dep}/{date_fin}', [AdminController::class, 'getemploiSP'])->name('employes','pointages') ; 
Route::post('/emploiDeTempsSpecifique', [AdminController::class, 'FiltreEmploiSP'])->name('employe.filtre'); 
Route::match(['put', 'patch'],'/modifierPointage/{id}', [AdminController::class, 'updatePointage'])->name('ModifierPointage');
Route::get('/disponibilite', [AdminController::class, 'Disponibilite'])->name('pointages') ; 
Route::get('/configurationDays', [DaysController::class, 'create'])->name('days') ; 
Route::match(['put', 'patch'],'/modifierconfigurationDays/{id}', [DaysController::class, 'updateDays'])->name('days.updateDays');
Route::get('/conges/{id}/{date_dep}/{date_fin}', [CongesController::class, 'getcongeSP'])->name('employes','pointages') ; 
Route::post('/conges', [CongesController::class, 'FiltreCongeSP'])->name('conges.DemanderConge'); 
Route::get('/traitementConge/{id_conge}/{id_employe}', [CongesController::class, 'traitementConges'])->name('responsables','responsables_etat') ;
Route::get('/accepterConge/{id_conge}', [CongesController::class, 'AccepterConge']) ;
Route::get('/refuserConge/{id_conge}', [CongesController::class, 'RefuserConge']) ;
Route::get('full-calender/{id}', [FullCalenderController::class, 'index']);
Route::post('full-calender/action', [FullCalenderController::class, 'action'])->name('calender.filtre');

Route::get('/configurationPointage', [ConfigurationPointageController::class, 'create'])->name('configurations') ; 
Route::match(['put', 'patch'],'/modifierconfigurationPointage/{id}', [ConfigurationPointageController::class, 'updateConfigurationPointage'])->name('configurations.updateConfigurationPointage');


});

//map

Route::get('/map', function () {
    return view('admin.map');
}); 


//calendar 

