<?php

use App\Domains\User\Repository\UserRepositoryInterface;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'chats'], function () {
    Route::get('/index', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/send-message-to-user', [ChatController::class, 'sendUserMessage'])->name('chats.sendUserMessage');
    Route::post('/detail-message-single/{toUserId}', [ChatController::class, 'listDetailMessage'])->name('chats.listDetailMessageSingle');
    Route::post('/block-user', [ChatController::class, 'blockUser'])->name('chats.blockUser');
    Route::post('/un-block-user', [ChatController::class, 'unBlockUser'])->name('chats.blockUser');
});

//Route::get('/test-pipeline', function () {
//    $userRepo = app()->make(UserRepositoryInterface::class);
//    dd($userRepo->getQuery(['name' => 'namdv'])->get());
//});
