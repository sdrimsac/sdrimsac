@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-items type='caja/status-orden' :configurations="{{ json_encode($configurations) }}"
        title='Listado de Estados de Pedidos'></tenant-restaurant-items>
@endsection
