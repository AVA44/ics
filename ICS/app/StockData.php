<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockData extends Model
{
    protected $table = 'stocks_data';

    public function inventories()
    {
       return $this->belongsTo('App\Inventory');
    }

    protected $fillable = ['inventory_id', 'stock_id', 'expired_at', 'limited_at', 'taste_name'];
}
