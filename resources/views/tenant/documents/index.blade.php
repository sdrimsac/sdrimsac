@extends('tenant.layouts.app')

@section('content')

    <tenant-documents-index 
    
    :is-accountant = "{{json_encode($is_accountant)}}"
    :is-client="{{ json_encode($is_client) }}"
                            :type-user="{{ json_encode(auth()->user()->type) }}"
                            :import_documents="{{ json_encode($import_documents) }}"
                            :configuration="{{json_encode($configuration)}}"
                            :company="{{json_encode($company)}}"
                            :import_documents_second="{{ json_encode($import_documents_second) }}"></tenant-documents-index>

@endsection
 