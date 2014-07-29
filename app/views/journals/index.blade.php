@extends('general')

@section('content')

@foreach($journals as $key => $value)
    <div class="ui stacked segment">
        <h2>{{ $value->title }}</h2>
        @foreach($value->days as $day)
            @if ($value->type == 1)
                <div class="ui label">
                    <i class="calendar icon"></i>{{ date('M j, Y', strtotime($day->date)) }}&nbsp;
                    <i class="map marker icon"></i>Location
                </div>
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
                {{ substr($day->description, 0, 600) }}.....
                <div class="mini ui button"><a class="" href="{{ URL::to('journal/' . $value->id) }}">View More</a></div>
            @else
                {{ $day->description }}
                <div class="mini ui button"><a class="" href="{{ URL::to('journal/' . $value->id) }}">View More</a></div>
            @endif
        @endforeach
    </div>
@endforeach
@stop