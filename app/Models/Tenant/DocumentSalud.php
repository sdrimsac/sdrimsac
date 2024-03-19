<?php

namespace App\Models\Tenant;


class DocumentSalud extends ModelTenant
{

    protected $table = 'documents_salud';
    public $timestamps = false;
    protected $fillable = [
        "date_of_issue",
        "date_of_charge",
        "file_name",
        "identifier",
        "status",
        "error"
    ];


}
