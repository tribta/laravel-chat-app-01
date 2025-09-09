<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Return Conversation List
    Route::get('/chat', [ConversationController::class, 'index'])
        ->name('chat.index');

    // Get conversation details
    Route::get('/chat/{conversation}', [ConversationController::class, 'show'])
        ->name('chat.show');

    // Create new conversation
    Route::post('/chat', [ConversationController::class, 'store'])
        ->name('chat.store');

    // Create new message
    Route::post('/message', [MessageController::class, 'store'])
        ->name('message.store');
});
