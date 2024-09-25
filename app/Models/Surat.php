<?php

namespace App\Models;

use App\Enums\LetterType;
use App\Enums\Config as ConfigEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Surat extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'nomor_surat',
        'nomor_agenda',
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

    /**
     * @var string[]
     */
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

    public function getFormattedLetterDateAttribute(): string {
        return Carbon::parse($this->tanggal_surat)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedReceivedDateAttribute(): string {
        return Carbon::parse($this->tanggal_diterima)->isoFormat('dddd, D MMMM YYYY');
    }

    public function getFormattedCreatedAtAttribute(): string {
        return $this->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    public function getFormattedUpdatedAtAttribute(): string {
        return $this->updated_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    public function scopeType($query, LetterType $type)
    {
        return $query->where('type', $type->type());
    }

    public function scopeMasuk($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    public function scopeKeluar($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
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
                ->orWhere('nomor_agenda', $find)
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
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }

    public function scopeAgenda($query, $since, $until, $cari)
    {
        return $query
            ->when($since && $until && $cari, function ($query, $condition) use ($since, $until, $cari) {
                return $query->whereBetween(DB::raw('DATE(' . $cari . ')'), [$since, $until]);
            });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_code', 'code');
    }

    /**
     * @return HasMany
     */
    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'surat_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function lampirans(): HasMany
    {
        return $this->hasMany(Lampiran::class, 'surat_id', 'id');
    }
}