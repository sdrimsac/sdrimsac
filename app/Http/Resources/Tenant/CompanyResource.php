<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Tenant\Configuration;


class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $configuration = Configuration::first();
        return [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'trade_name' => $this->trade_name,
            'soap_send_id' => $this->soap_send_id,
            'soap_type_id' => $this->soap_type_id,
            'soap_username' => $this->soap_username,
            'soap_password' => $this->soap_password,
            'soap_url' => $this->soap_url,
            'certificate' => $this->certificate,
            'logo' => $this->logo,
            'document_logo' => $this->document_logo,
            'favicon' => $this->favicon,
            'key' => $this->key,
            'detraction_account' => $this->detraction_account,
            'logo_store' => $this->logo_store,
            'img_bg' => $this->img_bg,
            'operation_amazonia' => (bool) $this->operation_amazonia,
            'config_system_env' => (bool)$configuration->config_system_env,
            'representative' => $this->representative,
            'representative_number' => $this->representative_number,
            'representative_address' => $this->representative_address,
            'eslogan' => $this->eslogan,

            'pusher_app_key' => $this->pusher_app_key,
            'pusher_app_secret' => $this->pusher_app_secret,
            'pusher_app_id' => $this->pusher_app_id,
            'pusher_app_cluster' => $this->pusher_app_cluster,


            'soap_sunat_username' => $this->soap_sunat_username,
            'soap_sunat_password' => $this->soap_sunat_password,
            'api_sunat_id' => $this->api_sunat_id,
            'api_sunat_secret' => $this->api_sunat_secret,
        ];
    }
}
