<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'appname' => config('app.name')
    ]);
});



Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard',['appname' => config('app.name')]);
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::get('/tokens', ['App\Http\Controllers\TokensController','tokens'])->name('tokens');
    Route::get('/listatokens', ['App\Http\Controllers\TokensController','lista_Tokens'])->name('listatokens');
    Route::delete('/tokendel/{id}', ['App\Http\Controllers\TokensController','del_Token']);
    Route::post('/tokens/create', ['App\Http\Controllers\TokensController','crea_Token']);
    
    
    Route::get('/test',function(Request $request) {
         return json_encode(Auth::user()->personalTokens);
         // return $request->user()->createToken('test2');
    });


    Route::get('userslist',[UserController::class,'index2'] );
    Route::get('userssearch/{txtsearch?}',[UserController::class,'search'] );

    Route::get('roleslist',[RoleController::class,'index2']);
    Route::get('rolessearch/{txtsearch?}',[RoleController::class,'search']) ;

    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);

});






