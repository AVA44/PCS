<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function prize() {
        return $this->belongsTo(Prize::class);
    }

    protected $fillable = [
        'prize_id', 'taste', 'expired_at', 'memo',
    ];
}
