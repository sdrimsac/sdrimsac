@extends('tenant.layouts.app')

@section('content')
<tenant-workshop-workersadm
:type-user="{{ json_encode(auth()->user()->type) }}"
>
    
</tenant-workshop-workersadm>
@endsection