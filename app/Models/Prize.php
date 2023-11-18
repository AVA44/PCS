<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    public function stocks() {
        return $this->hasMany(Stock::class);
    }

    protected $fillable = [
        'name', 'category', 'price_per_box', 'snp_per_box', 'img'
    ];
}
