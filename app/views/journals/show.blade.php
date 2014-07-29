@extends('general')

@section('content')
<?php //echo "<pre>"; print_r($journal);?>
<div class="ui stacked segment">
    <div class="grouped inline fields two column ui grid">
        <div class="column">
            <div class="inline fields">
                <div class="date field">
                    <h2>{{ $journal->title }}</h2>
                    @foreach($journal->days()->get() as $day)
                        <p>{{ date('M j, Y', strtotime($day->date)) }}</p>
                    @endforeach
                    
                    @if(Auth::check())
                        <a class="btn btn-small btn-info" href="{{ URL::to('journal/' . $journal->id . '/edit') }}"><i class="edit icon"></i></a>
                        {{ Form::open(array('url' => 'journal/' . $journal->id, 'class' => 'pull-right')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
                        {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
        <div class="column" id="gmap" style="height: 155px;"><img src="{{asset('images/your_location.jpg')}}"/></div>
    </div>
    
    @foreach($journal->days()->get() as $day)
        {{ $day->description }}
    @endforeach
    
    <div class="ui two stackable items">
        @foreach($journal->photos()->get() as $photo)
            <div class="item">
                <div class="image">
                    <img src="{{ asset($photo->path.$photo->name) }}">
                </div>
                <div class="content">
                    <!--<div class="name">Cute Dog</div>-->
                    <p class="description">{{ $photo->caption }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="disqus_thread"></div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'kdevshr9'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        
        if({{ $journal->latitude }}!=0 && {{ $journal->longitude }}!=0){
            show_map();
        }
    })();
    
    function show_map(loc) {
        var databaseLat = {{ $journal->latitude }};
        var databaseLon = {{ $journal->longitude }};
        
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
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
@stop