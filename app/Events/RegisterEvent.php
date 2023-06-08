<?php

namespace App\Events;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Resources\RegisterMovementCollection;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Document;
use App\Models\Tenant\Person;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleNote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use App\Models\Tenant\Box;

class RegisterEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $register;
    protected $model;
    protected $data;
    protected $event;
    public function __construct($register)
    {



        $model = $register->model;
        $this->data = $register->data;
        $model = app($model);
        $model = get_class($model);
        $this->model = $model::find($register->model_id);
        $this->event = $register->event;

        $detail = $this->get_model_type($model);
        $this->register =  [
            // "test" => "test",
            'id'                => $register->id,
            'ip'               => $register->ip,
            'system'          => $register->browser,
            'description'       => $register->description,
            'event_description'       => $register->get_event(),
            'event'       => $register->event,
            'detail'       => $detail,
            'date_of_issue'     => $register->created_at->format('d/m/Y'),
            'time_of_issue'     => $register->created_at->format('H:i:s'),
            'user'  => $register->user->name,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('register');
    }
    public function broadcastAs()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel;
        return 'register-' . $event_name;
    }

    function get_model_type($model)
    {
        $detail = [];
        switch ($model) {
            case Orden::class:
                $detail = $this->orden_description();
                break;
            case Table::class:
                $detail = $this->table_description();
                break;
            case OrdenItem::class:
                $detail = $this->orden_item_description();
                break;
            case SaleNote::class:
                $detail = $this->sale_note_description();
                break;
            case Document::class:
                $detail = $this->document_description();
                break;
            case Box::class:
                $detail = $this->box_description();
                break;
            default:
                $detail = [];
                break;
        }
        return $detail;
    }
    function orden_description()
    {
        if ($this->model == null) {
            $data = $this->data;
            if ($data) {
                $data = json_decode($data, true);
            }
            $ref = Functions::valueKeyInArray($data, "ref");
            $table_id = $data["table_id"];
            $orden_id = Functions::valueKeyInArray($data, "id");
            $customer_id = Functions::valueKeyInArray($data, "customer_id");
            $table = Table::find($table_id);
            $table_name = null;
            $area_name = null;
            if ($table) {
                $table_name = $table->number;
                $area_name = $table->area->description;
            }
            $customer_name = null;
            if ($customer_id) {
                $customer = Person::find($customer_id);
                if ($customer) {
                    $customer_name = $customer->name;
                }
            }
            return [
                "number" => $orden_id,
                "table" => $table_name,
                "area" => $area_name,
                "customer" => $customer_name,
                "ref" => $ref,
            ];
        } else {
            return [
                "number" => $this->model->id,
                "table" => $this->model->mesa->number,
                "area" => $this->model->mesa->area->description,
                "customer" => $this->model->customer ? $this->model->customer->name : null,
                "ref"  => $this->model->ref,
            ];
        }
    }
    function sale_note_description()
    {
        return [
            "number" => $this->model->getNumberFullAttribute(),
            "total" => $this->model->total,
        ];
    }
    function orden_item_description()
    {
        if ($this->model == null) {
            $data = $this->data;
            if ($data) {
                $data = json_decode($data, true);
            }
            $food_id = $data["food_id"];
            $area_id = $data["area_id"];
            $orden_id = $data["orden_id"];
            $food = Food::find($food_id);
            $food_name = null;
            if ($food) {
                $food_name = $food->description;
            }
            $area = Area::find($area_id);
            $area_name = null;
            if ($area) {
                $area_name = $area->description;
            }
            $orden = Orden::find($orden_id);
            $table_name = null;
            if ($orden) {
                $table_name = $orden->mesa->number;
            } else {
                $orden_class = app(Orden::class);
                $register = RegisterMovement::where('model', $orden_class)->where('model_id', $orden_id)->first();
                if ($register) {
                    $table_name = $register->data["table"];
                }
            }
            return [
                "food" => $food_name,
                "area" => $area_name,
                "table" => $table_name,
                "quantity" => $data["quantity"],
                "price" => $data["price"],
                "observations"  => $data["observations"],
            ];
        } else {
            return [
                "food" => $this->model->food->description,
                "area" => $this->model->area->description,
                "table" => $this->model->orden->mesa->number,
                "quantity" => $this->model->quantity,
                "price" => $this->model->price,
                "observations"  => $this->model->observations,
            ];
        }
    }
    function document_description()
    {
        return [
            "number" => $this->model->getNumberFullAttribute(),
            "total" => $this->model->total,
        ];
    }
    function box_description()
    {
        if($this->model == null){
            return [
                "method" => null,
                "description" => "Eliminado",
                "document" => null,
                "amount" => 0,
            ];
        }
        if($this->model->document_id == null && $this->model->salenote_id == null){
            return [
                "method" => $this->model->method,
                "description" => $this->model->description,
                "document" => null,
                "amount" => $this->model->amount,
            ];
            
        }
        if ($this->model->document_id) {
            $document = $this->model->document->getNumberFullAttribute();
        } else {
            $document = $this->model->salenote->getNumberFullAttribute();
        }
        return [
            "method" => $this->model->method,
            "description" => $this->model->description,
            "document" => $document,
            "amount" => $this->model->amount,
        ];
    }
    function table_description()
    {
        return [
            "number" => $this->model->number,
            "area" => $this->model->area->description,
        ];
    }
}
