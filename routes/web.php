<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[JobController::class,'index'])->name('home');
Route::get('/jobs',[JobController::class,'indexjobs'])->name('jobs');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');
Route::group(['prefix' => 'account'], function () {
    // Guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/careervibe/login', [AccountController::class, 'login'])->name('acc.login');
        Route::get('/registerr', [AccountController::class, 'registeration'])->name('regist');
        Route::post('/register', [AccountController::class, 'ProcessRegistration'])->name('processvalidate');
        Route::post('/login/logging', [AccountController::class, 'Processauth'])->name('logging');
    });

    // Auth routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/careervibe/profile', [AccountController::class, 'profile'])->name('acc.profile');
        Route::put('/updatecareervibe/profile', [AccountController::class, 'updateprofile'])->name('acc.updateprofile');
        Route::post('/updatecareervibe/profilePic', [AccountController::class, 'updateprofilepic'])->name('acc.updateprofilepic');
        Route::get('/careervibe/logout', [AccountController::class, 'logout'])->name('acc.logout');
        Route::get('/account/careervibe/postJob', [JobController::class, 'makejob'])->name('acc.makejob');
        Route::post('/account/careervibe/postJob/validate', [JobController::class, 'savejob'])->name('acc.savejob');
        Route::get('/account/careervibe/Myjob', [JobController::class, 'showjob'])->name('acc.myjob');
        Route::get('/account/careervibe/editMyjob/{jobId}', [JobController::class, 'editjob'])->name('acc.editjob');
        Route::post('/account/careervibe/updatetJob/validate/{jobId}', [JobController::class, 'updatejob'])->name('acc.updatejob');
        Route::post('/account/careervibe/updatetJob/Delete', [JobController::class, 'deletejob'])->name('acc.deletejob');


        
             //route for view people  job posted 

        Route::get('/account/careervibe/getjob/info/{id}',[JobController::class, 'detail'])->name('getjob');  

        //route for view own  job posted 
        Route::get('/account/careervibe/mygetjob/info/{id}',[JobController::class, 'detailmyjob'])->name('mygetjob');

        //route to apply on job
        Route::get('/applyjob/{jobid}', [JobController::class, 'applyjob'])->name('applyjob');

        Route::get('/myapplyjobs/', [JobController::class, 'myapplyjob'])->name('acc.myapplyjob');


        
        Route::post('/account/careervibe/updatetJob/remove', [JobController::class, 'removejob'])->name('acc.removejob');
        //route for save job 
        Route::get('/jobssave/forme/{id}',[JobController::class,'setsavejob'])->name('getsavejob');
        Route::get('/getjobssave/forme/',[JobController::class,'getsavejob'])->name('acc.getsavejob');
        Route::post('/removejobssave/forme/',[JobController::class,'removesavejob'])->name('acc.removesavejob');

    });
});