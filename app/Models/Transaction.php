<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'senderId',
        'receiverId',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function receiver(): HasMany
    {
        return $this->hasMany(User::class, 'receiverId');
    }
    public function sender(): HasMany
    {
        return $this->hasMany(User::class, 'senderId');
    }
}
