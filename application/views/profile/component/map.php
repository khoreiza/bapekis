<div id="map"></div>

<script>
    "use strict";
        var marker;

        function initMap() {

            var myLatlng = {lat: -6.2252825, lng: 106.8144528};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: myLatlng
            });

            var iconBase = 'assets/img/general/location.png';

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: myLatlng,
                icon: iconBase
            });
            marker.addListener('click', toggleBounce);

            map.addListener('center_changed', function () {
                window.setTimeout(function () {
                    map.panTo(marker.getPosition());
                }, 3000);
            });

            marker.addListener('click', function () {
                map.setCenter(marker.getPosition());
            });

        }

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4ppPTHXCpBSoOkLESSfwMlD1zojoMxBc&callback=initMap">
</script>