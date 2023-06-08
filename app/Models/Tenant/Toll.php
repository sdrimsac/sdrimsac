<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Database\Eloquent\Model;

class Toll extends ModelTenant
{
  protected $table = "toll";
  protected $fillable = [
    'item_id'
  ];
  protected $with = ["item"];

  public function item()
  {

    return $this->belongsTo(Item::class);
  }
}
