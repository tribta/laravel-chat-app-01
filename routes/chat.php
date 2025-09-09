<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ConversationController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [ConversationController::class, 'show'])->name('chat.show');
    Route::post('/chat', [ConversationController::class, 'store'])->name('chat.store');

    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});
