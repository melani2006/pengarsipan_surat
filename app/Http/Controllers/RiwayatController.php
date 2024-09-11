<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    /**
     * Menampilkan riwayat surat masuk.
     *
     * @param Request $request
     * @return View
     */
    public function incoming(Request $request): View
    {
        return view('pages.riwayat.masuk', [
            'data' => Surat::incoming()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Menampilkan riwayat surat keluar.
     *
     * @param Request $request
     * @return View
     */
    public function outgoing(Request $request): View
    {
        return view('pages.riwayat.keluar', [
            'data' => Surat::outgoing()->render($request->search),
            'search' => $request->search,
        ]);
    }
}
