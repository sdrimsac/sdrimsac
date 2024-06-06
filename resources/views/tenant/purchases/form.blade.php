@extends('tenant.layouts.app')

@section('content')
 
    <tenant-purchases-form 
    :is_arca = "{{ json_encode($is_arca) }}"
    :purchase_order_id="{{ json_encode($purchase_order_id) }}"></tenant-purchases-form>

@endsection