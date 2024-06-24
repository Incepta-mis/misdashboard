<?php

use Illuminate\Http\Request;
use App\Http\Controllers\QuizApiController; 
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'vquiz'],function (){
   Route::post('credential','QuizApiController@quser_credential'); 
   Route::post('notification','QuizApiController@qnotification');
   Route::post('materials','QuizApiController@qmaterials');
   Route::post('questions','QuizApiController@qquestions');
   Route::post('sanswer','QuizApiController@submittedAnswer');
   Route::post('c_result','QuizApiController@currentResult');
   Route::post('p_result','QuizApiController@previousResult');
   Route::post('notification_log','QuizApiController@getNotificationList');
   Route::get('grp_list','QuizApiController@get_grp_list');
   Route::post('ques_paper','QuizApiController@get_questions_paper');
});


//Canteen Token Management
Route::post('testData','TestAPIController@index');
Route::get('getCanteenUser','TestAPIController@getCanteenUser');
Route::post('canteenSnacksUpdate','TestAPIController@onCanteenSnacksUpdate');
Route::post('canteenSnacksTokenUpdate','TestAPIController@onCanteenSnacksTokensUpdate');
Route::post('canteenLunchUpdate','TestAPIController@onCanteenLunchUpdate');
Route::post('canteenLunchTokenUpdate','TestAPIController@onCanteenLunchTokensUpdate');
Route::post('canteenBreakFastUpdate','TestAPIController@onCanteenBreakFastUpdate');
Route::post('canteenBreakfastTokenUpdate','TestAPIController@onCanteenBreakFastTokensUpdate');
Route::post('canteenMidNightSnacksUpdate','TestAPIController@onCanteenMidNightSnacksUpdate');
Route::post('canteenMidNightSnacksTokenUpdate','TestAPIController@onCanteenMidNightSnacksTokenUpdate');
Route::post('canteenDinnerUpdate','TestAPIController@onCanteenDinnerUpdate');
Route::post('canteenDinnerTokenUpdate','TestAPIController@onCanteenDinnerTokenUpdate');
Route::post('canteenEveningSnacksUpdate','TestAPIController@onCanteenEveningSnacksUpdate');
Route::post('canteenEveningSnacksTokenUpdate','TestAPIController@onCanteenEveningSnacksTokenUpdate');


//SCM Apps Management
Route::post('scmLoginData','SCM\ScmAPIAppsController@index');
Route::get('getSCMNotice','SCM\ScmAPIAppsController@getSCMNotice');