<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\SaleNoteController;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Jobs\WhatsappSendMessageProccess;
use App\Models\Tenant\SaleNote;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Report\Exports\ReportDocumentStatus;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Traits\JobReportTrait;
use Hyn\Tenancy\Models\Hostname;

class SaleNoteCreditMessage extends Command
{
    use JobReportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:salenotecredit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for validate in each database project if all documents are in status Accepted';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('The command was started');
        

        try {
            $configuration = DB::connection('tenant')->table('configurations')->first();

            if(!$configuration->sale_note_credit_send_whatsapp){
                $this->info('The command was finished because the configuration is disabled');
                return 0;
            }
            $messages = (new SaleNoteController)->generateMessages();    

            $website = $this->getTenantWebsite();
            $hostname = Hostname::where('website_id', $website->id)->first();
            foreach ($messages as $row) {
                $message = $row['message'];
                $number_activity = $row['telephone'];
                $fqdn = $hostname->fqdn;
                $subdomain = explode(".", $fqdn)[0];
                if($number_activity){
                    WhatsappSendMessageProccess::dispatch($website->id, $message, $number_activity,$subdomain);
                }
            }

            $this->info('The command is finished');
        } catch (\Throwable $th) {
            $this->error('The command was failed' . $th);
        }
        return 0;
    }
}
