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

//Route::get('/', array('as' => 'home', function () {
//    return View::make('home')->with('title', 'myJournal | Home');;
//}));
Route::get('/', array('as' => 'home', 'uses' => 'JournalController@index'));
//Route::get('/', function() {
//		return View::make('journals/index')
//
//			// all the bears (will also return the fish, trees, and picnics that belong to them)
//			->with('journals', Journal::all()->with('days'));
//
//	});

Route::get('login', array('as' => 'login', function () { 
    return View::make('login')->with('title', 'myJournal | Login');
}))->before('guest');

Route::post('login', function () {
    $user = array(
        'username' => Input::get('username'),
        'password' => Input::get('password')
    );

    if (Auth::attempt($user)) {
        return Redirect::route('home')
                        ->with(array('flash_notice'=>'You are successfully logged in.', 'title'=>'myJournal | Home'));
    }

    // authentication failure! lets go back to the login page
    return Redirect::route('login')
                    ->with(array('flash_notice'=>'Your username/password combination was incorrect.', 'title'=>'myJournal | Login'))
                    ->withInput();
});

Route::get('logout', array('as' => 'logout', function () { 
    Auth::logout();
    return Redirect::route('home')
        ->with('flash_notice', 'You are successfully logged out.');
}))->before('auth');

Route::get('profile', array('as' => 'profile', function () { 
    return View::make('profile')->with('title', 'myJournal | Profile');
}))->before('auth');

//Route::get('new_journal', array('as' => 'new_journal', function () { 
//    return View::make('new_journal')->with('title', 'myJournal | New Journal');
//}))->before('auth');

Route::resource('journal', 'JournalController');
Route::resource('trip', 'TripController');


Route::get('/register', function()
{
    return View::make('register')->with('title', 'Register');;                                                 //LOGIN PAGE
});

Route::get('users', function(){
    $users = User::all();
    return View::make('users')->with('users', $users);
});

Route::post('/journal/upload', array('as' => 'upload', 'uses' => 'JournalController@post_upload'));
Route::post('/journal/delete', array('as' => 'delete', 'uses' => 'JournalController@post_delete'));