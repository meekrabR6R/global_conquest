<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', array('uses' => 'facebook@login'));
Route::get('map', array('uses' => 'map@map'));
Route::get('games', array('uses' => 'games@games'));
Route::post('new_game', array('uses' => 'games@new_game'));
Route::post('join', array('uses' => 'games@join'));
Route::post('place', array('uses' => 'map@place'));
Route::post('attack', array('uses' => 'map@attack'));
Route::post('take_over', array('uses' => 'map@take_over'));
Route::post('make_card', array('uses' => 'map@make_card'));
Route::post('move_armies', array('uses' => 'map@move_armies'));
Route::get('card_status', array('uses' => 'map@card_status'));
Route::post('end_turn', array('uses' => 'map@end_turn'));
Route::post('card_turn_in', array('uses' => 'map@card_turn_in'));
Route::post('continent_bonuses', array('uses' => 'map@continent_bonuses'));
Route::post('add_color', array('uses' => 'games@add_color'));
Route::post('terr_taken', array('uses' => 'map@terr_taken'));
Route::get('colors', array('uses' => 'map@colors'));
Route::get('test', array('uses' => 'map@test')); //temporary test route
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});




//Controllers
Route::controller('games');
Route::controller('players');