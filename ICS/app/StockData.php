<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockData extends Model
{
    protected $table = 'stocks_data';

    protected $fillable = ['inventory_id', 'stock_data_id', 'expired_at', 'limited_at', 'taste_name'];
}
