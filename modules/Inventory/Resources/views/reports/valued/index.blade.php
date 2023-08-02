@extends('tenant.layouts.app')
@section('content')
<valued-report
    :stablecimientos="{{json_encode($stablecimientos)}}"
    :categoria="{{json_encode($resultArraycategoriaFoods)}}"
>
</valued-report>
@endsection