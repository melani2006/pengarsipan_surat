<?php

use Illuminate\Support\Facades\Route;

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

Route::get('login', function () {
    return view('pages.login'); // Pastikan view ini ada di resources/views/pages/login.blade.php
})->name('login');

Route::post('login', function (Illuminate\Http\Request $request) {
    // Logika autentikasi manual di sini
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Jika autentikasi berhasil
        return redirect()->intended('pengarsipan_surat');
    }

    // Jika autentikasi gagal
    return redirect()->back()->withErrors(['email' => 'Email atau kata sandi salah.']);
});

Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/pengarsipan_surat', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

    Route::resource('user', \App\Http\Controllers\UserController::class)
        ->except(['show', 'edit', 'create'])
        ->middleware(['role:admin']);

    Route::get('profile', [\App\Http\Controllers\PageController::class, 'profile'])
        ->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\PageController::class, 'profileUpdate'])
        ->name('profile.update');
    Route::put('profile/deactivate', [\App\Http\Controllers\PageController::class, 'deactivate'])
        ->name('profile.deactivate')
        ->middleware(['role:staff']);

    Route::get('settings', [\App\Http\Controllers\PageController::class, 'settings'])
        ->name('settings.show')
        ->middleware(['role:admin']);
    Route::put('settings', [\App\Http\Controllers\PageController::class, 'settingsUpdate'])
        ->name('settings.update')
        ->middleware(['role:admin']);

    Route::delete('attachment', [\App\Http\Controllers\PageController::class, 'removeAttachment'])
        ->name('attachment.destroy');

    Route::prefix('transaksi')->as('transaksi.')->group(function () {
        Route::resource('masuk', \App\Http\Controllers\SuratMasukController::class);
        Route::resource('keluar', \App\Http\Controllers\SuratKeluarController::class);
        Route::resource('{letter}/disposisi', \App\Http\Controllers\DisposisiController::class)->except(['show']);
    });

    Route::prefix('agenda')->as('agenda.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\SuratMasukController::class, 'agenda'])->name('incoming');
        Route::get('incoming/print', [\App\Http\Controllers\SuratMasukController::class, 'print'])->name('incoming.print');
        Route::get('outgoing', [\App\Http\Controllers\SuratKeluarController::class, 'agenda'])->name('outgoing');
        Route::get('outgoing/print', [\App\Http\Controllers\SuratKeluarController::class, 'print'])->name('outgoing.print');
    });

    Route::prefix('riwayat')->as('riwayat.')->group(function () {
        Route::get('incoming', [\App\Http\Controllers\RiwayatController::class, 'incoming'])->name('masuk');
        Route::get('outgoing', [\App\Http\Controllers\RiwayatController::class, 'outgoing'])->name('keluar');
    });

    Route::prefix('reference')->as('reference.')->middleware(['role:admin'])->group(function () {
        Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', \App\Http\Controllers\StatusSuratController::class)->except(['show', 'create', 'edit']);
    });

});
