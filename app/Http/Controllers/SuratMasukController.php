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
        return view('pages.transaksi.masuk.index', [
            'data' => Surat::incoming()->render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Display a listing of the surat masuk agenda.
     *
     * @param Request $request
     * @return View
     */
    public function agenda(Request $request): View
    {
        return view('pages.transaksi.masuk.agenda', [
            'data' => Surat::incoming()->agenda($request->since, $request->until, $request->cari)->render($request->search),
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
        $agenda = __('menu.agenda.menu');
        $surat = __('menu.agenda.surat_masuk');
        $title = App::getLocale() == 'id' ? "$agenda $surat" : "$surat $agenda";
        return view('pages.transaksi.masuk.print', [
            'data' => Surat::masuk()->agenda($request->since, $request->until, $request->cari)->get(),
            'search' => $request->search,
            'since' => $request->since,
            'until' => $request->until,
            'cari' => $request->cari,
            'config' => Config::pluck('value','code')->toArray(),
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
                    $extension = $lampiran->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
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
                    $extension = $lampiran->getClientOriginalExtension();
                    if (!in_array($extension, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                    $filename = time() . '-'. $lampiran->getClientOriginalName();
                    $filename = str_replace(' ', '-', $filename);
                    $lampiran->storeAs('public/lampirans', $filename);
                    Lampiran::create([
                        'filename' => $filename,
                        'extension' => $extension,
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