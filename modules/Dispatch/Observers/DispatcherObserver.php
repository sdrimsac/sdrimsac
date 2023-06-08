<?php

namespace Modules\Dispatch\Observers;

use App\Traits\HelperTrait;
use Modules\Dispatch\Models\Dispatcher;

class DispatcherObserver
{
    use HelperTrait;
    public function saving(Dispatcher $record)
    {
        $record->number_mtc = $this->func_str_to_upper_utf8($record->number_mtc);
    }
}
