@extends('tenant.layouts.app')

@section('content')
    <cash-index-main
    :cashid="{{json_encode($cash_id)}}"
    :configuration="{{json_encode($configuration)}}"
    :total="{{json_encode($total)}}"
    :payment_methods="{{json_encode($payment_methods)}}"
    :banks="{{json_encode($banks)}}"
    ></cash-index-main>
           
@endsection

 