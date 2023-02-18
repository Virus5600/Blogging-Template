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
Route::get('/setup', 'PageController@setup')->name('setup');
Route::post('/setup/server', 'PageController@saveSetup')->name('setup.save');

Route::get('/email', 'PageController@email');

// User/Public pages
Route::get('/', 'PageController@home')->name('index');

// Blogs
Route::group(['prefix' => 'blogs'], function() {
	Route::get('/', Livewire\Blogs\Index::class)->name('blogs.index');
	Route::get('/{slug}', Livewire\Blogs\Show::class)->name('blogs.show');
});

// Admin pages
Route::group(['prefix' => 'admin'], function() {
	// Authentication
	Route::get('/login', 'PageController@login')->middleware('guest')->name('login');
	Route::get('/logout', 'PageController@logout')->middleware('auth')->name('logout');

	// Authenticated
	Route::group(['middleware' => 'auth'], function() {
		// Dashboard
		Route::get('/', 'PageController@redirectDashboard')->name('admin.dashboard.redirect');
		Route::get('/dashboard', 'PageController@dashboard')->name('admin.dashboard');

		// Blogs
		Route::group(['prefix' => 'blogs'], function() {
			// Index
			Route::get('/', Livewire\Admin\Blogs\Index::class)->name('admin.blogs.index');
			// Create
			Route::get('/create', Livewire\Admin\Blogs\Create::class)->name('admin.blogs.create');

			Route::group(['prefix' => '{slug}'], function() {
				// Show
				Route::get('/', Livewire\Admin\Blogs\Show::class)->name('admin.blogs.show');
				// Edit
				Route::get('/edit', Livewire\Admin\Blogs\Edit::class)->name('admin.blogs.edit');
			});
		});
	});
});