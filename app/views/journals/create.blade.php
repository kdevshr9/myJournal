@extends('general')

@section('content')
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url'=>'journal', 'class'=>'dropzone', 'id'=>'my-awesome-dropzone')) }}
<div class="ui form segment">
    <input type="hidden" name="current_latitude" id="current_latitude"/>
    <input type="hidden" name="current_longitude" id="current_longitude"/>
    <input type="hidden" name="current_formatted_address" id="current_formatted_address"/>
    <input type="hidden" name="type" id="type" value="1"/>
    <div class="grouped inline fields two column ui grid">
        <div class="column">
            <div class="inline fields" id="single_day_journal_date">
                <div class="date field">
                    <input placeholder="Journal Date" type="text" name="date" class="datepicker">
                </div>
            </div>
        </div>
        <div class="column">
            <div id="current_location" style="height: 155px;"><img src="{{asset('images/your_location.jpg')}}"/></div>
            <div class="label" id="current_formatted_address_label"></div>
        </div>
    </div>
    <div class="ui labeled icon button" id="get_my_location">
        <i class="map marker icon"></i>Get my location
    </div>
    <div class="inline field" >
        <div class="field">
            <input placeholder="Journal Title" type="text" name="title">
        </div>
    </div>
    <div class="field">
        <textarea class="editor" name="description"></textarea>
        <!--<div class="editor"></div>-->
    </div>
    
    <div class="field">        
        <div class="hid" id="journal_day_location">
            <div class="map_canvas" id="journal_day_map"></div>
            <div class="fluid action input">
                <input id="journal_day_location_search_box" placeholder="Type in an address" type="text" value="">
            </div>
<!--            <input name="lat" id="journal_day_location_latitude" type="hidden" value="">
            <input name="lng" id="journal_day_location_longitude" type="hidden" value="">
            <input name="formatted_address" id="journal_day_location_formatted_address" type="hidden" value="">-->
        </div>
        <div id="journal_day_location_hidden_values"></div>
    </div>

    <div class="field" id="gallery">
<!--        <h2 class="ui header">
            <i class="photo icon"></i>
            <div class="content">
                Gallery
                <div class="sub header">Add photos, maximum 10, each not more than 2Mb</div>
                <div class="ui labeled icon button mini green" id="select_photo"><i class="add icon"></i>Add Photo</div>
                <div class="ui right labeled icon button mini red" id="remove_photo"><i class="right remove icon"></i>Remove all</div>
            </div>
        </h2>-->
        <div class="ui icon message">
            <i class="photo icon"></i>
            <div class="content">
                <div class="header">
                    Add photos in your Gallery
                </div>
                <p>Fill up your gallery with the best photos of today. Drag and drop the photos or click the plus button. Max upload size 2Mb each photo. Max upload limit 10 photos</p>
            </div>
            <div class="ui icon buttons">
                <div class="ui button black" id="select_photo"><i class="add icon"></i></div>
                <div class="ui button black" id="remove_photo"><i class="remove icon"></i></div>
            </div>
        </div>
        <div id="preview" class="ui four stackable items">
            <div class="item" id="template">
                <div class="image">
                    <img data-dz-thumbnail>
                    <a data-dz-remove class="like ui corner label">
                        <i class="remove icon" style="display: none"></i>
                    </a>
                </div>
                <div class="content">
                    <div class="meta">                        
                        <div class="ui dropdown">
                            <input name="journal_day_photo_location[]" type="hidden">
                            <div class="default text journal_day_photo_location label"><p>taken at...</p></div>
                            <i class="dropdown icon journal_day_photo_location"></i>
                            <div class="menu"></div>
                        </div>
                    </div>
                    <!--<div class="name" data-dz-name></div>-->
                    <h5 class="ui red header" data-dz-errormessage></h5>
                    <div class="extra"><p class="size" data-dz-size></p></div>
                    <input type="text" placeholder="Caption" name="caption[]"/>
                </div>
                <div>
                    <div class="ui active striped progress">
                        <div class="bar" style="width: 0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<input type="submit" class="ui blue submit button" value="Save">-->
    <div class="ui buttons">
        <div class="ui button">Cancel</div>
        <div class="or"></div>
        <div class="ui teal button" id="save_button">Save</div>
    </div>
</div>
{{ Form::close() }}

{{ HTML::script('js/datepicker/picker.js'); }}
{{ HTML::script('js/datepicker/picker.date.js'); }}
{{ HTML::script('js/froala_editor/froala_editor.min.js'); }}
{{ HTML::script('js/geoPosition.js'); }}
{{ HTML::script('js/dropzone.min.js'); }}
<!--{{ HTML::script('js/jquery.geocomplete.min.js'); }}-->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->

