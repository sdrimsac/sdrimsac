@extends('system.layouts.app')

@section('content')
@inject('roleService', 'App\Services\RoleService')

    <system-clients-index 
    can-see="{{ $canSee }}"
    ></system-clients-index>
@endsection