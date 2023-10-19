@extends('errors::minimal')
<style>
    body {
        background-image: url('/logo/bloqueo.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>

@section('title', __('Forbidden'))
{{-- @section('code', '403') --}}
@section('message', __($exception->getMessage() ?: 'CUENTA BLOQUEADA COMUNIQUESE CON SU PROVEEDOR DE SERVICIOS'))
