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
        'penerima',
        'batas_waktu',
        'content',
        'catatan',
        'surat_id',
        'user_id',
    ];

    protected $appends = [
        'formatted_batas_waktu',
    ];

    public function getFormattedbataswaktuAttribute(): string {
        return Carbon::parse($this->batas_waktu)->isoFormat('dddd, D MMMM YYYY');
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
                ->orWhere('content', 'LIKE', '%' . $find . '%')
                ->orWhere('penerima', 'LIKE', $find . '%');
        });
    }

    public function scopeRender($query, Surat $surat, $search)
    {
        return $query
            ->with(['user', 'status', 'surat'])
            ->search($search)
            ->when($surat, function ($query, $surat) {
                return $query
                    ->where('surat_id', $surat->id);
            })
            ->latest('created_at')
            ->paginate(10)
            ->appends([
                'search' => $search,
            ]);
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
    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'surat_id', 'id');
    }
}