<?php

use App\Http\Controllers\ForgotPasswordController;

// ...existing code...

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Formulaire de nouveau mot de passe
use App\Http\Controllers\ResetPasswordController;
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/test-email-api', [GmailApiController::class, 'sendTestEmail']);

use App\Http\Controllers\GmailApiController;

// ...existing code...

Route::get('/test-email-api', [GmailApiController::class, 'sendTestEmail']);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->middleware(['auth', 'verified'])->name('account');
Route::post('/account', [App\Http\Controllers\AccountController::class, 'update'])->middleware(['auth', 'verified'])->name('account.update');
Route::delete('/account', [App\Http\Controllers\AccountController::class, 'destroy'])->middleware(['auth', 'verified'])->name('account.delete');

Route::get('/watchlist', [App\Http\Controllers\WatchlistController::class, 'index'])->middleware(['auth', 'verified'])->name('watchlist.index');
Route::post('/watchlist/toggle', [App\Http\Controllers\WatchlistController::class, 'toggle'])->middleware(['auth', 'verified'])->name('watchlist.toggle');
Route::post('/watchlist/status', [App\Http\Controllers\WatchlistController::class, 'status'])->name('watchlist.status');
Route::post('/watchlist/update', [App\Http\Controllers\WatchlistController::class, 'update'])->middleware(['auth', 'verified'])->name('watchlist.update');

Route::get('/movies', [App\Http\Controllers\MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [App\Http\Controllers\MovieController::class, 'show'])->name('movies.show');
// Page de recherche de films
Route::get('/search', [App\Http\Controllers\MovieController::class, 'search'])->name('movies.search');
Route::get('/play/movie-trailer/{id}', [App\Http\Controllers\MovieController::class, 'trailer'])->name('movie.trailer');
// Page de lecture de film – première vidéo active
Route::get('/play/movies/{id}', [App\Http\Controllers\MovieController::class, 'play'])->name('movie.play');

// Routes pour les séries
Route::get('/series', [App\Http\Controllers\SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{id}', [App\Http\Controllers\SeriesController::class, 'show'])->name('series.show');
// Page de lecture d'épisode
Route::get('/play/series/{series_id}/season/{season_number}/episode/{episode_number}', [App\Http\Controllers\SeriesController::class, 'play'])->name('series.play');

use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('Ceci est un test d\'envoi d\'email depuis Laravel.', function ($message) {
        $message->to('enriixk.glss@gmail.com')
                ->subject('Test Email Laravel');
    });
    return 'Email de test envoyé à enriixk.glss@gmail.com';
});
// ...existing code...
// Network detail page
Route::get('/network/{id}', [App\Http\Controllers\NetworkController::class, 'show'])->name('networks.show');
Route::get('/animes', [App\Http\Controllers\AnimeController::class, 'index'])->name('animes.index');

// Routes pour l'authentification
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Routes pour l'inscription
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'show'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Zone d'administration, accès réservé aux admins
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])
        ->middleware(['auth', 'admin'])->name('admin');
    Route::get('/admin/movies', [App\Http\Controllers\AdminController::class, 'movies'])
        ->middleware(['auth', 'admin'])->name('admin.movies');
    Route::get('/admin/movies/{id}/edit', [App\Http\Controllers\AdminController::class, 'editMovie'])
        ->middleware(['auth', 'admin'])->name('admin.movies.edit');
    Route::put('/admin/movies/{id}', [App\Http\Controllers\AdminController::class, 'updateMovie'])
        ->middleware(['auth', 'admin'])->name('admin.movies.update');
    Route::get('/admin/series', [App\Http\Controllers\AdminController::class, 'series'])
        ->middleware(['auth', 'admin'])->name('admin.series');
    Route::get('/admin/series/{id}/edit', [App\Http\Controllers\AdminController::class, 'editSerie'])
        ->middleware(['auth', 'admin'])->name('admin.series.edit');
    Route::get('/admin/seasons/{id}/edit', [App\Http\Controllers\AdminController::class, 'editSeason'])
        ->middleware(['auth', 'admin'])->name('admin.seasons.edit');
    Route::get('/admin/episodes/{id}/edit', [App\Http\Controllers\AdminController::class, 'editEpisode'])
        ->middleware(['auth', 'admin'])->name('admin.episodes.edit');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])
        ->middleware(['auth', 'admin'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])
        ->middleware(['auth', 'admin'])->name('admin.users.edit');
    // Import depuis TMDB
    Route::get('/admin/import', [App\Http\Controllers\AdminImportController::class, 'showImportForm'])
        ->middleware(['auth', 'admin'])->name('admin.import.form');
    Route::post('/admin/import', [App\Http\Controllers\AdminImportController::class, 'import'])
        ->middleware(['auth', 'admin'])->name('admin.import');

    // Routes pour la gestion des vidéos des films
    Route::prefix('admin/movies/{movie}/videos')->name('admin.movies.videos.')->group(function () {
        Route::get('create', [App\Http\Controllers\VideoController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\VideoController::class, 'store'])->name('store');
        Route::get('{video}/edit', [App\Http\Controllers\VideoController::class, 'edit'])->name('edit');
        Route::put('{video}', [App\Http\Controllers\VideoController::class, 'update'])->name('update');
        Route::delete('{video}', [App\Http\Controllers\VideoController::class, 'destroy'])->name('destroy');
    });
});
