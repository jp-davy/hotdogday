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

Route::get('/', 'WelcomeController@show')->name('home');


/*Route::get('/mail', function () {
    $order = App\User::find(1);
    return new App\Mail\OrderSubmittedEmail($order);
});*/

Route::resource('/users', 'UsersController')
	->names(
	    [
	        'index' => 'users.index',
	        'create' => 'users.create',
	        'store' => 'users.store',
	        'show' => 'users.show',
	        'edit' => 'users.edit',
	        'update' => 'users.update',
	        'destroy' => 'users.destroy'
	    ]
	);

Route::get('/family/{user}/students/create', 'StudentsController@create')
	->name('students.create');
Route::post('/family/{user}/students', 'StudentsController@store')
	->name('students.store');
Route::put('/family/{user}/students/{student}', 'StudentsController@update')
	->name('students.update');
Route::delete('/family/{user}/students/{student}', 'StudentsController@destroy')
	->name('students.destroy');

Route::post('/orders/{user}', 'OrdersController@submitToSchool')
	->name('orders.submit-to-school');

Route::get('/orders/{user}', 'OrdersController@show')
	->name('orders.show');

/*
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
