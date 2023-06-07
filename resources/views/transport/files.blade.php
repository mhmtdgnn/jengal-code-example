@extends('common.layout')

@section('content')

@foreach ($files as $item)
<div class="container-xxl">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="https://portalcdn.bicozum.com/biportal/{{ $item->file_url }}" alt="" width="300">
                </div>
                <div class="col-md-6">
                    {{ $item->transport_request_id }} <br>
                    {{ $item->created_at }} <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection