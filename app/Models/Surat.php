<?php

namespace App\Models;

use App\Enums\SuratType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'kegiatan',
        'pengirim',
        'penerima',
        'tanggal_surat',
        'tanggal_diterima',
        'deskripsi',
        'catatan',
        'type',
        'kategori_code',
        'user_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    protected $appends = [
        'formatted_tanggal_surat',
        'formatted_tanggal_diterima',
        'formatted_created_at',
        'formatted_updated_at',
    ];

    public function getFormattedTanggalSuratAttribute(): string {
        return Carbon::parse($this->tanggal_surat)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedTanggalDiterimaAttribute(): string {
        return Carbon::parse($this->tanggal_diterima)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedCreatedAtAttribute(): string {
        return $this->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    public function getFormattedUpdatedAtAttribute(): string {
        return $this->updated_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    public function scopeType($query, SuratType $type)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $query->where('type', $type->type());
        } else {
            return $query->where('type', $type->type())->where('user_id', $user->id);
        }
    }

    public function scopeMasuk($query)
    {
        return $this->scopeType($query, SuratType::MASUK);
    }

    public function scopeKeluar($query)
    {
        return $this->scopeType($query, SuratType::KELUAR);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', now()->addDays(-1));
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('nomor_surat', $find)
                ->orWhere('kegiatan', $find)
                ->orWhere('pengirim', 'LIKE', $find . '%')
                ->orWhere('penerima', 'LIKE', $find . '%');
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->with(['lampirans', 'kategori'])
            ->search($search)
            ->latest('tanggal_surat')
            ->paginate(10)
            ->appends([
                'search' => $search,
            ]);
    }

    public function scopeRiwayat($query, $since, $until, $cari)
    {
        $user = auth()->user();

        return $query->when($since && $until, function ($query) use ($since, $until, $cari, $user) {
            if ($user->isAdmin()) {
                return $query->whereBetween(DB::raw('DATE(' . $cari . ')'), [$since, $until]);
            } else {
                return $query->where('user_id', $user->id)
                             ->whereBetween(DB::raw('DATE(' . $cari . ')'), [$since, $until]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_code', 'code');
    }

    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'surat_id', 'id');
    }

    public function lampirans(): HasMany
    {
        return $this->hasMany(Lampiran::class, 'surat_id', 'id');
    }
}