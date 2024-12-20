<?php

namespace App\Models\Tenant;


class ZipFiles extends ModelTenant
{

    public $timestamps = false;
    protected $table="zip_files";         //nombre tabla
    protected $fillable = [
        'company_number',
        'file_zip',
        'is_downloaded'
        
    ];

    protected $casts = [
        'is_downloaded' => 'boolean'
    ];
    
    public function items(){
        return $this->hasMany(FileToDelete::class, 'zip_id', 'id');
    }
}
