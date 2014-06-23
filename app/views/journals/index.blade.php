@extends('general')

@section('content')

@foreach($journals as $key => $value)
    <div class="ui stacked segment">
        <h2><a class="" href="{{ URL::to('journal/' . $value->id) }}">{{ $value->title }}</a></h2>
        @if ($value->type == 1)
            {{ date('M j, Y', strtotime($value->date)) }}
        @else
            {{ date('M j, Y', strtotime($value->date_from)).'-'.date('M j, Y', strtotime($value->date_to)) }}
        @endif
        
        @if(Auth::check())
            <a class="btn btn-small btn-info" href="{{ URL::to('journal/' . $value->id . '/edit') }}"><i class="edit icon"></i></a>
            {{ Form::open(array('url' => 'journal/' . $value->id, 'class' => 'pull-right')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
            {{ Form::close() }}
        @endif
        
        @if (strlen($value->description)>150)
            {{ substr($value->description, 0, 400) }}.....
        @else
            {{ $value->description }}
        @endif
    </div>
@endforeach
@stop