<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Tenant\Item;

class RegisterMovementItemCollection extends ResourceCollection
{
    protected $model = null;
    protected $event = null;
    protected $register = null;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {

            $this->register = $row;
            $model = app($row->model);
            $model = get_class($model);
            $this->model = $model::find($row->model_id);
            if (!$this->model){
                return ['error' => 'mdelo no encontrado'];
            }
            $this->event = $row->event;
            $detail = $this->get_model_type($model);
            return [
                'id'                => $row->id,
                'ip'               => $row->ip,
                'system'          => $row->browser,
                'description'       => $row->description,
                'event_description'       => $row->get_event(),
                'event'       => $row->event,
                'detail'       => $detail,
                'date_of_issue'     => $row->created_at->format('d/m/Y'),
                'time_of_issue'     => $row->created_at->format('H:i:s'),
                'user'            => $row->user->name,
            ];
        });
    }


    function get_model_type($model)
    {
        $detail = [];
        switch ($model) {
            case Item::class:
                $detail = $this->item_description();
                break;
            default:
                $detail = [];
                break;
        }
        return $detail;
    }
    function item_description()
    {
        if($this->model == null){
            return [

            ];  
        return [
            "id" => $this->model->id,
            "description" => $this->model->item->description,
        ];                                                                                                                                                                                                       }     
    }  
}
