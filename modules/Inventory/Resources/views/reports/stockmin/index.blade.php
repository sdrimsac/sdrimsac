@extends('tenant.layouts.app')
@section('content')
<stockmin-report
    :stablecimientos="{{json_encode($stablecimientos)}}"
    :categoria="{{json_encode($resultArraycategoriaFoods)}}"
>
</stockmin-report>
@endsection