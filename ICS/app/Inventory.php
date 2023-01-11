<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function stocks() {
        return $this->hasMany('App\Stock');
    }

    protected $fillable = ['name', 'category_name', 'parchase', 'box_price', 'unit_price', 'lank', 'image_url'];

}
