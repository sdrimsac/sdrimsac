@extends('tenant.layouts.pos')
@section('content')

    <tenant-restaurant-pos
    :lareaId="{{ $lareaId }}"
    :area_id="{{ $area_id }}" :cash_id="{{ $cash_id }}" :worker="{{ auth()->user() }}"
        :pending_order="{{ $pending_order }}" :company="{{ $company }}"
        :desarrollador="{{ json_encode($desarrollador) }}"
        :configuration="{{ \App\Models\Tenant\Configuration::getPublicConfig() }}" :auth_login="{{ $auth_login }}"
        :establishments="{{ $establishments }}"></tenant-restaurant-pos>
@endsection
