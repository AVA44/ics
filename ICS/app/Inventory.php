<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function stocks() {
        return $this->hasMany('App\Stock');
    }
}
