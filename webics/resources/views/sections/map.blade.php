<style>
  #map {
    height: 300px;
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>
<div id="map">
  <div class="text-center" style="color: white">
    <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
    Espere...
  </div>
</div>
<script>
    function initMap() {
      var myLatLng = {
        lat: {{env('ICS_MAP_LATITUDE')}},
        lng: {{env('ICS_MAP_LONGITUDE')}}
      };
      /**
      * Define Map
      */
      var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 18
      });
      /**
      * Set info Windows
      */
      var infowindow = new google.maps.InfoWindow({
        content: "<img src='{{asset('dist/img/sps.png')}}' style='height:60px'>"
      });
      /**
      * Set Marker
      */
      var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: "{{trans('messages.SPS')}}"
      });
      /**
      *
      */
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });
    }
 </script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTalgugI7f5_5jmJreoKWtanH4heg_pzE&callback=initMap&libraries=places"></script>
