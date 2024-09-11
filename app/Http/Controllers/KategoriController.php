<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Models\Kategori;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar resource.
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
     * Menyimpan resource yang baru dibuat.
     *
     * @param StoreClassificationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreClassificationRequest $request): RedirectResponse
    {
        try {
            Kategori::create($request->validated());
            return back()->with('success', 'Berhasil menyimpan data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Memperbarui resource yang ditentukan.
     *
     * @param UpdateClassificationRequest $request
     * @param Kategori $kategori
     * @return RedirectResponse
     */
    public function update(UpdateClassificationRequest $request, Kategori $kategori): RedirectResponse
    {
        try {
            $kategori->update($request->validated());
            return back()->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menghapus resource yang ditentukan.
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
