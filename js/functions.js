// Reference to Google Map displayed on page
var map;
var autocomplete;
var new_dest = new Object();
var markerNum = 0;
var markers = new Object();

/*
Initializes Google Map on page. Stores map reference to global variable.
*/
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 8
	});
}

/*
Called when page body has completed loading.
*/
$( function() {
	$( "#dest_list" ).sortable();
	$( "#dest_list" ).disableSelection();
	initMap();
	initAutocomplete();

	$( '#addDestButton' ).click(function() {
		if(validateNewDest() > 0) {
			addDestToList(new_dest);
		} else {
			alert("Please enter valid new destination information.");
		}
		
	});
    
});

function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		(document.getElementById('destName')),
		{types: ['(cities)']}
	);

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		switch (addressType) {
			case 'locality':
			case 'colloquial_area':
				new_dest.city = place.address_components[i].long_name;
				break;
			case 'administrative_area_level_1':
				new_dest.state = place.address_components[i].long_name;
				break;
			case 'country':
				new_dest.country = place.address_components[i].long_name;
				break;
		}
	}
	new_dest.coords = '{"lat":' + place.geometry.location.lat() + ', "lng":' + 
						place.geometry.location.lng() + '}';

}

function addDestToList() {
	var listItem = document.getElementById("dest_list");
	var dest_dur = $( "#destDuration" ).val();
	var markerName = markerNum + '-marker';
	var destFullName = new_dest.city + ', ' + new_dest.state + ', ' + new_dest.country;

	var itemText = `
		<li class="dest list-group-item">
                ` + destFullName + `
                <span class="badge pull-right">` + dest_dur + ` days</span>
                <button type="button" class="deleteDest btn btn-default btn-sm">
		            <span class="glyphicon glyphicon-remove"></span>
		        </button>
		        <span class='destMarker'>` + markerName + `</span>
        </li>
	`;

	listItem.innerHTML = listItem.innerHTML + itemText;
	$('.deleteDest').click(function() {
        $(this).closest( ".dest" ).remove();

        var markerName = $(this).next( ".destMarker" ).html();
        markers[markerName].setMap(null);
    });
    
    document.getElementById('destName').value = "";
    document.getElementById('destDuration').value = "";

    var latLngObj = jQuery.parseJSON( new_dest.coords );
    add_map_marker(markerName, latLngObj, destFullName);

    new_dest = new Object();
    markerNum++;
}

function validateNewDest() {
	if( (new_dest.city == null) || (new_dest.state == null) || 
		(new_dest.country == null) || ($( "#destDuration" ).val() == "") ) {
		return -1;
	} else {
		return 1;
	}
}

function add_map_marker(markerName, myLatLng, destName) {
    markers[markerName] = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: destName
    });
}




