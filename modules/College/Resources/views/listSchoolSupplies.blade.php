@extends('tenant.layouts.app')
@section('content')
<college-schoolsupplies :branchsupplies="{{json_encode($branchSupplies)}}"
    :salones="{{json_encode($salones)}}" >



</college-schoolsupplies>
@endsection
