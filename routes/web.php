<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::resource('users', \App\Http\Controllers\UserController::class)
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

    Route::delete('lampiran', [\App\Http\Controllers\PageController::class, 'removelampiran'])
        ->name('lampiran.destroy');

    Route::prefix('transaksi')->as('transaksi.')->group(function () {
        Route::resource('masuk', \App\Http\Controllers\SuratMasukController::class);
        Route::resource('keluar', \App\Http\Controllers\SuratKeluarController::class);
        Route::resource('{surat}/disposisi', \App\Http\Controllers\DisposisiController::class)->except(['show']);
    });

    Route::prefix('riwayat')->as('riwayat.')->group(function () {
        Route::get('masuk', [\App\Http\Controllers\SuratMasukController::class, 'riwayat'])->name('masuk');
        Route::get('masuk/print', [\App\Http\Controllers\SuratMasukController::class, 'print'])->name('masuk.print');
        Route::get('keluar', [\App\Http\Controllers\SuratKeluarController::class, 'riwayat'])->name('keluar');
        Route::get('keluar/print', [\App\Http\Controllers\SuratKeluarController::class, 'print'])->name('keluar.print');
    });

    Route::prefix('reference')->as('reference.')->middleware(['role:admin'])->group(function () {
        Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->except(['show', 'create', 'edit']);
        Route::resource('status', \App\Http\Controllers\StatusSuratController::class)->except(['show', 'create', 'edit']);
    });

});
