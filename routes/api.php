<?php

use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//get api for fetch for user list
Route::get('/users/{id?}',[UserApiController::class,'ShowUsers'])->name('user_show');

//post api for fetch for add user
Route::post('/add-user',[UserApiController::class,'AddUser'])->name('user_add');

//post api for fetch for add multiple user
Route::post('/add-multiple-user',[UserApiController::class,'AddMultipleUser'])->name('user_add_multiple');

//put api for fetch for update  user details 
Route::put('/update-user-details/{id}',[UserApiController::class,'updateUserDetails'])->name('user_update_details');

//patch api for fetch for update  single record
Route::patch('/update-single-records/{id}',[UserApiController::class,'updateSingleRecords'])->name('single_user_record');

//delete api for fetch for delete  single record
Route::delete('/delete-single-record/{id}',[UserApiController::class,'deleteUser'])->name('single_record_delete');

//delete api for fetch for delete  single record with json
Route::delete('/delete-single-record-with-json',[UserApiController::class,'deleteUserWithJson'])->name('single_record_delete_with_json');

//delete api for fetch for delete  multiple record
Route::delete('/delete-multiple-record/{ids}',[UserApiController::class,'deleteMultipleUser'])->name('multiple_record_delete');


//delete api for fetch for delete  multiple record with json
Route::delete('/delete-multiple-record-with-json',[UserApiController::class,'deleteMultipleUserWithJson'])->name('multiple_record_delete_with_json');

//registation user api with passport
Route::post('/register-user-using-api-passport',[UserApiController::class,'registerUserPassport'])->name('register_user_using_api_passport');

//login user api with passport
Route::post('/login-user-using-api-passport',[UserApiController::class,'loginUserPassport'])->name('login_user_using_api_passport');
