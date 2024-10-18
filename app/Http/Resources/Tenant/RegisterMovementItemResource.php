<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Document;
use App\Models\Tenant\Person;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleNote;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Tenant\Item;

class RegisterMovementItemResource extends JsonResource
{
    protected $model = null;
    protected $event = null;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {

        $model = app($this->model);
        $model = get_class($model);
        $this->model = $model::find($this->model_id);

        $detail = $this->get_model_type($model);
        return [
            'id'                => $this->id,
            'description'       => $this->description,
            'event_description'       => $this->get_event(),
            'event'       => $this->event,
            'detail'       => $detail,
            'date_of_issue'     => $this->created_at->format('d/m/Y'),
            'time_of_issue'     => $this->created_at->format('H:i:s'),
            'user'            => $this->user->name,
        ];
    }


    function get_model_type($model)
    {
        $detail = [];
        switch ($model) {
            case Item::class:
                $detail = self::item_description();
                break;
        }
        return $detail;
    }
    function sale_note_description()
    {
        return [
            "number" => $this->model->getNumberFullAttribute(),
            "total" => $this->model->total,
        ];
    }
    function item_description()
    {
        foreach ($this->model->items as $item) {
            $detail[] = [
                "id" => $item->id,
                "description" => $item->description,
            ];
        }
    }
}
