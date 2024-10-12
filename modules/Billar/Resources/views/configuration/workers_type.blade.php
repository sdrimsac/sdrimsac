@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-items type='caja/workers-type' :configurations="{{ json_encode($configurations) }}"
        title='Listado de tipo trabajadores'></tenant-restaurant-items>
@endsection
