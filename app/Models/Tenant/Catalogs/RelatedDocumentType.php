<?php

namespace App\Models\Tenant\Catalogs;

use Illuminate\Database\Eloquent\Model;

class RelatedDocumentType extends ModelTenant
{


    protected $table = "cat_related_documents_types";
    public $incrementing = false;
}
