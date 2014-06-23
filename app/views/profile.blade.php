@extends('general')

@section('content')
@if (Session::has('flash_notice'))
    <div class="ui floating message">{{ Session::get('flash_notice') }}</div>
@endif
<h2>Welcome "{{ Auth::user()->username }}" to the protected page!</h2>
  <p>Your user ID is: {{ Auth::user()->id }}</p>
@stop