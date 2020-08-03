<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function articleCount()
    {
      return $this->hasMany('App\Models\Article','category_id','id')->count();
                        // model,sutün,id
    }
}
