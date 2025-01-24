<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $autoIncrement = true;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'since',
        'revenue'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
