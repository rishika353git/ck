<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\PremiumController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PollController;
use App\Http\Controllers\ChooseInterestController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\ForumQuestionController;
use App\Http\Controllers\ForumAnswerController;
use App\Http\Controllers\ForumNormalPostController;
use App\Http\Controllers\ForumOnlineEventPostController;
use App\Http\Controllers\ForumOfflineEventPostController;
use App\Http\Controllers\ForumOccasionPostController;
use App\Http\Controllers\ForumHiringPostController;
use App\Http\Controllers\ForumPollPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\areaOfPractiseController;
use App\Http\Controllers\Api\GoogleSingController;
use App\Http\Controllers\AuthController;




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

// User Registration api



Route::controller(UserController::class)->group(function () {
    Route::get('/user/get','index');
    Route::post('/user/register','register');
    Route::post('/user/verification-otp-code','verification');
    Route::post('/user/resend-otp-code','resendotp');
});



// User Login and logout api
Route::post('/user/login',[LoginController::class,'login']);
Route::post('/user/logout',[LoginController::class,'logout'])->middleware('auth:sanctum');

Route::post('/currentuserdetails',[UserController::class,'currentuserdetails'])->middleware('auth:sanctum');

//home api
Route::get('/user/home',[HomeController::class,'index'])->middleware('auth:sanctum');

//CheckIn api
Route::post('/user/check-in',[CheckInController::class,'checkin'])->middleware('auth:sanctum');
Route::get('/user/check-in/history',[CheckInController::class,'history'])->middleware('auth:sanctum');
Route::get('/user/check-in/update',[CheckInController::class,'update'])->middleware('auth:sanctum');

//Fourm Category
Route::get('/user/forum-category',[ForumQuestionController::class,'forumcategory'])->middleware('auth:sanctum');

//Fourm Question api
Route::get('/user/forum-question',[ForumQuestionController::class,'index'])->middleware('auth:sanctum');
Route::post('/user/forum-question/store',[ForumQuestionController::class,'store'])->middleware('auth:sanctum');
Route::post('/user/forum/categories',[ForumQuestionController::class,'bycategories'])->middleware('auth:sanctum');
Route::post('/user/forum-question/reaction',[ForumQuestionController::class,'reaction'])->middleware('auth:sanctum');

//Fourm Answer api
Route::post('/user/forum-answer/',[ForumAnswerController::class,'index'])->middleware('auth:sanctum');
Route::post('/user/forum-answer/store',[ForumAnswerController::class,'store'])->middleware('auth:sanctum');



//Fourm Normal Post Api
Route::get('/user/forum-show-post/',[ForumNormalPostController::class,'index'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/store',[ForumNormalPostController::class,'store'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/reaction',[ForumNormalPostController::class,'reaction'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/comment',[ForumNormalPostController::class,'comment'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/comment/reaction',[ForumNormalPostController::class,'commentreaction'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/showcomment',[ForumNormalPostController::class,'showcomment'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/comment/reply',[ForumNormalPostController::class,'reply'])->middleware('auth:sanctum');
Route::post('/user/forum-normal-post/comment/showreply',[ForumNormalPostController::class,'showreply'])->middleware('auth:sanctum');


//Fourm online event Post Api
Route::post('/user/forum-online-event-post/',[ForumOnlineEventPostController::class,'store'])->middleware('auth:sanctum');

//Fourm offline event Post Api
Route::post('/user/forum-offline-event-post/',[ForumOfflineEventPostController::class,'store'])->middleware('auth:sanctum');

//Fourm Occasion Post api
Route::post('/user/forum-occasion-post/',[ForumOccasionPostController::class,'store'])->middleware('auth:sanctum');

//Forum Hiring Post api
Route::post('/user/forum-hiring-post/',[ForumHiringPostController::class,'store'])->middleware('auth:sanctum');
Route::get('/user/forum-show-job',[ForumHiringPostController::class,'index'])->middleware('auth:sanctum');

//Job Apply api
Route::post('/user/apply-job',[RequirementController::class,'store'])->middleware('auth:sanctum');
Route::get('/user/show-applyed-job', [RequirementController::class, 'applyhistory'])->middleware('auth:sanctum');

//Forum poll Post api
Route::post('/user/forum-poll-post/',[ForumPollPostController::class,'store'])->middleware('auth:sanctum');

// User roll api
Route::post('/user/roll',[ProfileController::class,'userRoll'])->middleware('auth:sanctum');

//card image uploade api
Route::post('/user/uploadCardImage',[ProfileController::class,'uploadCardImage'])->middleware('auth:sanctum');

// profile image up;oade api
Route::post('/user/uploadProfileImage',[ProfileController::class,'uploadProfileImage'])->middleware('auth:sanctum');

//profile api
Route::get('/user/profile/',[ProfileController::class,'index'])->middleware('auth:sanctum');
Route::post('/user/profile/update',[ProfileController::class,'update'])->middleware('auth:sanctum');

//skill api
Route::get('/skills',[SkillController::class,'index'])->middleware('auth:sanctum');

//area of practice api
Route::get('/areaofpractice',[areaOfPractiseController::class,'index'])->middleware('auth:sanctum');

// Search all courts and sub-courts list
Route::post('/search',[SearchController::class,'search'])->middleware('auth:sanctum');

//wallet api
Route::get('/user/wallet',[WalletController::class,'wallet'])->middleware('auth:sanctum');
Route::post('/user/withdrawal',[WalletController::class,'withdrawal'])->middleware('auth:sanctum');

//plan api
Route::get('/user/plans',[PremiumController::class,'index'])->middleware('auth:sanctum');

//Court and sub court api
Route::post('/court',[CourtController::class,'court'])->middleware('auth:sanctum');
Route::get('/subcourt', [CourtController::class, 'subcourt'])->middleware('auth:sanctum');
Route::post('/availableUser', [CourtController::class, 'availableUser'])->middleware('auth:sanctum');

//poll api

Route::post('/polls', [PollController::class, 'store']);
