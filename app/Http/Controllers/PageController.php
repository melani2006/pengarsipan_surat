<?php

namespace App\Http\Controllers;

use App\Enums\LetterType;
use App\Helpers\GeneralHelper;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Lampiran;
use App\Models\Config;
use App\Models\DisposiSI;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $todaySuratMasuk = Surat::masuk()->today()->count();
        $todaySuratKeluar = Surat::keluar()->today()->count();
        $todayDisposisiSurat = Disposisi::today()->count();
        $todayTransaksiSurat = $todaySuratMasuk + $todaySuratKeluar + $todayDisposisiSurat;

        $yesterdaySuratMasuk = Surat::masuk()->yesterday()->count();
        $yesterdaySuratKeluar = Surat::keluar()->yesterday()->count();
        $yesterdayDisposisiSurat = Disposisi::yesterday()->count();
        $yesterdayTransaksiSurat = $yesterdaySuratMasuk + $yesterdaySuratKeluar + $yesterdayDisposisiSurat;

        return view('pages.dashboard', [
            'greeting' => GeneralHelper::greeting(),
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM YYYY'),
            'todaySuratMasuk' => $todaySuratMasuk,
            'todaySuratKeluar' => $todaySuratKeluar,
            'todayDisposisiSurat' => $todayDisposisiSurat,
            'todayTransaksiSurat' => $todayTransaksiSurat,
            'activeUser' => User::active()->count(),
            'percentageSuratMasuk' => GeneralHelper::calculateChangePercentage($yesterdaySuratMasuk, $todaySuratMasuk),
            'percentageSuratKeluar' => GeneralHelper::calculateChangePercentage($yesterdaySuratKeluar, $todaySuratKeluar),
            'percentageDisposisiSurat' => GeneralHelper::calculateChangePercentage($yesterdayDisposisiSurat, $todayDisposisiSurat),
            'percentageTransaksiSurat' => GeneralHelper::calculateChangePercentage($yesterdayTransaksiSurat, $todayTransaksiSurat),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function profile(Request $request): View
    {
        return view('pages.profile', [
            'data' => auth()->user(),
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function profileUpdate(UpdateUserRequest $request): RedirectResponse
    {
        try {
            $newProfile = $request->validated();
            if ($request->hasFile('foto_profile')) {
//               DELETE OLD PICTURE
                $oldPicture = auth()->user()->foto_profile;
                if (str_contains($oldPicture, '/storage/avatars/')) {
                    $url = parse_url($oldPicture, PHP_URL_PATH);
                    Storage::delete(str_replace('/storage', 'public', $url));
                }

//                UPLOAD NEW PICTURE
                $filename = time() .
                    '-' . $request->file('foto_profile')->getFilename() .
                    '.' . $request->file('foto_profile')->getClientOriginalExtension();
                $request->file('foto_profile')->storeAs('public/avatars', $filename);
                $newProfile['foto_profile'] = asset('storage/avatars/' . $filename);
            }
            auth()->user()->update($newProfile);
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     */
    public function deactivate(): RedirectResponse
    {
        try {
            auth()->user()->update(['is_active' => false]);
            Auth::logout();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    public function settings(Request $request): View
    {
        return view('pages.setting', [
            'configs' => Config::all(),
        ]);
    }

    /**
     * @param UpdateConfigRequest $request
     * @return RedirectResponse
     */
    public function settingsUpdate(UpdateConfigRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            foreach ($request->validated() as $code => $value) {
                Config::where('code', $code)->update(['value' => $value]);
            }
            DB::commit();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeLampiran(Request $request): RedirectResponse
    {
        try {
            $lampiran = Lampiran::find($request->id);
            $oldPicture = $lampiran->path_url;
            if (str_contains($oldPicture, '/storage/lampirans/')) {
                $url = parse_url($oldPicture, PHP_URL_PATH);
                Storage::delete(str_replace('/storage', 'public', $url));
            }
            $lampiran->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
