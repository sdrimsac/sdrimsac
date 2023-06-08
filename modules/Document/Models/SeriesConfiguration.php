<?php

namespace Modules\Document\Models;
 

use App\Models\Tenant\Series;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\ModelTenant;

class SeriesConfiguration extends ModelTenant
{
    protected $fillable = [
        'series_id',
        'series',
        'number',
        'document_type_id',
    ];
  
    public function relationSeries()
    {
        return $this->belongsTo(Series::class,'series_id');
    }

    public function document_type() {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

}