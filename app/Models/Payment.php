<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_date',
        'transaction_ref',
        'notes',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    /**
     * Available payment method options.
     */
    public const PAYMENT_METHODS = [
        'QRIS',
        'Transfer Bank',
        'Cash',
        'Virtual Account',
        'E-Wallet',
    ];

    /**
     * Payment status options.
     */
    public const PAYMENT_STATUSES = [
        'pending' => 'Menunggu',
        'paid'    => 'Lunas',
        'failed'  => 'Gagal',
    ];

    // ─── Relations ───────────────────────────────────────────

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class)->withDefault();
    }

    // ─── Accessors ────────────────────────────────────────────

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? $this->payment_status;
    }

    // ─── Scopes ───────────────────────────────────────────────

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}
