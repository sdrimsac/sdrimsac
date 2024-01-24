@extends('tenant.layouts.app')

@section('content')
    <tenant-item-color-size-index :configuration="{{ \App\Models\Tenant\Configuration::getPublicConfig() }}"
        :type-user="{{ json_encode(Auth::user()->type) }}"></tenant-item-color-size-index>
@endsection
