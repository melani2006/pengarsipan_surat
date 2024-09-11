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
        'reference_number',
        'agenda_number',
        'from',
        'penerima',
        'Tanggal_Surat',
        'Tanggal_Diterima',
        'deskripsi',
        'Catatan',
        'type',
        'kategori_code',
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'Tanggal_Surat' => 'date',
        'Tanggal_Diterima' => 'date',
    ];

    protected $appends = [
        'formatted_Tanggal_Surat',
        'formatted_Tanggal_Diterima',
        'formatted_created_at',
        'formatted_updated_at',
    ];

    /**
     * Mendapatkan atribut tanggal surat yang telah diformat.
     *
     * @return string
     */
    public function getFormattedLetterDateAttribute(): string {
        return Carbon::parse($this->Tanggal_Surat)->isoFormat('dddd, D MMMM YYYY');
    }

    /**
     * Mendapatkan atribut tanggal diterima yang telah diformat.
     *
     * @return string
     */
    public function getFormattedReceivedDateAttribute(): string {
        return Carbon::parse($this->Tanggal_Diterima)->isoFormat('dddd, D MMMM YYYY');
    }

    /**
     * Mendapatkan atribut tanggal pembuatan yang telah diformat.
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute(): string {
        return $this->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    /**
     * Mendapatkan atribut tanggal pembaruan yang telah diformat.
     *
     * @return string
     */
    public function getFormattedUpdatedAtAttribute(): string {
        return $this->updated_at->isoFormat('dddd, D MMMM YYYY, HH:mm:ss');
    }

    /**
     * Scope untuk memfilter surat berdasarkan jenis surat.
     *
     * @param $query
     * @param LetterType $type
     * @return mixed
     */
    public function scopeType($query, LetterType $type)
    {
        return $query->where('type', $type->type());
    }

    /**
     * Scope untuk memfilter surat masuk.
     *
     * @param $query
     * @return mixed
     */
    public function scopeIncoming($query)
    {
        return $this->scopeType($query, LetterType::INCOMING);
    }

    /**
     * Scope untuk memfilter surat keluar.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOutgoing($query)
    {
        return $this->scopeType($query, LetterType::OUTGOING);
    }

    /**
     * Scope untuk memfilter surat yang dibuat hari ini.
     *
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now());
    }

    /**
     * Scope untuk memfilter surat yang dibuat kemarin.
     *
     * @param $query
     * @return mixed
     */
    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', now()->addDays(-1));
    }

    /**
     * Scope untuk mencari surat berdasarkan kata kunci.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function($query, $find) {
            return $query
                ->where('reference_number', $find)
                ->orWhere('agenda_number', $find)
                ->orWhere('from', 'LIKE', $find . '%')
                ->orWhere('penerima', 'LIKE', $find . '%');
        });
    }

    /**
     * Scope untuk merender daftar surat dengan pencarian.
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeRender($query, $search)
    {
        return $query
            ->with(['lampiran', 'kategori'])
            ->search($search)
            ->latest('Tanggal_Surat')
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }

    /**
     * Scope untuk memfilter agenda surat berdasarkan tanggal dan filter tertentu.
     *
     * @param $query
     * @param $since
     * @param $until
     * @param $filter
     * @return mixed
     */
    public function scopeAgenda($query, $since, $until, $filter)
    {
        return $query
            ->when($since && $until && $filter, function ($query, $condition) use ($since, $until, $filter) {
                return $query->whereBetween(DB::raw('DATE(' . $filter . ')'), [$since, $until]);
            });
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
     * Relasi dengan klasifikasi surat.
     *
     * @return BelongsTo
     */
    public function classification(): BelongsTo
    {
        return $this->belongsTo(Lampiran::class, 'classification_code', 'code');
    }

    /**
     * Relasi dengan disposisi surat.
     *
     * @return HasMany
     */
    public function disposisis(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'surat_id', 'id');
    }

    /**
     * Relasi dengan lampiran surat.
     *
     * @return HasMany
     */
    public function lampiran(): HasMany
    {
        return $this->hasMany(Lampiran::class, 'surat_id', 'id');
    }
}
