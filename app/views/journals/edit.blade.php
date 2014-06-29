@extends('general')

@section('content')
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::model($journal, array('route' => array('journal.update', $journal->id), 'method' => 'PUT')) }}
@foreach($journal->days()->get() as $day)
    <?php $date = $day->date; 
    $description = $day->description; ?>
@endforeach
<div class="ui form segment">
    {{ Form::hidden('latitude', null, array('id' => 'latitude')) }}
    {{ Form::hidden('longitude', null, array('id' => 'longitude')) }}
    {{ Form::hidden('type', '1', array('id' => 'type')) }}
    <div class="grouped inline fields two column ui grid">
        <div class="column">
            <div class="inline fields" id="single_day_journal_date">
                <div class="date field">
                    {{ Form::text('date', $date, array('class' => 'datepicker', 'placeholder' => 'Journal Date')) }}
                </div>
                <div class="ui labeled icon button" id="set_current_location">
                    <i class="map icon"></i>Set Current Location
                </div>
            </div>
        </div>
        <div class="column" id="gmap" style="height: 155px;"><img src="{{asset('images/your_location.jpg')}}"/></div>
    </div>

    <div class="inline field" >
        <div class="field">
            {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Journal Title')) }}
        </div>
    </div>
    <div class="field">
        <textarea class="editor" name="description">{{ $description }}</textarea>
        <!--<div class="editor"></div>-->
    </div>
    <input type="submit" class="ui blue submit button" value="Save">
</div>
{{ Form::close() }}

{{ HTML::script('js/datepicker/picker.js'); }}
{{ HTML::script('js/datepicker/picker.date.js'); }}
{{ HTML::script('js/froala_editor/froala_editor.min.js'); }}
{{ HTML::script('js/geoPosition.js'); }}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

{{ HTML::style('js/datepicker/default.css'); }}
{{ HTML::style('js/datepicker/default.date.css'); }}
{{ HTML::style('css/froala_editor/font-awesome.min.css'); }}
{{ HTML::style('css/froala_editor/froala_editor.min.css'); }}
<script>
    $(document).ready(function() {
        if({{ $journal->latitude }}!=0 && {{ $journal->longitude }}!=0){
            show_map();
        }
        $('#set_current_location').click(function(){
            if (geoPosition.init()) {
                geoPosition.getCurrentPosition(show_map, function() {
                    document.getElementById('gmap').innerHTML = "Couldn't get location"
                }, {enableHighAccuracy: true});
            } else {
                document.getElementById('gmap').innerHTML = "Functionality not available";
            }
        });
    });
    
    function show_map(loc) {
        if(loc){
            var databaseLat = parseFloat(loc.coords.latitude);
            var databaseLon = parseFloat(loc.coords.longitude);
        }else{
            var databaseLat = {{ $journal->latitude }};
            var databaseLon = {{ $journal->longitude }};
        }
        var lat = parseFloat(databaseLat);
        var lon = parseFloat(databaseLon);
        $('#latitude').val(lat);
        $('#longitude').val(lon);

        var parliament = new google.maps.LatLng(lat, lon);
        var marker;
        var myOptions = {
            zoom: 15,
            center: parliament,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var map = new google.maps.Map(document.getElementById("gmap"),
                myOptions);

        var marker = new google.maps.Marker({
            position: parliament,
            map: map,
            title: 'You are here'
        });
    }
</script>
@stop