<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('website')->with('title', 'Home');                                               //HOME PAGE
});

//Route::get('users', 'UserController@getIndex');
Route::get('/login', function()
{
    return View::make('login')->with('title', 'Login');;                                                 //LOGIN PAGE
});
Route::get('/register', function()
{
    return View::make('register')->with('title', 'Register');;                                                 //LOGIN PAGE
});
//Route::post('/login', 'Authentication@login');
Route::post('/login', function(){
    $rules = array('username' => 'required', 'password' => 'required');
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()){
        return Redirect::to('/login')->withErrors($validator);
    }
});

Route::get('users', function(){
    $users = User::all();
    return View::make('users')->with('users', $users);
});