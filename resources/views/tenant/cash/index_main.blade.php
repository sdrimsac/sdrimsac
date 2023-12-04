@extends('tenant.layouts.app')

@section('content')
    <cash-index-main
    :cashid="{{json_encode($cash_id)}}"
    :configuration="{{json_encode($configuration)}}"
    ></cash-index-main>
           
@endsection

 