jQuery(document).ready(function($) {
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition,showError);	
	}

	function showPosition(position, gotLat, gotLong) {
		if (navigator.geolocation) {
			gotLat = position.coords.latitude;
			gotLong = position.coords.longitude;
		}
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': new google.maps.LatLng(gotLat, gotLong)}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				/* check for each of the address components and if exist save it in a cookie */
				var address = results[0].address_components;
				$('#field_'+parseInt(rFields.address) ).val(results[0].formatted_address);
				
				for ( x in address ) {
				
					if(address[x].types == 'street_number') {
						if(address[x].long_name != undefined) {
							var streetNumber = address[x].long_name;
							if( rFields.street != undefined || rFields.street != '') {
								$('#field_'+parseInt(rFields.street) ).val(streetNumber);
							}
						}
					}
					
					if (address[x].types == 'route') {
						if(address[x].long_name != undefined) {
							var streetName = address[x].long_name;
							if(streetNumber != undefined) {
								street = streetNumber + " " + streetName;
								if( rFields.street != undefined || rFields.street != '') {
									$('#field_'+parseInt(rFields.street) ).val(street);
								}
							} else {
								street = streetName;
								if( rFields.street != undefined || rFields.street != '') {
									$('#field_'+parseInt(rFields.street) ).val(street);
								}
							}
						}		
					}
								
					if (address[x].types == 'administrative_area_level_1,political') {
						state = address[x].short_name;
						if( rFields.state != undefined || rFields.state != '') {
							$('#field_'+parseInt(rFields.state) ).val(state);
						}
					 } 
					 
					 if(address[x].types == 'locality,political') {
						city = address[x].long_name;
						if( rFields.city != undefined || rFields.city != '') {
							$('#field_'+parseInt(rFields.city) ).val(city);
						}
					 } 
					 
					 if (address[x].types == 'postal_code') {
						zipcode = address[x].long_name;
						
						if( rFields.zipcode != undefined || rFields.zipcode != '') {
							$('#field_'+parseInt(rFields.zipcode) ).val(zipcode);
						}
					} 
					
					if (address[x].types == 'country,political') {
						country = address[x].long_name;
						if( rFields.country != undefined || rFields.country != '') {
							$('#field_'+parseInt(rFields.country) ).val(country);
						}
					 } 
				}
			} else {
				alert('Geocoder failed due to: ' + status);
			}
		});
	}

	function showError(error) {
		switch(error.code) {
    		case error.PERMISSION_DENIED:
      			alert('User denied the request for Geolocation'); 		
      		break;
    		case error.POSITION_UNAVAILABLE:
      			alert('Location information is unavailable');
      		break;
    		case error.TIMEOUT:
      			alert('The request to get user location timed out');
      		break;
    			case error.UNKNOWN_ERROR:
      			alert('An unknown error occurred');
      		break;
		}
	}
});