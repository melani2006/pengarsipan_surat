<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusSuratRequest;
use App\Http\Requests\UpdateStatusSuratRequest;
use App\Models\StatusSurat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusSuratController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     *
     * @param StoreStatusSuratRequest $request
     * @return RedirectResponse
     */
    public function store(StoreStatusSuratRequest $request): RedirectResponse
    {
        try {
            StatusSurat::create($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStatusSuratRequest $request
     * @param StatusSurat $status
     * @return RedirectResponse
     */
    public function update(UpdateStatusSuratRequest $request, StatusSurat $status): RedirectResponse
    {
        try {
            $status->update($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StatusSurat $status
     * @return RedirectResponse
     */
    public function destroy(StatusSurat $status): RedirectResponse
    {
        try {
            $status->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}