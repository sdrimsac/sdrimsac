<?php

namespace App\Models\Tenant;


class FileToDelete extends ModelTenant
{

    public $timestamps = false;
    protected $table="files_to_delete";         //nombre tabla
    protected $fillable = [
        'file_path',
        'zip_id'
        
    ];


    public function zip()
    {
        return $this->belongsTo(ZipFiles::class, 'zip_id');
    }
}
