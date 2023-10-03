@extends('tenant.layouts.app')


@section('content')
   <etiqueta-index
   :type-user="{{json_encode(Auth::user()->type)}}"
   :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
   ></etiqueta-index>
@endsection