<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/email/yanzheng/{token}',['as'=>'email.yanzheng','uses'=>'EmailController@yanzheng']);
Route::resource('questions','QuestionController',['names'=>[
    'create'=>'question.create',
    'index'=>'question.index',
    'show'=>'question.show',
]]);

Route::post('questions/{question}/answer','AnswerController@store');
