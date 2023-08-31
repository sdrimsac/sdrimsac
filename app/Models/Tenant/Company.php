<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\IdentityDocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Company extends ModelTenant
{
    protected $with = ['identity_document_type'];
    protected $fillable = [
        'a5_image',
        'user_id',
        'identity_document_type_id',
        'number',
        'name',
        'trade_name',
        'soap_send_id',
        'soap_type_id',
        'soap_username',
        'select_companies',
        'soap_password',
        'soap_url',
        'certificate',
        'logo',
        'document_logo',
        'detraction_account',
        'favicon',
        'operation_amazonia',
        'eslogan',
        'img_bg',
        'representative',
        'representative_number',
        'representative_address',
        'pusher_app_key',
        'pusher_app_secret',
        'pusher_app_id',
        'pusher_app_cluster',
        'soap_sunat_username',
        'soap_sunat_password',
        'api_sunat_id',
        'api_sunat_secret'

    ];

    public function identity_document_type()
    {
        return $this->belongsTo(IdentityDocumentType::class, 'identity_document_type_id');
    }

    public static function active()
    {
        return Company::first();
    }
    public static function setConfigBrocast()
    {
        $company = Company::first();
        $config = self::first();
        if (empty($config)) $config = new self();

        Config::set('mail.host', $config->smtp_host);
        Config::set('mail.port', $config->smtp_port);
        Config::set('mail.username', $config->smtp_user);
        Config::set('mail.password', $config->smtp_password);
        Config::set('mail.encryption', $config->smtp_encryption);
        return $config;
    }
}
