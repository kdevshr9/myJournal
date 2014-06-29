@extends('general')

@section('content')

@foreach($journals as $key => $value)
    <div class="ui stacked segment">
        <h2><a class="" href="{{ URL::to('journal/' . $value->id) }}">{{ $value->title }}</a></h2>
        @foreach($value->days as $day)
            @if ($value->type == 1)
                {{ date('M j, Y', strtotime($day->date)) }}
            @endif
        @endforeach
        
        @if(Auth::check())
            <a class="btn btn-small btn-info" href="{{ URL::to('journal/' . $value->id . '/edit') }}"><i class="edit icon"></i></a>
            {{ Form::open(array('url' => 'journal/' . $value->id, 'class' => 'pull-right')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}
        @endif
        
        @foreach($value->days as $day)
            @if (strlen($day->description)>150)
                {{ substr($day->description, 0, 400) }}.....
            @else
                {{ $day->description }}
            @endif
        @endforeach
    </div>
@endforeach
@stop