
function getUrlParameter(sParam)
{
    var sPageURL = decodeURIComponent(window.location.search.substring(1));
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
} 

function initialize() {
	var direccion = getUrlParameter('direccion');
	direccion = direccion.replace(/\_/g, " ");
	direccion = direccion.replace(/\%20/g, " ");
	
	
	var geocoder = new google.maps.Geocoder();
	var marker = new google.maps.Marker();
	geocoder.geocode( { 'address': direccion}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	    	marker = new google.maps.Marker({
	        	map: map,
	        	animation: google.maps.Animation.DROP,
	        	position: results[0].geometry.location
	      	});
			map.setCenter(results[0].geometry.location);
	    } else {
	      	map.setCenter(new google.maps.LatLng( 40.4379543, -3.6795367 ));
	    }
  	});
	var map = new google.maps.Map( document.getElementById( "map_canvas" ), {
	    zoom: 15,
	    mapTypeId: google.maps.MapTypeId.SATELLITE
	} );
}

