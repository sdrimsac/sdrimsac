<?php

namespace App\Models\Tenant;


class ExcludedUser extends ModelTenant
{
  protected $table = "excluded_users";
  public $timestamps = false;
  protected $fillable = [
    'user_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
