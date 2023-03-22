<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    public function inventories()
    {
       return $this->belongsTo('App\Inventory');
    }

    protected $fillable = ['inventory_id', 'stock'];
}