{{ HTML::style('js/datepicker/default.css'); }}
{{ HTML::style('js/datepicker/default.date.css'); }}
{{ HTML::style('css/froala_editor/font-awesome.min.css'); }}
{{ HTML::style('css/froala_editor/froala_editor.min.css'); }}
<!--{{ HTML::style('css/dropzone.css'); }}-->
<style>
    .dz-default{
        display: none;
    }
    .map_canvas {
        height: 350px;
        margin: 10px 20px 10px 0;
        /*width: 600px;*/
    }

    .map_canvas:after {
        content: "Want to tell where this happened? Type in an address in the input below.";
        font-family: 'Lato',sans-serif;
        padding-top: 170px;
        display: block;
        text-align: center;
        font-size: 2em;
        color: #999;
    }
</style>
<script>
$(document).ready(function() {
    $('#save_button').click(function(){ $('#my-awesome-dropzone').submit(); });
    $('.dz-default').hide();
    $(document).on('click', '.journal_day_photo_location', function(){
        var element = $(this);
        var marker_name = [];
        $(".journal_day_location_marker_name").each(function() {
            marker_name.push($(this).val());
        });
        
        element.parent().find('.menu').html('');
        $.each(marker_name, function(key, value){
//            $(this).append($("<option></option>").attr("value",key).text(value)); 
            element.parent().find('.menu').append('<div class="item" data-value="'+value+'"><p>'+value+'</p></div>');
            $('.ui.dropdown').dropdown();
        });
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var mapOptions = {
            zoom: 17,
            center: new google.maps.LatLng(2.205685, 102.25615500000004),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: true
        };
        var map = new google.maps.Map(document.getElementById('journal_day_map'), mapOptions);
        
        
        
        var input = (document.getElementById('journal_day_location_search_box'));
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) { return; }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
        });
        
        
        
        google.maps.event.addListener(map, 'click', addMarker);
 
        function addMarker(event) {
            var latLng = event.latLng.lat()+'_'+event.latLng.lng();
            var contentString = '<input type="text" placeholder="Enter place name" class="journal_day_location_marker_name" name="journal_day_location_marker_name[]" id="marker_name_'+latLng+'"/>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                icon: 'http://localhost:8000/images/google_map_marker.png'
            });
            infowindow.open(map,marker);
            
            var latLng_element = '<input type="hidden" name="journal_day_location_markers[]" id="JDLM_'+latLng+'" value="'+latLng+'"/>';
            $('#journal_day_location_hidden_values').append(latLng_element);
            setFormattedAddress_For_Journal_Day_Location_Marker(event.latLng.lat(), event.latLng.lng());
            
//            google.maps.event.addListener(marker, 'click', function(event) {
//                marker.setMap(null);
//                var latLng_element_id = event.latLng.lat()+'_'+event.latLng.lng();
//                $('input[type="hidden"][id="'+latLng_element_id+'"]').remove();
////                for (var i = 0, I = markers.length; i < I && markers[i] != marker; ++i);
////                markers.splice(i, 1);
//            });
            google.maps.event.addListener(marker, 'dragstart', function(event) {
                var latLng_element_id = event.latLng.lat()+'_'+event.latLng.lng();
                $('input[type="hidden"][id="JDLM_'+latLng_element_id+'"]').remove();
                $('input[type="hidden"][id="JDLMFA_'+latLng_element_id+'"]').remove();
            });
            google.maps.event.addListener(marker, 'dragend', function(event) {
                var latLng = event.latLng.lat()+'_'+event.latLng.lng();
                var latLng_element = '<input type="hidden" name="journal_day_location_markers[]" id="JDLM_'+latLng+'" value="'+latLng+'"/>';
                $('#journal_day_location_hidden_values').append(latLng_element);
                setFormattedAddress_For_Journal_Day_Location_Marker(event.latLng.lat(), event.latLng.lng());
            });
            
            google.maps.event.addListener(infowindow,'closeclick',function(){
                marker.setMap(null);
                var latLng_element_id = marker.position.lat()+'_'+marker.position.lng();
                $('input[type="hidden"][id="JDLM_'+latLng_element_id+'"]').remove();
                $('input[type="hidden"][id="JDLMFA_'+latLng_element_id+'"]').remove();
            });
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    
    
    $('#get_my_location').click(function(){
        if (geoPosition.init()) {
    //        document.getElementById('gmap').innerHTML = "Receiving...";
            geoPosition.getCurrentPosition(show_map, function() {
                document.getElementById('current_location').innerHTML = "Couldn't get location"
            }, {enableHighAccuracy: true});
        } else {
            document.getElementById('current_location').innerHTML = "Functionality not available";
        }
    });
});

function show_map(loc) {
    var lat = parseFloat(loc.coords.latitude);
    var lon = parseFloat(loc.coords.longitude);
    set_formatted_address(lat, lon);
    
    $('#current_latitude').val(lat);
    $('#current_longitude').val(lon);

    var parliament = new google.maps.LatLng(lat, lon);
    var marker;
    var myOptions = {
        zoom: 16,
        center: parliament,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    };
    var map = new google.maps.Map(document.getElementById("current_location"),
            myOptions);

    var marker = new google.maps.Marker({
        position: parliament,
        map: map,
        title: 'You are here'
    });
}

