<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\CustomController;

Route::controller(CustomController::class)->group(function(){
    Route::get('assign-sp', 'assignSP')->name('assign-sp');
    Route::post('assigned-sp', 'assignedSP')->name('assigned-sp');
    Route::get('refrence/{sp_id}', 'refrence')->name('refrence');
    Route::post('signup-refrence/{sp_id}','signup')->name('signup-refrence');
    Route::get('login', 'login')->name('login');
    Route::post('post-login', 'postLogin')->name('login.post');
    Route::get('dashboard', 'dashboard'); 
    Route::get('logout', 'logout')->name('logout');
    Route::get('see-your-sps/{sh_id}','seeYourSps')->name('see-your-sps');
    Route::get('see-your-customers/{sp_id}','seeYourCusts')->name('see-your-customers');
});