<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('users/notifications', 'UsersController@notifications')->name('users.notifications');
Route::resource('questions', 'QuestionsController')->except('show');
Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show');

Route::post('questions/{question}/favorite', 'FavoritesController@store')->name('questions.favorite');
Route::delete('questions/{question}/unfavorite', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('questions/{question}/vote/{vote}', 'VotesController@voteQuestion')->name('questions.vote');
Route::post('answers/{answer}/vote/{vote}', 'VotesController@voteAnswer')->name('answers.vote');

Route::resource('questions.answers', 'AnswersController')->except(['index', 'show', 'create']);
Route::put('answers/{answer}/best-answer', "AnswersController@bestAnswer")->name('answers.bestAnswer');
Route::get('/home', 'HomeController@index')->name('home');
