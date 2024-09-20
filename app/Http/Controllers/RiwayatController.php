<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function masuk(Request $request): View
    {
        return view('pages.riwayat.masuk', [
            'data' => Lampiran::incoming()->render($request->search),
            'search' => $request->search,
        ]);
    }

    public function keluar(Request $request): View
    {
        return view('pages.riwayat.keluar', [
            'data' => Lampiran::outgoing()->render($request->search),
            'search' => $request->search,
        ]);
    }
}