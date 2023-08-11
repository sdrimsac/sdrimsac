<?php

namespace Modules\Consignment\Models;

use App\Models\Tenant\Document;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\SaleNote;

class ConsignmentDocument extends ModelTenant
{
    protected $table = 'consignment_documents';
    protected $fillable = [
        'consignment_id',
        'document_id',
        'sale_note_id',
    ];
    

    public function consignment(){
            return $this->belongsTo(Consignment::class);
    }
    public function document(){
            return $this->belongsTo(Document::class);
    }
    public function sale_note(){       
            return $this->belongsTo(SaleNote::class);
    }

}