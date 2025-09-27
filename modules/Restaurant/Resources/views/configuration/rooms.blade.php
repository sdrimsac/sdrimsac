@extends('tenant.layouts.app')


@section('content')
    <tenant-restaurant-items type='caja/rooms' title='Habitaciones'
        :configurations="{{ json_encode($configurations) }}"
        :type-user='@json(Auth::user()->type)' 
        :user='@json(Auth::user())'
        ></tenant-restaurant-items>
@endsection
