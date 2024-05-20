@extends('tenant.layouts.app')

@section('content')
    <cash-index-closed
    :configuration="{{json_encode($configuration)}}"
    :users="{{json_encode($users)}}"
    :has-cash="{{json_encode($has_cash)}}"
    :cash-id="{{json_encode($cash_id)}}"
    ></cash-index-closed>
           
@endsection

 