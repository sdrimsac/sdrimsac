<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->post('/system/git-update', [\App\Http\Controllers\System\SystemGitUpdateController::class, 'updateFromGit'])
    ->name('system.git-update');
