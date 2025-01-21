@extends('tenant.layouts.app')

@section('content')
<tenant-dental-workersadm
:type-user="{{ json_encode(auth()->user()->type) }}"
>
    
</tenant-dental-workersadm>
@endsection