<?php

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


Route::get('/', 'HomeController@index')->name('home');
Route::get('/posts', 'PostController@index')->name('posts.index');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');


/*auto generates the routes needed for authentication */
Auth::routes();

/**** the middleware function makes it so that you need to be logged in to access this route.
* This way it's easy to see which routes are locked.
* 
* Since this route is locked, if you're not logged in you'll be redirected to the sign in page.
* 
* If you want to change the uri of the default page you land on after login, you need to go to app\http\providers\routeserviceprovider and edit the HOME const with the new uri ****/
//Route::get('/admin', 'Admin\HomeController@index')->name('admin.home')->middleware('auth');

/**** Group the admin routes to give them all the same properties:
 * prefix('admin'): all the routes begin with admin/
 * namespace('Admin): all the controllers are inside the Admin namespace
 * name('admin'): all the routes' names begin with admin.
 * middleware('auth'): all the routes are onlly accessible to signed in users
 **/
Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth')->group(function () {
  /**same route as the COMMENTED one above*/
  Route::get('/', 'HomeController@index')->name('home');
  Route::resource('/posts', 'PostController');
  Route::get('/posts/{post}/previewdelete', 'PostController@previewdelete')->name('posts.previewdelete');
});
