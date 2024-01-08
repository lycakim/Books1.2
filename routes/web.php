<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Books\BooksController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
    // Route::get('/user/bookupload', [UserController::class, 'UserBookUpload'])->name('user.bookupload');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
    Route::controller(BooksController::class)->group(function(){
        Route::get('/user/book/table', 'UserBookTable')->name('user.book.table');
        Route::get('/user/book/add', 'UserBookAdd')->name('user.book.add');
        Route::get('/user/book/edit/{id}', 'EditBook')->name('user.book.edit');
        Route::post('/user/upload/book', 'UserUploadBook')->name('user.upload.book');
        Route::post('/user/save/changes', 'BookSaveChanges')->name('user.save.changes');
        Route::get('/user/delete/book/{id}', 'DeleteBook')->name('user.book.delete');
    }); 
// End group of book controller
});

// ADMIN GROUP MIDDLEWARE
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
}); //End group of admin

Route::middleware(['auth', 'role:agent'])->group(function(){
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
}); //End group of agent




Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');