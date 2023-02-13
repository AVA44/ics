<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['inventory_id', 'income_count', 'expired_at', 'limited_at', 'stock', 'taste_name'];
}
