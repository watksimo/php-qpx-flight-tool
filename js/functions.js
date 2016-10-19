// Reference to Google Map displayed on page
var map;

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
    $( ".dest_list" ).sortable();
    $( ".dest_list" ).disableSelection();
    initMap();
});