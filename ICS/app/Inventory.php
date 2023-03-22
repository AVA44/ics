<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function stocks() {
        return $this->hasMany('App\Stock');
    }

    public function stocks_data() {
        return $this->hasMany('App\StockData');
    }//stockにもリレーションを繋げて色々すればまとめて削除ができそう

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($inventory) {
            $inventory->stocks()->delete();
            $inventory->stocks_data()->delete();
        });
    }

    protected $fillable = ['name', 'category_name', 'parchase', 'box_price', 'unit_price', 'lank', 'image_url'];

}
