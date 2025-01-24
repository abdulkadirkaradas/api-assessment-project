<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDiscount extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $autoIncrement = true;

    protected $table = 'order_discounts';

    protected $fillable = [
        'discount_reason',
        'discount_amount',
        'sub_total',
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
