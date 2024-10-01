<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDisposisiRequest;
use App\Http\Requests\UpdateDisposisiRequest;
use App\Models\Disposisi;
use App\Models\Surat;
use App\Models\StatusSurat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Surat $surat
     * @return View
     */
    public function index(Request $request, Surat $surat): View
    {
        return view('pages.transaksi.disposisi.index', [
            'data' => Disposisi::render($surat, $request->search),
            'surat' => $surat,
            'search' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Surat $surat
     * @return View
     */
    public function create(Surat $surat): View
    {
        return view('pages.transaksi.disposisi.create', [
            'surat' => $surat,
            'statuses' => StatusSurat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Surat $surat
     * @param StoreDisposisiRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDisposisiRequest $request, Surat $surat): RedirectResponse
    {
        try {
            $newDisposisi = $request->validated();
            $newDisposisi['user_id'] = auth()->user()->id;
            $newDisposisi['surat_id'] = $surat->id;
            Disposisi::create($newDisposisi);
            return redirect()
                ->route('transaksi.disposisi.index', $surat)
                ->with('success', 'Disposisi berhasil disimpan.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Surat $surat
     * @param Disposisi $disposisi
     * @return View
     */
    public function edit(Surat $surat, Disposisi $disposisi): View
    {
        return view('pages.transaksi.disposisi.edit', [
            'data' => $disposisi,
            'surat' => $surat,
            'statuses' => StatusSurat::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDisposisiRequest $request
     * @param Surat $surat
     * @param Disposisi $disposisi
     * @return RedirectResponse
     */
    public function update(UpdateDisposisiRequest $request, Surat $surat, Disposisi $disposisi): RedirectResponse
    {
        try {
            $disposisi->update($request->validated());
            return back()->with('success', 'Disposisi berhasil diperbarui.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Surat $surat
     * @param Disposisi $disposisi
     * @return RedirectResponse
     */
    public function destroy(Surat $surat, Disposisi $disposisi): RedirectResponse
    {
        try {
            $disposisi->delete();
            return back()->with('success', 'Disposisi berhasil dihapus.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}