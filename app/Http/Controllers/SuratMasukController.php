<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Http\Requests\StoreSuratRequest;
use App\Http\Requests\UpdateSuratRequest;
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        // Jika admin, dapatkan semua surat masuk, jika bukan admin hanya surat miliknya sendiri
        $data = $user->isAdmin() 
            ? Surat::masuk()->render($request->search)
            : Surat::masuk()->where('user_id', $user->id)->render($request->search);
    
        return view('pages.transaksi.masuk.index', [
            'data' => $data,
            'search' => $request->search,
        ]);
    }
    
    /**
     * Display a listing of the riwayat surat masuk.
     *
     * @param Request $request
     * @return View
     */
    public function riwayat(Request $request): View
{
    $user = auth()->user();

    // Jika admin, dapatkan semua surat masuk
    if ($user->isAdmin()) {
        $data = Surat::masuk()->riwayat($request->since, $request->until, $request->cari)->render($request->search);
        $dataKeluar = Surat::keluar()->riwayat($request->since, $request->until, $request->cari)->render($request->search);
    } else {
        // Jika bukan admin, hanya surat milik pengguna
        $data = Surat::masuk()->where('user_id', $user->id)->riwayat($request->since, $request->until, $request->cari)->render($request->search);
        $dataKeluar = Surat::keluar()->where('user_id', $user->id)->riwayat($request->since, $request->until, $request->cari)->render($request->search);
    }

    return view('pages.transaksi.masuk.riwayat', [
        'data' => $data,
        'dataKeluar' => $dataKeluar,
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
        $riwayat = __('menu.riwayat.menu');
        $surat = __('menu.riwayat.surat_masuk');
        $title = App::getLocale() == 'id' ? "$riwayat $surat" : "$surat $riwayat";
    
        // Jika admin, dapatkan semua surat untuk dicetak, jika bukan admin hanya miliknya sendiri
        $data = $user->isAdmin()
            ? Surat::masuk()->riwayat($request->since, $request->until, $request->cari)->get()
            : Surat::masuk()->where('user_id', $user->id)
                            ->riwayat($request->since, $request->until, $request->cari)
                            ->get();
    
        return view('pages.transaksi.masuk.print', [
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
        return view('pages.transaksi.masuk.create', [
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

            if ($request->type != LetterType::INCOMING->type()) throw new \Exception(__('menu.transaksi.surat_masuk'));
            $newSurat = $request->validated();
            $newSurat['user_id'] = $user->id;
            $surat = Surat::create($newSurat);
            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $lampiran) {
                    $Extension= $lampiran->getClientOriginalExtension();
                    if (!in_array($Extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'ekstensi' => $Extension,
                        'user_id' => $user->id,
                        'surat_id' => $surat->id,
                    ]);
                }
            }
            return redirect()
                ->route('transaksi.masuk.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Surat $masuk
     * @return View
     */
    public function show(Surat $masuk): View
    {
        return view('pages.transaksi.masuk.show', [
            'data' => $masuk->load(['kategori', 'user', 'lampirans']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Surat $masuk
     * @return View
     */
    public function edit(Surat $masuk): View
    {
        return view('pages.transaksi.masuk.edit', [
            'data' => $masuk,
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSuratRequest $request
     * @param Surat $masuk
     * @return RedirectResponse
     */
    public function update(UpdateSuratRequest $request, Surat $masuk): RedirectResponse
    {
        try {
            $masuk->update($request->validated());
            if ($request->hasFile('lampirans')) {
                foreach ($request->lampirans as $lampiran) {
                    $Extension= $lampiran->getClientOriginalExtension();
                    if (!in_array($Extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'ekstensi' => $Extension,
                        'user_id' => auth()->user()->id,
                        'surat_id' => $masuk->id,
                    ]);
                }
            }
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Surat $masuk
     * @return RedirectResponse
     */
    public function destroy(Surat $masuk): RedirectResponse
    {
        try {
            $masuk->delete();
            return redirect()
                ->route('transaksi.masuk.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}