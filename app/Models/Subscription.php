<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'category_id',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Boot: automatically set status based on end_date.
     */
    protected static function booted(): void
    {
        static::saving(function (Subscription $subscription) {
            if ($subscription->end_date && $subscription->end_date->isPast()) {
                $subscription->status = 'expired';
            }
        });
    }

    // ─── Relations ───────────────────────────────────────────

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // ─── Computed / Accessors ─────────────────────────────────

    /**
     * Check if subscription is currently active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->end_date->isFuture() || $this->end_date->isToday();
    }

    /**
     * Days remaining until expiry.
     */
    public function getDaysRemainingAttribute(): int
    {
        return max(0, now()->diffInDays($this->end_date, false));
    }

    /**
     * Human-readable status badge for UI.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active'    => '<span class="badge-active">Aktif</span>',
            'expired'   => '<span class="badge-expired">Kadaluarsa</span>',
            'cancelled' => '<span class="badge-cancelled">Dibatalkan</span>',
            default     => '<span class="badge-unknown">-</span>',
        };
    }

    // ─── Scopes ───────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('end_date', '>=', now());
    }
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }
    public function scopeExpiringSoon($query, int $days = 7)
    {
        return $query->where('status', 'active')
                     ->whereBetween('end_date', [now(), now()->addDays($days)]);
    }
}
