@extends('tenant.layouts.app')

@section('content')
    <report-promotion-index
    :configuration="{{json_encode($configuration)}}"
    ></report-promotion-index>
@endsection
