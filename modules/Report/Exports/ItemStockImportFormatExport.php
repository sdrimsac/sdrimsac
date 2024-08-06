<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ItemStockImportFormatExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $items;
  
    public function items($items) {
        $this->items = $items;
        
        return $this;
    }
  
    
    public function view(): View {
        return view('report::items.items_format_import', [
            'records'=> $this->items,
        ]);
    }
}
