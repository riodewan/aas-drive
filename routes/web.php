<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
    //Dashboard
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('dashboard',[AdminController::class,'showAllFiles'])->name('admin.dashboard');
    Route::get('dashboard/folder/{folderId}',[AdminController::class, 'showAllFiles']);

    Route::get('my-devices',[AdminController::class,'devices'])->name('admin.devices');
    Route::post('/admin-create-folder', [AdminController::class, 'adminCreateFolder'])->name('adminCreateFolder');
    Route::get('my-devices/folder/{folderId}',[AdminController::class, 'showAdminFiles']);
    Route::post('/admin-upload-file', [AdminController::class, 'adminFileUpload'])->name('adminFileUpload');
    Route::get('my-devices',[AdminController::class,'showAdminFiles'])->name('admin.devices');
    Route::get('/delete-admin-file/{fileId}', [AdminController::class, 'deleteAdminFile']);

    Route::get('view/view-admin-file/{fileId}', [AdminController::class, 'viewAdminFile']);
    Route::get('view/view-dashboard-file/{fileId}', [AdminController::class, 'viewDashboardFile']);

    //Profile
    Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
    Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
    Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
    
    //List User
    Route::get('user-list',[AdminController::class,'userList'])->name('admin.userList');
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth','PreventBackHistory']], function(){
    
    //Dashboard
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::post('/upload-file', [UserController::class, 'fileUpload'])->name('fileUpload');
    Route::get('dashboard', [UserController::class, 'showUserFiles'])->name('user.dashboard');
    Route::get('dashboard/folder/{folderId}',[UserController::class, 'showUserFiles']);
    Route::get('/download/{filepath}', [UserController::class, 'downloadFile']);
    Route::post('/create-folder', [UserController::class, 'createFolder'])->name('createFolder');
    Route::get('/delete-file/{fileId}', [UserController::class, 'deleteFile']);

    Route::get('view/view-file/{fileId}', [UserController::class, 'viewFile']);

    
    //Profile
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('userUpdateInfo');
    Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('userPictureUpdate');
    Route::post('change-password',[UserController::class,'changePassword'])->name('userChangePassword');
       
});
