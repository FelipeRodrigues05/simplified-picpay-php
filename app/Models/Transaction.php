<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'float:2',
    ];

    public function receiver(): HasMany
    {
        return $this->hasMany(User::class, 'receiver_id');
    }
    public function sender(): HasMany
    {
        return $this->hasMany(User::class, 'sender_id');
    }
}
