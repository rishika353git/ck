<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\web\CourtController;
use App\Http\Controllers\web\SubCourtController;
use App\Http\Controllers\web\WalletController;
use App\Http\Controllers\DraftCategoriesController;
use App\Http\Controllers\SubDraftCategoriesController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\web\AreaPracticeController;
use App\Http\Controllers\SkillController;





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


Route::get('/login', function () {
    return view('login');
});
Route::middleware(['WebGuard'])->group(function () {
    Route::get('/home',[WebUserController::class,'index'])->name('home');
    Route::get('/all/users',[WebUserController::class,'users'])->name('all.users');
    Route::get('/Pending/user',[WebUserController::class,'PendingUser'])->name('pendinguser');
    Route::get('/Active/user',[WebUserController::class,'ActiveUser'])->name('activeuser');
    Route::get('/Reject/user',[WebUserController::class,'RejectUser'])->name('rejectuser');
    Route::get('/Blocked/user',[WebUserController::class,'blockedUser'])->name('blockeduser');
    Route::get('/Delete/user/{id}',[WebUserController::class,'deleteUser'])->name('deleteuser');


    Route::post('/update/user/status',[WebUserController::class,'PendingUserUpdate'])->name('PendingUserUpdate');
    Route::get('/user/profile/{id}',[WebUserController::class,'profile'])->name('profile');



    Route::get('/courts',[CourtController::class,'index'])->name('courts');
    Route::get('/courts/create',[CourtController::class,'create'])->name('courts.create');
    Route::post('/courts/store',[CourtController::class,'store'])->name('courts.store');
    Route::get('/courts/edit/{id}', [CourtController::class, 'edit'])->name('courts.edit');
    Route::post('/courts/update', [CourtController::class, 'update'])->name('courts.update');
    Route::get('/courts/enable/{id}', [CourtController::class, 'enable'])->name('courts.enable');
    Route::get('/courts/disable/{id}', [CourtController::class, 'disable'])->name('courts.disable');



    Route::get('/subcourts',[SubCourtController::class,'index'])->name('subcourts');
    Route::get('/subcourts/create',[SubCourtController::class,'create'])->name('subcourts.create');
    Route::post('/subcourts/store',[SubCourtController::class,'store'])->name('subcourts.store');
    Route::get('/subcourts/delete/{id}', [SubCourtController::class, 'delete'])->name('subcourts.delete');
    Route::get('/subcourts/edit/{id}', [SubCourtController::class, 'edit'])->name('subcourts.edit');
    Route::post('/subcourts/update', [SubCourtController::class, 'update'])->name('subcourts.update');



    Route::get('/drafts',[DraftCategoriesController::class,'index'])->name('drafts');
    Route::get('/drafts/create',[DraftCategoriesController::class,'create'])->name('drafts.create');
    Route::post('/drafts/store',[DraftCategoriesController::class,'store'])->name('drafts.store');

    Route::get('/drafts/edit/{id}', [DraftCategoriesController::class, 'edit'])->name('drafts.edit');
    Route::post('/drafts/update', [DraftCategoriesController::class, 'update'])->name('drafts.update');
    Route::get('/drafts/enable/{id}', [DraftCategoriesController::class, 'enable'])->name('drafts.enable');
    Route::get('/drafts/disable/{id}', [DraftCategoriesController::class, 'disable'])->name('drafts.disable');


    Route::get('/subdrafts',[SubDraftCategoriesController::class,'index'])->name('subdrafts');
    Route::get('/subdrafts/create',[SubDraftCategoriesController::class,'create'])->name('subdrafts.create');
    Route::post('/subdrafts/store',[SubDraftCategoriesController::class,'store'])->name('subdrafts.store');
    Route::get('/subdrafts/delete/{id}', [SubDraftCategoriesController::class, 'delete'])->name('subdrafts.delete');
    Route::get('/subdrafts/edit/{id}', [SubDraftCategoriesController::class, 'edit'])->name('subdrafts.edit');
    Route::post('/subdrafts/update', [SubDraftCategoriesController::class, 'update'])->name('subdrafts.update');


    Route::get('/forums',[ForumController::class,'index'])->name('forums');
    Route::get('/forums/create',[ForumController::class,'create'])->name('forums.create');
    Route::post('/forums/store',[ForumController::class,'store'])->name('forums.store');
    Route::get('/forums/edit/{id}', [ForumController::class, 'edit'])->name('forums.edit');
    Route::post('/forums/update', [ForumController::class, 'update'])->name('forums.update');
    Route::get('/forums/enable/{id}', [ForumController::class, 'enable'])->name('forums.enable');
    Route::get('/forums/disable/{id}', [ForumController::class, 'disable'])->name('forums.disable');


    Route::get('/plans',[PremiumController::class,'index'])->name('plans');
    Route::get('/plans/create',[PremiumController::class,'create'])->name('plans.create');
    Route::post('/plans/store',[PremiumController::class,'store'])->name('plans.store');
    Route::get('/plans/edit/{id}',[PremiumController::class,'edit'])->name('plans.edit');
    Route::post('/plans/update', [PremiumController::class, 'update'])->name('plans.update');
    Route::get('/plans/enable/{id}', [PremiumController::class, 'enable'])->name('plans.enable');
    Route::get('/plans/disable/{id}', [PremiumController::class, 'disable'])->name('plans.disable');



    Route::get('/area-of-practice',[AreaPracticeController::class,'index'])->name('area.practice');
    Route::get('/area-of-practice/create',[AreaPracticeController::class,'create'])->name('area.practice.create');
    Route::post('/area-of-practice/store',[AreaPracticeController::class,'store'])->name('area.practice.store');
    Route::get('/area-of-practice/edit/{id}',[AreaPracticeController::class,'edit'])->name('area.practice.edit');
    Route::post('/area-of-practice/update', [AreaPracticeController::class, 'update'])->name('area.practice.update');
    Route::get('/area-of-practice/enable/{id}', [AreaPracticeController::class, 'enable'])->name('area.practice.enable');
    Route::get('/area-of-practice/disable/{id}', [AreaPracticeController::class, 'disable'])->name('area.practice.disable');




    Route::get('/skills',[SkillController::class,'index'])->name('skills');
    Route::get('/skills/create',[SkillController::class,'create'])->name('skills.create');
    Route::post('/skills/store',[SkillController::class,'store'])->name('skills.store');
    Route::get('/skills/edit/{id}',[SkillController::class,'edit'])->name('skills.edit');
    Route::post('/skills/update', [SkillController::class, 'update'])->name('skills.update');
    Route::get('/skills/enable/{id}', [SkillController::class, 'enable'])->name('skills.enable');
    Route::get('/skills/disable/{id}', [SkillController::class, 'disable'])->name('skills.disable');


    Route::get('/withdrawal/request', [WalletController::class, 'index'])->name('withdrawal.request');
    Route::post('/withdrawal/approve', [WalletController::class, 'approve'])->name('withdrawal.approve');

});


Route::get('/',[AdminController::class,'index']);
Route::post('/login',[AdminController::class,'login'])->name('login');
Route::get('/logout',[AdminController::class,'logout'])->name('logout');


// Route::get('/api/doc', function () {
//     return view('vendor.l5-swagger.index');
// });


