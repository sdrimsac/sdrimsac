@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-items type='caja/rooms' title='Habitaciones'
        :configurations="{{ json_encode($configurations) }}"></tenant-restaurant-items>
@endsection
