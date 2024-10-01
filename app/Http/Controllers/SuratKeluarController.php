<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreSuratRequest;
use App\Http\Requests\UpdateSuratRequest;
use App\Models\Lampiran;
use App\Models\Kategori;
use App\Models\Config;
use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        // Admin dapat melihat semua surat keluar
        $data = Surat::keluar()->render($request->search);

        // Jika bukan admin, tampilkan hanya surat keluar milik user tersebut
        if (!$user->isAdmin()) {
            $data = Surat::where('user_id', $user->id)->keluar()->render($request->search);
        }

        return view('pages.transaksi.keluar.index', [
            'data' => $data,
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the riwayat surat keluar.
     *
     * @param Request $request
     * @return View
     */
    public function riwayat(Request $request): View
    {
        $user = auth()->user();

        // Admin melihat semua surat keluar
        $data = Surat::keluar()->riwayat($request->since, $request->until, $request->cari)->render($request->search);

        // Jika bukan admin, tampilkan hanya surat keluar milik user tersebut
        if (!$user->isAdmin()) {
            $data = Surat::where('user_id', $user->id)->keluar()->riwayat($request->since, $request->until, $request->cari)->render($request->search);
        }

        return view('pages.transaksi.keluar.riwayat', [
            'data' => $data,
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'cari' => $request->cari,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $user = auth()->user();
        $riwayat = 'Riwayat Surat';
        $surat = 'Surat Keluar';
        $title = "$riwayat $surat";

        // Admin melihat semua surat keluar
        $data = Surat::keluar()->riwayat($request->since, $request->until, $request->cari)->get();

        // Jika bukan admin, tampilkan hanya surat keluar milik user tersebut
        if (!$user->isAdmin()) {
            $data = Surat::where('user_id', $user->id)->keluar()->riwayat($request->since, $request->until, $request->cari)->get();
        }

        return view('pages.transaksi.keluar.print', [
            'data' => $data,
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'cari' => $request->cari,
            'config' => Config::pluck('value', 'code')->toArray(),
            'title' => $title,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.transaksi.keluar.create', [
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSuratRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSuratRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            if ($request->type != LetterType::OUTGOING->type()) {
                throw new \Exception('Jenis surat tidak valid.');
            }
            
            $newSurat = $request->validated();
            $newSurat['user_id'] = $user->id;
            $Surat = Surat::create($newSurat);

            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $lampiran) {
                    $Extension = $lampiran->getClientOriginalExtension();
                    if (!in_array($Extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-' . $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'ekstensi' => $Extension,
                        'user_id' => $user->id,
                        'surat_id' => $Surat->id,
                    ]);
                }
            }

            return redirect()
                ->route('transaksi.keluar.index')
                ->with('success', 'Surat keluar berhasil ditambahkan.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Surat $keluar
     * @return View
     */
    public function show(Surat $keluar): View
    {
        return view('pages.transaksi.keluar.show', [
            'data' => $keluar->load(['kategori', 'user', 'lampirans']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Surat $keluar
     * @return View
     */
    public function edit(Surat $keluar): View
    {
        return view('pages.transaksi.keluar.edit', [
            'data' => $keluar,
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSuratRequest $request
     * @param Surat $keluar
     * @return RedirectResponse
     */
    public function update(UpdateSuratRequest $request, Surat $keluar): RedirectResponse
    {
        try {
            $keluar->update($request->validated());

            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $lampiran) {
                    $Extension = $lampiran->getClientOriginalExtension();
                    if (!in_array($Extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-' . $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'ekstensi' => $Extension,
                        'user_id' => auth()->user()->id,
                        'surat_id' => $keluar->id,
                    ]);
                }
            }

            return back()->with('success', 'Surat keluar berhasil diperbarui.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Surat $keluar
     * @return RedirectResponse
     */
    public function destroy(Surat $keluar): RedirectResponse
    {
        try {
            $keluar->delete();
            return redirect()
                ->route('transaksi.keluar.index')
                ->with('success', 'Surat keluar berhasil dihapus.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}