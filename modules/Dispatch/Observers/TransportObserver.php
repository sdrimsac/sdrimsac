<?php

namespace Modules\Dispatch\Observers;

use App\Traits\HelperTrait;
use Modules\Dispatch\Models\Transport;

class TransportObserver
{
    use HelperTrait;
    public function saving(Transport $record)
    {
        $record->plate_number = $this->func_str_to_upper_utf8(str_replace('-', '', $record->plate_number));
        $record->model = $this->func_str_to_upper_utf8($record->model);
        $record->brand = $this->func_str_to_upper_utf8($record->brand);
    }
}
