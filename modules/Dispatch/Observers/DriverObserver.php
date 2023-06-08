<?php

namespace Modules\Dispatch\Observers;

use App\Traits\HelperTrait;
use Modules\Dispatch\Models\Driver;

class DriverObserver
{
    use HelperTrait;
    public function saving(Driver $driver)
    {
        $driver->license = $this->func_str_to_upper_utf8($driver->license);
    }
}
