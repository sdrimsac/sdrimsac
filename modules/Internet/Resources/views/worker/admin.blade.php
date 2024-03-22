@extends('tenant.layouts.app')

@section('content')
<tenant-internet-workersadm
:type-user="{{ json_encode(auth()->user()->type) }}"
>
    
</tenant-internet-workersadm>
@endsection
