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
Route::get('/setup', 'PageController@setup')
	->name('setup');
Route::post('/setup/server', 'PageController@saveSetup')
	->name('setup.save');

Route::get('/email', 'PageController@email');

// USER/PUBLIC PAGES
Route::get('/', 'PageController@home')->name('index');

// BLOGS
Route::group(['prefix' => 'blogs'], function() {
	Route::get('/', Livewire\Blogs\Index::class)
		->name('blogs.index');
	Route::get('/{slug}', Livewire\Blogs\Show::class)
		->name('blogs.show');
});

// ADMIN PAGES
Route::group(['prefix' => 'admin'], function() {
	// AUTHENTICATION
	Route::get('/login', 'PageController@login')
		->name('login')
		->middleware(['guest']);
	Route::get('/logout', 'PageController@logout')
		->name('logout')
		->middleware(['auth']);

	// AUTHENTICATED
	Route::group(['middleware' => 'auth'], function() {
		// DASHBOARD
		Route::get('/', 'PageController@redirectDashboard')
			->name('admin.dashboard.redirect');
		Route::get('/dashboard', 'PageController@dashboard')
			->name('admin.dashboard');

		// BLOGS
		Route::group(['prefix' => 'blogs', 'middleware' => ['permissions:blogs_tab_access']], function() {
			// Index
			Route::get('/', Livewire\Admin\Blogs\Index::class)
				->name('admin.blogs.index');
			
			// Create
			Route::get('/create', Livewire\Admin\Blogs\Create::class)
				->name('admin.blogs.create')
				->middleware(['permissions:blogs_tab_create']);

			Route::group(['prefix' => '{slug}'], function() {
				// Show
				Route::get('/', Livewire\Admin\Blogs\Show::class)
					->name('admin.blogs.show');
				// Edit
				Route::get('/edit', Livewire\Admin\Blogs\Edit::class)
					->name('admin.blogs.edit')
					->middleware(['permissions:blogs_tab_edit']);
			});
		});

		// USERS
		Route::group(['prefix' => 'users', 'middleware' => ['permissions:users_tab_access']], function() {
			// Index
			Route::get('/', Livewire\Admin\Users\Index::class)
				->name('admin.users.index');

			// Create
			Route::get('/create', Livewire\Admin\Users\Create::class)
				->name('admin.users.create')
				->middleware(['permissions:users_tab_create']);

			Route::group(['prefix' => '@{username}'], function() {
				// Show
				Route::get('/', Livewire\Admin\Users\Show::class)
					->name('admin.users.show');
				// Edit
				Route::get('/edit', Livewire\Admin\Users\Edit::class)
					->name('admin.users.edit')
					->middleware(['permissions:users_tab_edit']);

				// Permission Management
				Route::get('/manage-permissions', Livewire\Admin\Users\ManagePermissions::class)
					->name('admin.users.manage-permissions')
					->middleware(['permissions:users_tab_permissions']);
			});
		});
	});
});