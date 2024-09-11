<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterStatusRequest;
use App\Http\Requests\UpdateLetterStatusRequest;
use App\Models\StatusSurat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusSuratController extends Controller
{
    /**
     * Menampilkan daftar resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.reference.status', [
            'data' => StatusSurat::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Menyimpan resource baru ke dalam storage.
     *
     * @param StoreLetterStatusRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLetterStatusRequest $request): RedirectResponse
    {
        try {
            StatusSurat::create($request->validated());
            return back()->with('success', 'Berhasil menyimpan data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Memperbarui resource yang ditentukan dalam storage.
     *
     * @param UpdateLetterStatusRequest $request
     * @param StatusSurat $status
     * @return RedirectResponse
     */
    public function update(UpdateLetterStatusRequest $request, StatusSurat $status): RedirectResponse
    {
        try {
            $status->update($request->validated());
            return back()->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menghapus resource yang ditentukan dari storage.
     *
     * @param StatusSurat $status
     * @return RedirectResponse
     */
    public function destroy(StatusSurat $status): RedirectResponse
    {
        try {
            $status->delete();
            return back()->with('success', 'Berhasil menghapus data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
