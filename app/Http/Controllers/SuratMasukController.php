<?php

namespace App\Http\Controllers;

use App\Enums\SuratType;
use App\Http\Requests\StoreSuratRequest;
use App\Http\Requests\UpdateSuratRequest;
use App\Models\Lampiran;
use App\Models\Kategori;
use App\Models\Surat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        $tanggal = $request->tanggal;
        $cari = $request->input('cari', 'tanggal_surat');
        
        // Jika admin, dapatkan semua surat masuk
        if ($user->isAdmin()) {
            $data = Surat::masuk()->when($tanggal, function ($query, $tanggal) use ($cari) {
                return $query->whereDate($cari, $tanggal);
            })->render($request->search);
            
            $dataKeluar = Surat::keluar()->when($tanggal, function ($query, $tanggal) use ($cari) {
                return $query->whereDate($cari, $tanggal);
            })->render($request->search);
        } else {
            // Jika bukan admin, hanya surat milik pengguna
            $data = Surat::masuk()->where('user_id', $user->id)
                ->when($tanggal, function ($query, $tanggal) use ($cari) {
                    return $query->whereDate($cari, $tanggal);
                })->render($request->search);
            
            $dataKeluar = Surat::keluar()->where('user_id', $user->id)
                ->when($tanggal, function ($query, $tanggal) use ($cari) {
                    return $query->whereDate($cari, $tanggal);
                })->render($request->search);
        }
    
        return view('pages.transaksi.masuk.riwayat', [
            'data' => $data,
            'dataKeluar' => $dataKeluar,
            'search' => $request->search,
            'tanggal' => $request->tanggal,
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
        $title = 'Riwayat Surat Masuk';
        $tanggal = $request->tanggal;
        $cari = $request->input('cari', 'tanggal_surat'); // Default ke tanggal_surat
    
        $data = $user->isAdmin()
            ? Surat::masuk()->when($tanggal, function ($query, $tanggal) use ($cari) {
                return $query->whereDate($cari, $tanggal);
            })->get()
            : Surat::masuk()->where('user_id', $user->id)
                            ->when($tanggal, function ($query, $tanggal) use ($cari) {
                                return $query->whereDate($cari, $tanggal);
                            })->get();
    
        return view('pages.transaksi.masuk.print', [
            'data' => $data,
            'search' => $request->search,
            'tanggal' => $request->tanggal,
            'cari' => $request->cari,
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

            if ($request->type != SuratType::MASUK->type()) throw new \Exception('Terjadi kesalahan saat menyimpan surat masuk.');
            $newSurat = $request->validated();
            $newSurat['user_id'] = $user->id;
            $surat = Surat::create($newSurat);
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
                        'surat_id' => $surat->id,
                    ]);
                }
            }
            return redirect()
                ->route('transaksi.masuk.index')
                ->with('success', 'Surat masuk berhasil disimpan.');
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
                    $Extension = $lampiran->getClientOriginalExtension();
                    if (!in_array($Extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-' . $lampiran->getClientOriginalName();
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
            return redirect()->route('transaksi.masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
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
                ->with('success', 'Surat masuk berhasil dihapus.');
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}