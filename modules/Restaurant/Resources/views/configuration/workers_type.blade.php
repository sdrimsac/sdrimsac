@extends('tenant.layouts.app')


<!-- @section('content')
    <tenant-restaurant-items type='caja/workers-type' :configurations="{{ json_encode($configurations)  }}"

    :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"
        title='Listado de tipo trabajadores'></tenant-restaurant-items>
@endsection -->

@section('content')
    <tenant-restaurant-items 
        type='caja/workers-type'
        :configurations='@json($configurations)'
        :type-user='@json(Auth::user()->type)' 
        :user='@json(Auth::user())'
        title="Listado de tipo trabajadores">
    </tenant-restaurant-items>
@endsection
