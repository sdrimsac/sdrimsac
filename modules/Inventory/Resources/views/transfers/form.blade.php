@extends('tenant.layouts.app')

@section('content')

    <inventory-form-masive
    :configuration="{{\App\Models\Tenant\Configuration::getPublicConfig()}}"
    :establishments="{{json_encode($establishments)}}"
    :establishment_id="{{json_encode($establishment_id)}}"
    ></inventory-form-masive>

@endsection
