<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('categorie', 'App\Http\Controllers\CategorieController@index');
Route::post('categorie', 'App\Http\Controllers\CategorieController@store');
Route::get('categorie/{id}', 'App\Http\Controllers\CategorieController@show');
Route::put('categorie/{id}', 'App\Http\Controllers\CategorieController@update');
Route::delete('categorie/{id}', 'App\Http\Controllers\CategorieController@destroy');

Route::get('abonnement', 'App\Http\Controllers\AbonnementController@index');
Route::post('abonnement', 'App\Http\Controllers\AbonnementController@store');
Route::get('abonnement/{id}', 'App\Http\Controllers\AbonnementController@show');
Route::put('abonnement/{id}', 'App\Http\Controllers\AbonnementController@update');
Route::delete('abonnement/{id}', 'App\Http\Controllers\AbonnementController@destroy');

Route::get('choix', 'App\Http\Controllers\ChoixController@index');
Route::post('choix', 'App\Http\Controllers\ChoixController@store');
Route::get('choix/{id}', 'App\Http\Controllers\ChoixController@show');
Route::put('choix/{id}', 'App\Http\Controllers\ChoixController@update');
Route::delete('choix/{id}', 'App\Http\Controllers\ChoixController@destroy');

Route::get('commentaire', 'App\Http\Controllers\CommentaireController@index');
Route::post('commentaire', 'App\Http\Controllers\CommentaireController@store');
Route::get('commentaire/{id}', 'App\Http\Controllers\CommentaireController@show');
Route::put('commentaire/{id}', 'App\Http\Controllers\CommentaireController@update');
Route::delete('commentaire/{id}', 'App\Http\Controllers\CommentaireController@destroy');

Route::get('compte', 'App\Http\Controllers\CompteController@index');
Route::post('compte', 'App\Http\Controllers\CompteController@store');
Route::get('compte/{id}', 'App\Http\Controllers\CompteController@show');
Route::put('compte/{id}', 'App\Http\Controllers\CompteController@update');
Route::delete('compte/{id}', 'App\Http\Controllers\CompteController@destroy');

Route::get('cours', 'App\Http\Controllers\CoursController@index');
Route::post('cours', 'App\Http\Controllers\CoursController@store');
Route::get('cours/{id}', 'App\Http\Controllers\CoursController@show');
Route::put('cours/{id}', 'App\Http\Controllers\CoursController@update');
Route::delete('cours/{id}', 'App\Http\Controllers\CoursController@destroy');


Route::get('histroiquePrix', 'App\Http\Controllers\HistoriquePrixController@index');
Route::post('histroiquePrix', 'App\Http\Controllers\HistoriquePrixController@store');
Route::get('histroiquePrix/{id}', 'App\Http\Controllers\HistoriquePrixController@show');
Route::put('histroiquePrix/{id}', 'App\Http\Controllers\HistoriquePrixController@update');
Route::delete('histroiquePrix/{id}', 'App\Http\Controllers\HistoriquePrixController@destroy');



Route::get('ligneTarification', 'App\Http\Controllers\LigneTarificationController@index');
Route::post('ligneTarification', 'App\Http\Controllers\LigneTarificationController@store');
Route::get('ligneTarification/{id}', 'App\Http\Controllers\LigneTarificationController@show');
Route::put('ligneTarification/{id}', 'App\Http\Controllers\LigneTarificationController@update');
Route::delete('ligneTarification/{id}', 'App\Http\Controllers\LigneTarificationController@destroy');

Route::get('publication', 'App\Http\Controllers\PublicationController@index');
Route::post('publication', 'App\Http\Controllers\PublicationController@store');
Route::get('publication/{id}', 'App\Http\Controllers\PublicationController@show');
Route::put('publication/{id}', 'App\Http\Controllers\PublicationController@update');
Route::delete('publication/{id}', 'App\Http\Controllers\PublicationController@destroy');

Route::get('question', 'App\Http\Controllers\QuestionController@index');
Route::post('question', 'App\Http\Controllers\QuestionController@store');
Route::get('question/{id}', 'App\Http\Controllers\QuestionController@show');
Route::put('question/{id}', 'App\Http\Controllers\QuestionController@update');
Route::delete('question/{id}', 'App\Http\Controllers\QuestionController@destroy');

Route::get('questionnaire', 'App\Http\Controllers\QuestionnaireController@index');
Route::post('questionnaire', 'App\Http\Controllers\QuestionnaireController@store');
Route::get('questionnaire/{id}', 'App\Http\Controllers\QuestionnaireController@show');
Route::put('questionnaire/{id}', 'App\Http\Controllers\QuestQuestionnaireControllerionController@update');
Route::delete('questionnaire/{id}', 'App\Http\Controllers\QuestionnaireController@destroy');

Route::get('reponse', 'App\Http\Controllers\ReponseController@index');
Route::post('reponse', 'App\Http\Controllers\ReponseController@store');
Route::get('reponse/{id}', 'App\Http\Controllers\ReponseController@show');
Route::put('reponse/{id}', 'App\Http\Controllers\ReponseController@update');
Route::delete('reponse/{id}', 'App\Http\Controllers\ReponseController@destroy');


Route::get('tarification', 'App\Http\Controllers\TarificationController@index');
Route::post('tarification', 'App\Http\Controllers\TarificationController@store');
Route::get('tarification/{id}', 'App\Http\Controllers\TarificationController@show');
Route::put('tarification/{id}', 'App\Http\Controllers\TarificationController@update');
Route::delete('tarification/{id}', 'App\Http\Controllers\ReponseController@destroy');


Route::get('utilisateur', 'App\Http\Controllers\UtilisateurController@index');
Route::post('utilisateur', 'App\Http\Controllers\UtilisateurController@store');
Route::get('utilisateur/{id}', 'App\Http\Controllers\UtilisateurController@show');
Route::put('utilisateur/{id}', 'App\Http\Controllers\UtilisateurController@update');
Route::delete('utilisateur/{id}', 'App\Http\Controllers\UtilisateurController@destroy');

Route::get('visite', 'App\Http\Controllers\VisiteController@index');
Route::post('visite', 'App\Http\Controllers\VisiteController@store');
Route::get('visite/{id}', 'App\Http\Controllers\VisiteController@show');
Route::put('visite/{id}', 'App\Http\Controllers\VisiteController@update');
Route::delete('visite/{id}', 'App\Http\Controllers\VisiteController@destroy');

Route::get('vote', 'App\Http\Controllers\VoteController@index');
Route::post('vote', 'App\Http\Controllers\VoteController@store');
Route::get('vote/{id}', 'App\Http\Controllers\VoteController@show');
Route::put('vote/{id}', 'App\Http\Controllers\VoteController@update');
Route::delete('vote/{id}', 'App\Http\Controllers\VoteController@destroy');
