<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'total_amount',
        'discount',
        'grand_total',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount'     => 'decimal:2',
        'grand_total'  => 'decimal:2',
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

    // ─── Boot ────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Transaction $transaction) {
            if (empty($transaction->invoice_number)) {
                $transaction->invoice_number = static::generateInvoiceNumber();
            }
        });
    }

    /**
     * Generate unique invoice number: INV-YYYYMMDD-XXXX
     */
    public static function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $lastToday = static::where('invoice_number', 'like', "INV-{$date}-%")
            ->orderByDesc('invoice_number')
            ->first();

        if ($lastToday) {
            $lastNumber = (int) substr($lastToday->invoice_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "INV-{$date}-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    // ─── Relations ───────────────────────────────────────────

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => 'Pelanggan Terhapus',
        ]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    // ─── Accessors ────────────────────────────────────────────

    public function getFormattedGrandTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount, 0, ',', '.');
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

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }
}
