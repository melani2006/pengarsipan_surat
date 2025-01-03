<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.reference.kategori', [
            'data' => Kategori::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreKategoriRequest $request
     * @return RedirectResponse
     */
    public function store(StoreKategoriRequest $request): RedirectResponse
    {
        try {
            Kategori::create($request->validated());
            return back()->with('success', 'Berhasil menyimpan data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateKategoriRequest $request
     * @param Kategori $kategori
     * @return RedirectResponse
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        try {
            $kategori->update($request->validated());
            return redirect()->route('reference.kategori.index')->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kategori $kategori
     * @return RedirectResponse
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        try {
            $kategori->delete();
            return back()->with('success', 'Berhasil menghapus data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
