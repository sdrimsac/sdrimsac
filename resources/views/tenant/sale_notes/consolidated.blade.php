@extends('tenant.layouts.app')

@section('content')
    <tenant-sale-notes-consolidated :configuration="{{ App\Models\Tenant\Configuration::getPublicConfig() }}"
        :type-user="{{ json_encode(Auth::user()->type) }}"></tenant-sale-notes-consolidated>
@endsection
