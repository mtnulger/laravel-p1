<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Article extends Model
{

  use softDeletes;
  function getCategory()
  {
    return $this->hasOne('App\Models\categories','id','category_id');

  }
}
