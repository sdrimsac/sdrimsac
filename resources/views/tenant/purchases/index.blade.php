@extends('tenant.layouts.app')

@section('content')

    <tenant-purchases-index
    :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    ></tenant-purchases-index>

@endsection