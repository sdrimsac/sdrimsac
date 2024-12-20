<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Controllers\Controller;
use App\Jobs\DownloadFilesProccess;
use App\Models\Tenant\Company;
use App\Models\Tenant\FileToDelete;
use App\Models\Tenant\ZipFiles;
use App\Traits\JobReportTrait;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadFilesController extends Controller
{
    use StorageDocument,JobReportTrait;

    public function download_all_files()
    {
    }

    public function index()
    {
        $company = Company::first();
        $company_name = $company->name;
        $company_number = $company->number;
        return view('tenant.download_files.index', compact('company_name', 'company_number'));
    }

    public function downloadZipJob(Request $request){
        $website = $this->getTenantWebsite();
         DownloadFilesProccess::dispatch($website->id, $request->types, $request->month);

        return [
            'success' => true,
            'message' => 'Se están descargando los archivos, estos se visualizarán en la lista de archivos',
        ];
    }

    public function downloadZipFile(Request $request){
        $zipFile = ZipFiles::find($request->id);
        return response()->download(storage_path("app/temp/{$zipFile->file_zip}"));
    }

    public function downloadFile(Request $request){
        $type = $request->type;
        if($type === 'xml'){
            $type = 'signed';
        }
        $file_path = storage_path("app/tenancy/tenants/{$request->type}/{$request->filename}");
        return response()->download($file_path);
    }
    public function deleteZipFile(Request $request){
        $zipFile = ZipFiles::find($request->id);
        $items = $zipFile->items;
        foreach($items as $item){
            //tenancy_igv/signed/20602170269-03-B002-2.xml file_path
            $file_path = storage_path("app/tenancy/tenants/{$item->file_path}");
            if(file_exists($file_path)){
                unlink($file_path);
            }
        }
        $zip_file = storage_path("app/temp/{$zipFile->file_zip}");
        if(file_exists($zip_file)){
            unlink($zip_file);
        }
        $zipFile->items()->delete();
        $zipFile->delete();
        return response()->json([
            'success' => true,
            'message' => 'Archivo eliminado correctamente'
        ]);
    }
    public function getZipFiles(){
        $company = Company::first();
        $company_number = $company->number;
        $zipFiles = ZipFiles::where('company_number', $company_number)->get()->map(function($zipFile){
            $zipFile->items_count = $zipFile->items->count();
            return [
                'file_zip' => $zipFile->file_zip,
                'items_count' => $zipFile->items_count,
                'id' => $zipFile->id
            ];
        });
    
        return response()->json($zipFiles);
    }
    public function downloadZip(Request $request)
    {

        $company = Company::first();
        $company_number = $company->number;
        $month = $request->input('month', date('Y-m'));
        $is_job = $request->input('is_job', false);


        $searchFiles = $this->searchFiles($request);
        $filesData = $searchFiles->getData()->data;

        $zipFileName = "{$company_number}-{$month}.zip";
        $tempPath = storage_path("app/temp");

        // Crear directorio temp si no existe
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $zipPath = $tempPath . DIRECTORY_SEPARATOR . $zipFileName;

        // Array para almacenar los paths temporalmente
        $filesToSave = [];

        // Verificar si hay datos para comprimir
        if (empty($filesData)) {
            return response()->json([
                'success' => false,
                'message' => 'No hay archivos para descargar en el período seleccionado'
            ], 404);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el archivo ZIP'
            ], 500);
        }

        $filesAdded = false;
        $tenant = app(Environment::class)->tenant();
        $website_id = $tenant->id;
        $website = Website::find($website_id);
        $uuid = $website->uuid;
        foreach ($filesData as $type => $fileNames) {
            $typeFolder = $this->getTypeFolder($type);
            foreach ($fileNames as $fileName) {
                $filePath = storage_path("app/tenancy/tenants/{$uuid}/{$typeFolder}/{$fileName}");
        


                if (file_exists($filePath)) {
                    $zip->addFile($filePath, "{$type}/{$fileName}");
                    // Guardamos el path en el array temporal
                    $filesToSave[] = [
                        'path' => "{$uuid}/{$typeFolder}/{$fileName}",
                        'type' => $type
                    ];
                    $filesAdded = true;
                }
            }
        }

        $zip->close();
        if (!$filesAdded || !file_exists($zipPath)) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el archivo ZIP o no se encontraron archivos para comprimir'
            ], 404);
        }

        // Creamos el registro de ZipFiles y sus items solo si se creó el ZIP correctamente
        $zipFile = new ZipFiles();
        $zipFile->company_number = $company_number;
        $zipFile->file_zip = $zipFileName;
        $zipFile->save();

        // Guardamos todos los items
        foreach ($filesToSave as $fileData) {
            $fileToDelete = new FileToDelete();
            $fileToDelete->file_path = $fileData['path'];
            $fileToDelete->zip_id = $zipFile->id;
            $fileToDelete->save();
        }

        if ($is_job) {
            return $zipPath;
        }
        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    private function getTypeFolder($type)
    {
        $typeFolders = [
            'pdf' => 'pdf',
            'xml' => 'signed',
            'cdr' => 'cdr',
            'sale_note' => 'sale_note'
        ];
        return $typeFolders[$type] ?? $type;
    }

    public function searchFiles(Request $request)
    {
        $month = $request->month;
        $types = $request->types;

        try {
            $tenant = app(Environment::class)->tenant();
            $website_id = $tenant->id;
            $website = Website::find($website_id);
            $uuid = $website->uuid;
            $basePath = "tenancy/tenants/{$uuid}";

            $results = [];

            // Mapeo de tipos a carpetas
            $typeFolders = [
                'pdf' => 'pdf',
                'xml' => 'signed',
                'cdr' => 'cdr',
                'sale_note' => 'sale_note'
            ];

            foreach ($types as $type) {
                if (!isset($typeFolders[$type])) continue;

                $folderPath = "{$basePath}/{$typeFolders[$type]}";

                $files = Storage::disk('tenant')->files($typeFolders[$type]);
                // Filtrar archivos por mes
                $monthFiles = array_filter($files, function ($file) use ($month) {

                    $fileDate = Carbon::createFromTimestamp(Storage::disk('tenant')->lastModified($file));
                    return $fileDate->format('Y-m') === $month;
                });

                // Obtener solo los nombres de los archivos
                $fileNames = array_map(function ($file) {
                    return basename($file);
                }, $monthFiles);

                $results[$type] = array_values($fileNames);
            }

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
