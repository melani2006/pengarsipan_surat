<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
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
     * Menampilkan daftar resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Surat::outgoing();

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('pages.transaksi.keluar.index', [
            'data' => $query->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Menampilkan daftar agenda surat keluar.
     *
     * @param Request $request
     * @return View
     */
    public function agenda(Request $request): View
    {
        $query = Surat::outgoing()->agenda($request->since, $request->until, $request->filter);

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('pages.transaksi.keluar.agenda', [
            'data' => $query->render($request->search),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'query' => $request->getQueryString(),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $query = Surat::outgoing()->agenda($request->since, $request->until, $request->filter);

        if (auth()->user()->role != 'admin') {
            $query->where('user_id', auth()->id());
        }

        $agenda = "Agenda";
        $surat = "Surat Keluar";
        $title = App::getLocale() == 'id' ? "$agenda $surat" : "$surat $agenda";

        return view('pages.transaksi.keluar.print', [
            'data' => $query->get(),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'filter' => $request->filter,
            'config' => Config::pluck('value','code')->toArray(),
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
        return view('pages.transaksi.keluar.create', [
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

            if ($request->type != LetterType::OUTGOING->type()) throw new \Exception("Tipe surat tidak sesuai.");
            $newSurat = $request->validated();
            $newSurat['user_id'] = $user->id;
            $surat = Surat::create($newSurat);
            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $attachment) {
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $attachment->getClientOriginalName();
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
                ->route('transaksi.keluar.index')
                ->with('success', 'Berhasil menyimpan data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menampilkan resource yang ditentukan.
     *
     * @param Surat $outgoing
     * @return View
     */
    public function show(Surat $outgoing): View
    {
        return view('pages.transaksi.keluar.show', [
            'data' => $outgoing->load(['kategori', 'user', 'lampirans']),
        ]);
    }

    /**
     * Menampilkan form untuk mengedit resource yang ditentukan.
     *
     * @param Surat $outgoing
     * @return View
     */
    public function edit(Surat $outgoing): View
    {
        return view('pages.transaksi.keluar.edit', [
            'data' => $outgoing,
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Memperbarui resource yang ditentukan dalam storage.
     *
     * @param UpdateLetterRequest $request
     * @param Surat $outgoing
     * @return RedirectResponse
     */
    public function update(UpdateLetterRequest $request, Surat $outgoing): RedirectResponse
    {
        try {
            $outgoing->update($request->validated());
            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $attachment) { 
                    $extension = $attachment->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $attachment->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $attachment->storeAs('public/attachments', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'extension' => $extension,
                        'user_id' => auth()->user()->id,
                        'surat_id' => $outgoing->id,
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
     * @param Surat $outgoing
     * @return RedirectResponse
     */
    public function destroy(Surat $outgoing): RedirectResponse
    {
        try {
            $outgoing->delete();
            return redirect()
                ->route('transaksi.keluar.index')
                ->with('success', 'Berhasil menghapus data.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
