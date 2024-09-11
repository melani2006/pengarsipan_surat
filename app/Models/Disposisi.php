<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'due_date',
        'content',
        'Catatan',
        'status_surat',
        'surat_id',
        'user_id'
    ];

    protected $appends = [
        'formatted_due_date',
    ];

    /**
     * Mendapatkan atribut tanggal jatuh tempo yang telah diformat.
     *
     * @return string
     */
    public function getFormattedDueDateAttribute(): string {
        return Carbon::parse($this->due_date)->isoFormat('dddd, D MMMM YYYY');
    }

    /**
     * Scope untuk mendapatkan disposisi yang dibuat hari ini.
     *
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    /**
     * Scope untuk mendapatkan disposisi yang dibuat kemarin.
     *
     * @param $query
     * @return mixed
     */
    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', now()->addDays(-1));
    }

    /**
     * Scope untuk mencari disposisi berdasarkan kata kunci.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->orWhere('content', 'LIKE', '%' . $find . '%')
                ->orWhere('to', 'LIKE', $find . '%');
        });
    }

    /**
     * Scope untuk merender daftar disposisi dengan pencarian dan surat terkait.
     *
     * @param $query
     * @param Surat $surat
     * @param $search
     * @return mixed
     */
    public function scopeRender($query, Surat $surat, $search)
    {
        $pageSize = Config::code(\App\Enums\Config::PAGE_SIZE)->first();
        return $query
            ->with(['user', 'status', 'surat'])
            ->search($search)
            ->when($surat, function ($query, $surat) {
                return $query
                    ->where('surat_id', $surat->id);
            })
            ->latest('created_at')
            ->paginate($pageSize->value)
            ->appends([
                'search' => $search,
            ]);
    }

    /**
     * Relasi dengan pengguna.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan status surat.
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusSurat::class, 'status_surat', 'id');
    }

    /**
     * Relasi dengan surat.
     *
     * @return BelongsTo
     */
    public function Surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_id', 'id');
    }
}
