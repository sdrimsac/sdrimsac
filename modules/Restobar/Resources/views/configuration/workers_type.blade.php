@extends('tenant.layouts.app')


@section('content')
    <tenant-restobar-items type='caja/workers-type' :configurations="{{ json_encode($configurations)  }}"

    :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"
        title='Listado de tipo trabajadores'></tenant-restobar-items>
@endsection


