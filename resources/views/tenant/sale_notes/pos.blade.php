
 @extends('tenant.layouts.pos')

@section('content')
    <tenant-sale-notes-index
        :soap-company="{{ json_encode($soap_company) }}"
        :user_type="{{ json_encode($user_type)}}"

        :configuration="{{json_encode($configuration)}}">
    </tenant-sale-notes-index>
@endsection
