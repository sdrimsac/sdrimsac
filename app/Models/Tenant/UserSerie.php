<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Database\Eloquent\Model;

class UserSerie extends ModelTenant
{
  protected $table = "user_series";
  protected $fillable = [
    'user_id',
    'serie_id' //6
  ];

  public function user()
  {

    return $this->belongsTo(User::class);
  }
  public function seriexxx()
  {

    return $this->belongsTo(Series::class,'serie_id','id');
  }
}

// id  6
