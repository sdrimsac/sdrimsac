@extends('tenant.layouts.app')

@section('content')
    <cash-index-closed
    :configuration="{{json_encode($configuration)}}"
    :users="{{json_encode($users)}}"
    :has-cash="{{json_encode($has_cash)}}"
    :can-open="{{json_encode($can_open)}}"
    :cash-id="{{json_encode($cash_id)}}"
    :is-logistico="{{json_encode($isLogistico)}}"
    ></cash-index-closed>
           
@endsection

 