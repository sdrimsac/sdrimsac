@extends('tenant.layouts.app')

@section('content')

    <inventory-transfers-index
    :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    ></inventory-transfers-index>

@endsection