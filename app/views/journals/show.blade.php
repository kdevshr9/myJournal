@extends('general')

@section('content')
<?php // echo "<pre>"; print_r($photos); exit;?>

<div class="ui stacked segment">
    <div class="grouped inline fields two column ui grid">
        <div class="column">
            <div class="inline fields">
                <div class="date field">
                    <h2>{{ $journal->title }}</h2>
                    <!--@foreach($journal->days()->get() as $day)-->
                        <p>{{ date('M j, Y', strtotime($days->date)) }}</p>
                    <!--@endforeach-->
                    
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
    
    <!--@foreach($journal->days()->get() as $day)-->
        {{ $days->description }}
    <!--@endforeach-->
    
    <div id="journal_day_map" style="height: 350px"></div>
    <div class="ui two stackable items">
        @foreach($photos as $photo)
            <div class="item">
                <div class="image">
                    <img src="{{ asset($photo->path.$photo->name) }}">
                </div>
                <div class="content">
                    <div class="meta">
                        @foreach($photo->daylocation()->get() as $location)
                            <p>taken at {{ $location->manual_address }}</p>
                        @endforeach
                    </div>
                    <div class="name">{{ $photo->caption }}</div>
                    <!--<p class="description">{{ $photo->caption }}</p>-->
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="disqus_thread"></div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
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
        
        if({{ $journallocations->latitude }}!=0 && {{ $journallocations->longitude }}!=0){
            show_map();
        }
    })();
    
    function show_map(loc) {
        var databaseLat = {{ $journallocations->latitude }};
        var databaseLon = {{ $journallocations->longitude }};
        
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
<script>
    var locations = [];
    @foreach($daylocations as $key=>$value)
        var locations_entities = [];
        locations_entities.push('{{ $value->manual_address }}');
        locations_entities.push({{ $value->latitude }});
        locations_entities.push({{ $value->longitude }});
        locations.push(locations_entities);
    @endforeach
    
//    var locations = [
//      ['Landfeld Engineering, Malaysia', 3.038176, 101.551472],
//      ['Landfeld Engineering, Indonesia', -4.0419243, 121.997407]
//    ];
    
    var map = new google.maps.Map(document.getElementById('journal_day_map'), {
//      zoom: 12,
//      center: new google.maps.LatLng(1.601995, 110.3244536),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scrollwheel: false
    });
    
    var marker, i;
    var bounds = new google.maps.LatLngBounds ();
    for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          animation: google.maps.Animation.DROP,
          icon: 'http://localhost:8000/images/google_map_marker.png'
        });
      
        var boxText = document.createElement("div");
        boxText.style.cssText = "border: 2px solid black; margin-top: 8px; background: #333; color:#FFF;font-family:Arial, Helvetica, sans-serif;font-size:12px;padding: .5em 1em;-webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;text-shadow:0 -1px #000000;-webkit-box-shadow: 0 0  8px #000;box-shadow: 0 0 8px #000;text-align: center;";
        boxText.innerHTML = locations[i][0];
        infobox = new InfoBox({
           content: boxText,
           disableAutoPan: false,
           maxWidth: 150,
           pixelOffset: new google.maps.Size(-140, 0),
           zIndex: null,
           boxStyle: {
              background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
              opacity: 0.75,
              width: "280px"
          },
          closeBoxMargin: "12px 4px 2px 2px",
          closeBoxURL: "",
          infoBoxClearance: new google.maps.Size(1, 1)
        });
	infobox.open(map, marker);
        bounds.extend (marker.getPosition());
    }
    map.fitBounds(bounds);
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
@stop