function set_formatted_address(lat, lon){
    var request = new XMLHttpRequest();
    var method = 'GET';
    var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lon + '&sensor=true';
    var async = true;
    request.open(method, url, async);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var data = JSON.parse(request.responseText);
            var address = data.results[0];
            document.getElementById("current_formatted_address").value = address.formatted_address;
            document.getElementById("current_formatted_address_label").innerHTML = address.formatted_address;
//            var n = address.formatted_address.split(",");
//            city.value = n[n.length - 3];
        }
    };
    request.send();
}

function setFormattedAddress_For_Journal_Day_Location_Marker(lat,lng){
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                var address = results[1].formatted_address;
                var latLng = lat+'_'+lng;
                var latLng_element = '<input type="hidden" name="journal_day_location_marker_formatted_address[]" id="JDLMFA_'+latLng+'" value="'+address+'"/>';
                $('#journal_day_location_hidden_values').append(latLng_element);
            } else {
                alert('No results found');
            }
        } else {
            alert('Geocoder failed due to: ' + status);
        }
  });
}

var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
Dropzone.options.myAwesomeDropzone = {
    acceptedFiles: "image/*",
    url: "/journal/upload",
    thumbnailWidth: 520,
    thumbnailHeight: 520,
    autoProcessQueue: true,
//    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 10,
    maxFilesize: 2,
    previewTemplate: previewTemplate,
    previewsContainer: "#preview",
    clickable: "#select_photo",
//    addRemoveLinks: true,
    init: function() {
        myDropzone = this; // closure
        //THIS FUNCTION IS CALLED AFTER SUCCESS
        this.on("success", function(file, responseText) {
            file.serverId = responseText;
            var element=document.createElement("input");                                    //CREATE AN INPUT ELEMENT
            element.setAttribute('type', 'hidden');                                         //MAKE IT HIDDEN
            element.setAttribute('class', 'serverFileName');                                //GIVE A CLASS
            element.setAttribute('name', 'photo_name[]');                                   //GIVE THE ELEMENT NAME OF photo_name[]
            element.setAttribute('value', responseText);                                    //ASSIGN THE RETURNED VALUE WHICH IS THE NAME OF THE FILE STORED
            file.previewTemplate.appendChild(element);                                      //APPEND THE ELEMENT TO THE TEMPLATE
            file.previewElement.querySelector(".remove").style.display = "block";           //DISPLAY THE REMOVE BUTTON
            file.previewElement.querySelector(".progress").classList.add("successful");     //MAKE THE PROGRESS BAR SUCCESSFUL
            file.previewElement.querySelector(".progress").style.display = "none";          //HIDE THE PROGRESS BAR
            $('.ui.dropdown').dropdown();
        });
        this.on("removedfile", function(file) {
            var server_file = $(file.previewTemplate).children('.serverFileName').val();
            if(server_file){ $.post("/journal/delete", { fileName: server_file }) };
        });
        
        document.querySelector("#remove_photo").onclick = function() {
            myDropzone.removeAllFiles(true);
        };
    }
};






//var previewNode = document.querySelector("#template");
//previewNode.id = "";
//var previewTemplate = previewNode.parentNode.innerHTML;
//previewNode.parentNode.removeChild(previewNode);
//var myDropzone = new Dropzone(document.body, {
//    url: "/journal",
//    thumbnailWidth: 320,
//    thumbnailHeight: 320,
//    autoProcessQueue: false,
//    uploadMultiple: true,
//    parallelUploads: 100,
//    maxFiles: 100,
//    previewTemplate: previewTemplate,
//    previewsContainer: "#preview",
//    clickable: "#select_photo"
//});
//document.querySelector(".submit").onclick = function() {
//    myDropzone.processQueue();
//};
//document.querySelector("#remove_photo").onclick = function() {
//  myDropzone.removeAllFiles(true);
//};


//Dropzone.options.myAwesomeDropzone = {
//    autoProcessQueue: false,
//    uploadMultiple: true,
//    parallelUploads: 100,
//    maxFiles: 100,
//    addRemoveLinks: true,
//    previewsContainer: '.dropzone-previews',
//    previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size" data-dz-size></div><img data-dz-thumbnail /><input data-dz-name type="text" name="caption[]"/></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
//    init: function() {
//        var myDropzone = this;
//        this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
//            // Make sure that the form isn't actually being sent.
//            e.preventDefault();
//            e.stopPropagation();
//            myDropzone.processQueue();
//        });
//
//        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
//        // of the sending event because uploadMultiple is set to true.
//        this.on("sendingmultiple", function() {
//            // Gets triggered when the form is actually being sent.
//            // Hide the success button or the complete form.
//        });
//        this.on("successmultiple", function(files, response) {
//            // Gets triggered when the files have successfully been sent.
//            // Redirect user or notify of success.
//        });
//        this.on("errormultiple", function(files, response) {
//            // Gets triggered when there was an error sending the files.
//            // Maybe show form again, and notify user of error
//        });
//    }
//}
</script>
@stop