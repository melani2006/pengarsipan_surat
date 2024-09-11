<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Models\Lampiran;
use App\Models\Kategori;
use App\Models\Config;
use App\Models\Surat;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SuratMasukController extends Controller
{
    /**
     * Menampilkan daftar resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Surat::incoming();

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('pages.transaksi.masuk.index', [
            'data' => $query->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Menampilkan daftar agenda surat masuk.
     *
     * @param Request $request
     * @return View
     */
    public function agenda(Request $request): View
    {
        $query = Surat::incoming()->agenda($request->since, $request->until, $request->filter);

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('pages.transaksi.masuk.agenda', [
            'data' => $query->render($request->search),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * Mencetak daftar agenda surat masuk.
     *
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $query = Surat::incoming()->agenda($request->since, $request->until, $request->filter);

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        $agenda = "Agenda";
        $surat = "Surat Masuk";
        $title = "$agenda $surat";

        return view('pages.transaksi.masuk.print', [
            'data' => $query->get(),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'config' => Config::pluck('value', 'code')->toArray(),
            'title' => $title,
        ]);
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.transaksi.masuk.create', [
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Menyimpan resource baru ke dalam storage.
     *
     * @param StoreLetterRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLetterRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            if ($request->type != LetterType::INCOMING->type()) throw new \Exception("Tipe surat tidak valid.");
            $newSurat = $request->validated();
            $newSurat['user_id'] = $user->id;
            $surat = Surat::create($newSurat);
            if ($request->hasFile('lampirans')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-' . $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $attachment->storeAs('public/attachments', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => $user->id,
                        'surat_id' => $surat->id,
                    ]);
                }
            }
            return redirect()
                ->route('transaksi.masuk.index')
                ->with('success', 'Berhasil menyimpan data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menampilkan resource yang ditentukan.
     *
     * @param Surat $incoming
     * @return View
     */
    public function show(Surat $incoming): View
    {
        return view('pages.transaksi.masuk.show', [
            'data' => $incoming->load(['classification', 'user', 'attachments']),
        ]);
    }

    /**
     * Menampilkan form untuk mengedit resource yang ditentukan.
     *
     * @param Surat $incoming
     * @return View
     */
    public function edit(Surat $incoming): View
    {
        return view('pages.transaksi.masuk.edit', [
            'data' => $incoming,
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Memperbarui resource yang ditentukan dalam storage.
     *
     * @param UpdateLetterRequest $request
     * @param Surat $incoming
     * @return RedirectResponse
     */
    public function update(UpdateLetterRequest $request, Surat $incoming): RedirectResponse
    {
        try {
            $incoming->update($request->validated());
            if ($request->hasFile('lampirans')) {
                foreach ($request->attachments as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-' . $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $attachment->storeAs('public/attachments', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => auth()->user()->id,
                        'surat_id' => $incoming->id,
                    ]);
                }
            }
            return back()->with('success', 'Berhasil memperbarui data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menghapus resource yang ditentukan dari storage.
     *
     * @param Surat $incoming
     * @return RedirectResponse
     */
    public function destroy(Surat $incoming): RedirectResponse
    {
        try {
            $incoming->delete();
            return redirect()
                ->route('transaksi.masuk.index')
                ->with('success', 'Berhasil menghapus data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
