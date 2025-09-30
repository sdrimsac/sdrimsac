<?php

namespace App\Console\Commands;

use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\Item;
use App\Models\Tenant\Payment;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Grifo\Models\ItemTotemPrices;
use Modules\Item\Models\CategoryItem;

class ItemTotemRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item-totem:register-prices';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula penalidades de las notas de venta con crédito pendiente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Verificar si existe la categoría 'COMBUSTIBLE'
        $combustibleCategory = CategoryItem::where('name', 'COMBUSTIBLE')->first();

        if (!$combustibleCategory) {
            $this->error('La categoría COMBUSTIBLE no existe.');
            return 1;
        }

        // Obtener los items que pertenecen a la categoría COMBUSTIBLE
        $items = Item::where('category_id', $combustibleCategory->id)->get();

        foreach ($items as $item) {
            $item->storePriceFromConsole();
        }

        $this->info('Precios registrados');
        return 0;
    }
}
