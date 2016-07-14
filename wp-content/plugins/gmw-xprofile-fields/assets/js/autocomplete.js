jQuery(document).ready(function($) {

	var options = {
			types: ['geocode'],
	};
	
	var input 	= document.getElementById( autoComp );
	
    var autocomplete = new google.maps.places.Autocomplete( input, options);
    
    google.maps.event.addListener(autocomplete, 'place_changed', function(e) {
    	
    	var place = autocomplete.getPlace();

		if (!place.geometry) {
			return;
		}
		
		$('#'.autoComp).val( place.formatted_address );
				
    });
	        
});