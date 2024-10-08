<?php

use App\Http\Controllers\DiscussionShowController;
use App\Http\Controllers\DiscussionStoreController;
use App\Http\Controllers\ForumIndexController;
use App\Http\Controllers\MarkdownPreviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', ForumIndexController::class)->name('home');
Route::get('/{discussion:slug}', DiscussionShowController::class)->name('discussions.show');

Route::post('/markdown', MarkdownPreviewController::class)->name('markdown.preview');

Route::middleware('auth')->group(function () {
    Route::post('/discussions', DiscussionStoreController::class)->name('discussions.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
