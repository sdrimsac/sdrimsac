@extends('tenant.layouts.app')


@section('content')
   <etiqueta-index
   :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
   ></etiqueta-index>
@endsection