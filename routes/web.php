<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlatformSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProposalItemController;
use App\Http\Controllers\ProposalSectionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WorkspaceSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/p/{token}', [ProposalController::class, 'publicShow'])
    ->name('proposals.public');

Route::post('/p/{token}/accept', [ProposalController::class, 'acceptPublic'])
    ->name('proposals.public.accept');

Route::post('/p/{token}/reject', [ProposalController::class, 'rejectPublic'])
    ->name('proposals.public.reject');
/*
|--------------------------------------------------------------------------
| Authenticated + Verified Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('clients', ClientController::class);
    Route::resource('proposals', ProposalController::class);

    Route::prefix('proposals/{proposal}/sections')
        ->name('proposals.sections.')
        ->group(function () {
            Route::get('/create', [ProposalSectionController::class, 'create'])->name('create');
            Route::post('/', [ProposalSectionController::class, 'store'])->name('store');
            Route::get('/{section}/edit', [ProposalSectionController::class, 'edit'])->name('edit');
            Route::put('/{section}', [ProposalSectionController::class, 'update'])->name('update');
            Route::delete('/{section}', [ProposalSectionController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('proposals/{proposal}/items')
        ->name('proposals.items.')
        ->group(function () {
            Route::get('/create', [ProposalItemController::class, 'create'])->name('create');
            Route::post('/', [ProposalItemController::class, 'store'])->name('store');
            Route::get('/{item}/edit', [ProposalItemController::class, 'edit'])->name('edit');
            Route::put('/{item}', [ProposalItemController::class, 'update'])->name('update');
            Route::delete('/{item}', [ProposalItemController::class, 'destroy'])->name('destroy');
        });

    Route::get('/proposals/{proposal}/preview', [ProposalController::class, 'preview'])
        ->name('proposals.preview');

    Route::post('/proposals/{proposal}/regenerate-token', [ProposalController::class, 'regenerateToken'])
        ->name('proposals.regenerate-token');

    Route::post('/proposals/{proposal}/send', [ProposalController::class, 'send'])
        ->name('proposals.send');

    Route::get('/proposals/{proposal}/send-screen', [ProposalController::class, 'sendScreen'])
        ->name('proposals.send-screen');

    Route::post('/proposals/{proposal}/prepare-email-draft', [ProposalController::class, 'prepareEmailDraft'])
        ->name('proposals.prepare-email-draft');

    Route::get('/proposals/{proposal}/pdf', [ProposalController::class, 'downloadPdf'])
        ->name('proposals.pdf');

    Route::get('/proposals/{proposal}/pdf/view', [ProposalController::class, 'viewPdf'])
        ->name('proposals.pdf.view');

    Route::get('/proposals/{proposal}/delivery-center', [ProposalController::class, 'deliveryCenter'])
        ->name('proposals.delivery-center');

    Route::post('/proposals/{proposal}/mark-prepared-for-delivery', [ProposalController::class, 'markPreparedForDelivery'])
        ->name('proposals.mark-prepared-for-delivery');

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');

    Route::post('/proposals/{proposal}/follow-up', [ProposalController::class, 'markFollowedUp'])
        ->name('proposals.follow-up');

    Route::post('/proposals/{proposal}/snooze-follow-up', [ProposalController::class, 'snoozeFollowUp'])
        ->name('proposals.snooze-follow-up');

    Route::patch('/proposals/{proposal}/follow-up-note', [ProposalController::class, 'updateFollowUpNote'])
        ->name('proposals.follow-up-note');

    Route::get('/workspace-settings', [WorkspaceSettingsController::class, 'edit'])
        ->name('workspace-settings.edit');

    Route::patch('/workspace-settings', [WorkspaceSettingsController::class, 'update'])
        ->name('workspace-settings.update');




    Route::get('/platform-settings', [PlatformSettingsController::class, 'edit'])
        ->name('platform-settings.edit');

    Route::patch('/platform-settings', [PlatformSettingsController::class, 'update'])
        ->name('platform-settings.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
