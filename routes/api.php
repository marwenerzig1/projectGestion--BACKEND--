<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeAPIController;
use App\Http\Controllers\GroupeAPIController;
use App\Http\Controllers\DaysAPIController;
use App\Http\Controllers\PointageAPIController;
use App\Http\Controllers\CongesAPIController;
use App\Http\Controllers\ConfigurationPointageAPIController;
use App\Http\Controllers\NotificationAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//connexion
Route::post('connexion', [EmployeAPIController::class, 'storeAPI']); //c bn 

//admin
Route::get('getcount', [EmployeAPIController::class, 'countAPI']);
Route::get('getEmploye', [EmployeAPIController::class, 'getEmployeAPI']);
Route::get('getEmploye2', [EmployeAPIController::class, 'getEmploye2API']);
Route::post('ModifierPersonne', [EmployeAPIController::class, 'ModifierPersonneAPI']);
Route::post('addUser', [EmployeAPIController::class, 'AddUserAPI']);
Route::delete('DeletePersonne', [EmployeAPIController::class, 'destroyAPI']);
Route::get('getResponsable', [EmployeAPIController::class, 'getResponsableAPI']);
Route::get('getResponsableRH', [EmployeAPIController::class, 'getResponsableRHAPI']);
Route::delete('DeleteResponsable', [EmployeAPIController::class, 'destroyResponsableAPI']);
Route::post('AjouterResponsable', [EmployeAPIController::class, 'AjouterResponsableAPI']);
Route::post('AjouterResponsableRH', [EmployeAPIController::class, 'AjouterResponsableRHAPI']);

//responsable 
Route::post('AjouterGroupe', [GroupeAPIController::class, 'AjouterGroupeAPI']);
Route::post('getgroupeResponsable', [GroupeAPIController::class, 'getgroupeResponsableAPI']);
Route::get('getAllgroupe', [GroupeAPIController::class, 'getAllgroupeAPI']);
Route::delete('DeleteGroupe' , [GroupeAPIController::class, 'DeleteGroupeAPI']);
Route::post('ModifierGroupe' , [GroupeAPIController::class, 'ModifierGroupeAPI']); 
Route::post('getMembregroupe' , [GroupeAPIController::class, 'getMembregroupeAPI']); 
Route::post('getgroupeMembre', [GroupeAPIController::class, 'getgroupeMembreAPI']);
Route::delete('DeleteMembre' , [GroupeAPIController::class, 'DeleteMembreAPI']);
Route::post('getMembre', [GroupeAPIController::class, 'getMembreAPI']);
Route::post('AjouterMembre', [GroupeAPIController::class, 'AjouterMembreAPI']);
Route::get('getTest', [GroupeAPIController::class, 'testAPI']);


//pointage 
Route::post('ModifierDay', [DaysAPIController::class , 'ModifierDayAPI']);
Route::post('StartDay', [PointageAPIController::class , 'StartDayAPI']);
Route::post('MilieuDay', [PointageAPIController::class , 'MilieuDayAPI']);
Route::post('FinDay', [PointageAPIController::class , 'FinDayAPI']); 
Route::post('getPointage', [PointageAPIController::class , 'getPointageAPI']); 
Route::post('AddAbsence', [PointageAPIController::class , 'AddAbsenceAPI']); 
Route::post('GetAbsence', [PointageAPIController::class , 'GetAbsenceAPI']); 
Route::post('DeleteAbsence', [PointageAPIController::class , 'DeleteAbsenceAPI']); 
Route::get('getALLPointage', [PointageAPIController::class , 'getALLPointageAPI']); 
Route::post('getLocation', [PointageAPIController::class , 'getLocationAPI']); 
Route::post('Break', [PointageAPIController::class , 'BreakAPI']); 


//configuration pointage   
Route::get('getConfigurationPointage', [ConfigurationPointageAPIController::class , 'getConfigurationPointageAPI']); 
Route::post('ModifierConfigurationPointage', [ConfigurationPointageAPIController::class , 'ModifierConfigurationPointageAPI']); 

//conge 
Route::post('AjouterDemanderConge', [CongesAPIController::class , 'AjouterDemanderCongeAPI']); 
Route::post('getCongesEmploye', [CongesAPIController::class , 'getCongesEmployeAPI']); 
Route::post('DeleteConge', [CongesAPIController::class , 'DeleteCongeAPI']); 
Route::post('getConges', [CongesAPIController::class , 'getCongesAPI']); 
Route::post('AccepterCongesResponsable', [CongesAPIController::class , 'AccepterCongesResponsableAPI']); 
Route::post('RefuserCongesResponsable', [CongesAPIController::class , 'RefuserCongesResponsableAPI']); 
Route::post('AccepterCongesAdmin', [CongesAPIController::class , 'AccepterCongesAdminAPI']); 
Route::post('RefuserCongesAdmin', [CongesAPIController::class , 'RefuserCongesAdminAPI']); 
Route::post('TraitementConges', [CongesAPIController::class , 'TraitementCongesAPI']); 
Route::post('TraitementCongesACEP', [CongesAPIController::class , 'TraitementCongesACEPAPI']); 
Route::get('getAllConges', [CongesAPIController::class , 'getAllCongesAPI']); 


//modifer compte 
Route::post('getEmployeModifier', [CongesAPIController::class , 'getEmployeModifierAPI']); 
Route::post('getAdminModifier', [CongesAPIController::class , 'getAdminModifierAPI']); 
Route::post('ModifierPersonneInfo', [CongesAPIController::class , 'ModifierPersonneInfoAPI']); 
Route::post('ModifierAdminInfo', [CongesAPIController::class , 'ModifierAdminInfoAPI']); 
Route::post('ModifierPassword', [CongesAPIController::class , 'ModifierPasswordAPI']); 
Route::post('ModifierAdminPassword', [CongesAPIController::class , 'ModifierAdminPasswordAPI']); 


//disponibilite 
Route::get('/getDisponibilite', [EmployeAPIController::class , 'getDisponibiliteAPI']); 
Route::get('/getNombreDisponibilite', [EmployeAPIController::class , 'getNombreDisponibiliteAPI']); 
Route::get('/getNombreEmployes', [EmployeAPIController::class , 'getNombreEmployesAPI']); 


//horaire 
Route::get('/gethoraire', [DaysAPIController::class , 'gethoraireAPI']); 
Route::post('/getsolde', [DaysAPIController::class , 'getsoldeAPI']); 


//graphique
Route::post('getcountEmploye', [CongesAPIController::class , 'getCountEmployeAPI']); 


//notification 
Route::post('sendToken', [NotificationAPIController::class , 'sendTokenAPI']); 
Route::get('/getTokenConge', [NotificationAPIController::class , 'getTokenCongeAPI']); 