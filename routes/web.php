<?php

use App\Http\Controllers\AnimateurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ficheController;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\registerGoogleController;
use App\Http\Controllers\GroupController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
})->name('home');



 Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
 ])->group(function () {
     Route::get('/dashboard', function () {
         return view('dashboard');
     })->name('dashboard');
     Route::post('generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');
     Route::get('formulaire', [MedicalController::class, "display_form"])->name('record_form');
     Route::get('/fiches',[MedicalController::class,'getDbRecords'])->name('records');
     Route::get('/fiches/details/{id}',[MedicalController::class,'getCardDetails']);
     Route::post('/create-record', [MedicalController::class, 'createRecord'])->name('create_record');
     Route::post('/animateur/createAnimateur',[AnimateurController::class,'createAnimateur'])->name('create_animateur');
     Route::post('/delete_record',[MedicalController::class,'deleteRecord'])->name('delete_record');
     Route::post('/edit_record',[MedicalController::class,'editRecord'])->name('edit_record');
     Route::get('/animateur',[AnimateurController::class,'viewAnimateur'])->name('view_Animateur');
     Route::get('/formulaire/custom',[AnimateurController::class,'customFormView'])->name('custom_form_view');
     Route::post('/formulaire/custom/create',[AnimateurController::class,'addCustomField'])->name('add_custom_field');
     Route::post('/formulaire/custom/update_order',[AnimateurController::class,'changeFieldOrder'])->name('change_field_order');
     Route::post('/formulaire/custom/delete',[AnimateurController::class,'deleteCustomField'])->name('delete_custom_field');
     Route::post('/formulaire/custom/edit',[AnimateurController::class,'editCustomField'])->name('edit_custom_field');
     Route::get('/group',[GroupController::class,'groups'])->name('groups');
     Route::post('/group/createGroup',[GroupController::class,'createGroup'])->name('create_group');
     Route::post('/group/deleteGroup',[GroupController::class,'deleteGroup'])->name('delete_group');
     Route::post('/group/editGroup',[GroupController::class,'editGroup'])->name('edit_group');
     Route::post('/fiches/details/addGroup',[MedicalController::class,'addGroup'])->name('add_group');
     Route::post('/fiches/changeGroup',[MedicalController::class,'filterGroup'])->name('filter_group');
     Route::get('/fiches/allergies',[MedicalController::class,'filterAllergies'])->name('filter_allergies');


 });
 
// Route::get('fiche-medicale',[ficheController::class, "display_record"]);
//Route::post('/create-testing', [MedicalController::class, 'create_testing'])->name('create_testing');
//Route::get('/testing', [ficheController::class, "display_testing"])->name('testing_form');
Route::get('/registerGoogle',[registerGoogleController::class, "registerGoogle"]);



# Socialite URLs

// La page où on présente les liens de redirection vers les providers
Route::get("login-register", [SocialiteController::class, 'loginRegister']);

// La redirection vers le provider
Route::get("redirect/{provider}", [SocialiteController::class, 'redirect'])->name('socialite.redirect');

// Le callback du provider
Route::get("callback/{provider}", [SocialiteController::class, 'callback'])->name('socialite.callback');
