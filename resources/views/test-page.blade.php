@extends('layouts.app')

@section('title', 'Server Health Checks')

@section('content')
<h1 class="text-3xl font-bold mb-6">Server Health Checks</h1>

<div class="overflow-x-auto">

 <p>{{ $url }}</p>
 <p>{{ $response_time }}</p>
 <p>{{ $message }}</p>


</div>
@endsection
