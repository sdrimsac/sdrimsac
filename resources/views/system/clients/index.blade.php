@extends('system.layouts.app')

@section('content')
@inject('roleService', 'App\Services\RoleService')

    <system-clients-index 
    :can-see="{{json_encode($canSee)}}"
    ></system-clients-index>
@endsection