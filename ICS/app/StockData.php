<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockData extends Model
{
    protected $fillable = ['inventory_id', 'income_count', 'expired_at', 'limited_at', 'taste_name'];
}
