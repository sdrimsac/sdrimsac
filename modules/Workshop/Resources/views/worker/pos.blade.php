@extends('tenant.layouts.pos')
@section('content')
    <tenant-workshop-pos :area_id="{{ $area_id }}" :cash_id="{{ $cash_id }}" :worker="{{ auth()->user() }}"
        :pending_order="{{ $pending_order }}" :company="{{ $company }}"
        :desarrollador="{{ json_encode($desarrollador) }}" :configuration="{{ $configuration }}"
        :auth_login="{{ $auth_login }}" :establishments="{{ $establishments }}">
    </tenant-workshop-pos>
@endsection