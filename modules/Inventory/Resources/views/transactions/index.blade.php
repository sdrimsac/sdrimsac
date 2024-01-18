@extends('tenant.layouts.app')

@section('content')

    <inventory-transactions-index
    :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    ></inventory-transactions-index>

@endsection