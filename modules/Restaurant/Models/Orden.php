<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\CreditList;
use App\Models\Tenant\Person;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Traits\RegisterMovementTrait;
  use App\Models\Tenant\ModelTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurant\Models\Table;

class Orden extends ModelTenant
{
    use RegisterMovementTrait;

    public $timestamps = true;
    protected $with = ['orden_items', 'status_orden', 'salenote', 'document', 'customer', 'mesa'];
    // , 'document', 'sale_note','mesa'
    protected $fillable = [
        'hotel_rent_item_id',
        'table_id',
        'status_orden_id',
        'customer_id',
        'status',
        'commands_fisico',
        'to_carry',
        'sale_note_id',
        'document_id',
        'ref'
    ];

    protected $casts = [
        'to_carry' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($orden) {
            $request = Request::capture();
            $description = "Orden creado: Solicitado";
            RegisterMovementTrait::registerCreate(
               $orden,
                $request,
                $description,
                $orden->toArray()
            );
        });
        static::updated(function ($orden) {
            $request = Request::capture();
            $description = null;
            $original_orden = Orden::find($orden->id);
            $newStatus = $original_orden->status_orden->description;
            $description = "Orden actualizado: $newStatus";
            RegisterMovementTrait::registerUpdate(
               $orden,
                $request,
                $description,
                $orden->toArray()
            );
        });

        static::deleted(
            function ($orden) {
                $request = Request::capture();
                $description = "Orden eliminado";
                $data = [];
                $data['table_id'] = $orden->table_id;
                $data['customer_id'] = $orden->customer_id;
                $data['document_id'] = $orden->document_id;
                $data['sale_note_id'] = $orden->sale_note_id;
                $data['to_carry'] = $orden->to_carry;
                RegisterMovementTrait::registerDelete(
                   $orden,
                    $request,
                    $description,
                    $data
                );
            }

        );
    }

    public function getDocument(){
        if($this->document_id){
        $external_id =$this->document->external_id;
        return url('/print/document/'.$external_id.'/ticket');
        }
        if($this->sale_note_id){
        $external_id =$this->salenote->external_id;
        return url('/sale-notes/print/'.$external_id.'/ticket');
        }
        return null;
    }
    public function credit_list(){
        return $this->hasMany(CreditList::class);
    }
    public function hasDocument(){
        if($this->document_id || $this->sale_note_id){
            return true;
        }
        return false;
    }
    public function info_to_message($items = [],$reason){
        $message = "";
        $message .= "📝 *ORDEN N° ".$this->id." ELIMINADA* \n";
        $message .= "Motivo: *".$reason."*\n";
        $message .= "👤 Usuario: *".auth()->user()->name."*\n";
        if(count($items) > 0){
            $message .= "*ITEMS ELIMINADOS:* \n";
            foreach ($items as $item) {
                $message .= "📌*".$item."* \n";
            }
        }
        return $message;
    }
    public function orden_items()
    {
        return $this->hasMany(OrdenItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Person::class);
    }
    public function status_orden()
    {
        return $this->belongsTo(StatusOrden::class, 'status_orden_id', 'id');
    }
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function salenote()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id', 'id');
    }
    public function mesa()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }
}
