@extends('tenant.layouts.app')


@section('content')
   <etiqueta-codes-index
   :type-user="{{json_encode(Auth::user()->type)}}"
   :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
   ></etiqueta-codes-index>
@endsection