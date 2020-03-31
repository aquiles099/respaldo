@set('only')
<?php
use App\Helpers\HUserType;
  if (Session::get('key-sesion')['type'] == HUserType::RESELLER) {
    unset($only);
  }
?>
@set('js', ['js/includes/resellerCtrl.js'])
@section('pageTitle', trans('messages.icsadress'))
<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #map {
    height: 100%;
  }
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

</style>
<style>
  #target {
    width: 345px;
  }
</style>
@section('icon-title')
  <i class="fa fa-map-marker" aria-hidden="true"></i>
@stop
@include('sections.translate')
@section('title', trans('messages.icsadress'))
@extends('pages.page')
@section('title-actions')
@stop
@section('body')
<div class="panel panel-default">
  <div class="panel-heading text-center">
    <span class="text-muted">
      <i class="fa fa-map-marker" aria-hidden="true"></i>
      {{trans('messages.icsadress')}}
    </span>
  </div>
  <div class="panel-body">
    @include('sections.messages')
    <input id="pac-input" class="controls" type="text" placeholder="{{trans('messages.search')}}">
    <div id="map" style="height: 400px"></div>
    <script type="text/javascript">

      function initMap() {
        var pos;
        /**
        *
        */
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
          /**
            * determina la localizacion actual
            */
             pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            console.log(pos['lat'] + '- lng' + pos['lng']);
            /**
            *
            */
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        }
       /**
        *
        */
                  console.log('POS: ' + pos);
        var map = new google.maps.Map(document.getElementById('map'), {



        center: pos,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.ROADMAP
       });

        var infoWindow = new google.maps.InfoWindow({map: map});
        /**
        *vgeolocalizacion
        */
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            /**
            *
            */
            infoWindow.setPosition(pos);
            infoWindow.setContent("{{trans('messages.here')}}");
            map.setCenter(pos);
            /**
            *
            */
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
        /**
        * mensaje de error si el navegador no soporta geolocalizacion
        */
          handleLocationError(false, infoWindow, map.getCenter());
        }
        /**
        * campo de texto
        */
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        /**
        *
        */
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
        /**
        *
        */
         var markers = [];
         /**
         *
         */
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }
          /**
          *
          */
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];
          /**
          *
          */
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };
          /**
          *
          */
          markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
          }));
          /**
          *
          */
          if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
          });
          map.fitBounds(bounds);
        });
        /**
        *
        */
      }
</script>
<script async defer
 src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTalgugI7f5_5jmJreoKWtanH4heg_pzE&callback=initMap&libraries=places">
</script>
  </div>
</div>
@stop
