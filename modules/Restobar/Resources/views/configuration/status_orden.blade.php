@extends('tenant.layouts.app')


@section('content')
    <tenant-restobar-items type='caja/status-orden' :configurations="{{ json_encode($configurations) }}"
        title='Listado de Estados de Pedidos'></tenant-restobar-items>
@endsection
