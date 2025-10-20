@extends('tenant.layouts.app')


@section('content')
    <tenant-restobar-items type='caja/status-tables' title='Listado de Estados de Mesas'
        :configurations="{{ json_encode($configurations) }}"></tenant-restobar-items>
@endsection
