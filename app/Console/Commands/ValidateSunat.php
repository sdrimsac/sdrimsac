<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\DocumentController;
use Illuminate\Console\Command;
use App\Traits\CommandTrait;
use App\Models\Tenant\{
    Company,
    Configuration,
    Document
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidateSunat extends Command
{
    use CommandTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sunat:validate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate all pending documents to be sent to the Sunat';

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
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::now()->subDay()->format('Y-m-d');

        $company = Company::first();
        $fileContent = "";
        Document::query()
            ->where('soap_type_id', '02')
            ->whereNull('state_sunat')
            ->whereIn('date_of_issue', [$today, $yesterday])
            ->limit(250)
            ->chunk(50,function ($documents) use ($company, &$fileContent) {
                foreach ($documents as $doc) {
                    $ruc = $company->number;
                    $documenType = $doc->document_type_id;
                    $serie = $doc->series;
                    $number = $doc->number;
                    $date_of_issue = Carbon::parse($doc->date_of_issue)->format('d/m/Y');
                    $total = $doc->total;
                    $fileContent .= "{$ruc}|{$documenType}|{$serie}|{$number}|{$date_of_issue}|{$total}\n";
                }
            });
        if($fileContent == ""){
            $this->info('No hay documentos pendientes de validar');
            return;
        }
        $tempFile = tempnam(sys_get_temp_dir(), 'validate_');
        file_put_contents($tempFile, $fileContent);

        // Crear un objeto UploadedFile
        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $tempFile,
            'validate.txt',
            'text/plain',
            null,
            true
        );

        // Crear una nueva request con el archivo
        $newRequest = new Request();
        $newRequest->files->set('txt_file', $uploadedFile);

        $documentController = new DocumentController();
        $result =    $documentController->txtValidate($newRequest);


        // Limpiar el archivo temporal
        unlink($tempFile);




        $this->info('The command is finished');
    }
}
