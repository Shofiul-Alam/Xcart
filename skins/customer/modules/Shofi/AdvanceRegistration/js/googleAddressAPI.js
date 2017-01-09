/**
 * Created by admin on 7/01/2017.
 */


<!-- Custom Start-->

// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">



if (document.getElementById('address-autocomplete')){
    $('#sh-address .regular-main-button').keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 10 ) {
            event.preventDefault();
            return false;
        }
    });

    $('#address-autocomplete').keypress(function(event) {
        if(event.keyCode == 13 || event.keyCode == 10 ) {
            event.preventDefault();
            return false;
        }
    });

    $("#sh-address .default-section").hide();
}

var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    country: 'long_name',
    postal_code: 'short_name',
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    if (document.getElementById('address-autocomplete')){
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address-autocomplete')),
            {types: ['geocode']});


        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);

    }
}


function fillInAddress() {

    $("#sh-address .default-section").show("slow");
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        if (component == "locality") {
            component = '#-city';
        }
        else if (component == "administrative_area_level_1") {
            component = '#-state-id';
        }
        else if (component == "country") {
            component = '#-country-code';

        }
        else if (component == "postal_code") {
            component = '#-zipcode';
        }


        $(component).val("");
        $(component).prop("disabled", false);
    }
    var state_code = "";
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        console.log(addressType);

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            console.log(val);

            if (addressType == "street_number") {
                var st_number = val;
            }
            else if (addressType == "route") {
                addressType = '#-street';
                if (st_number) {
                    $(addressType).val(st_number + " " + val);
                } else {
                    $(addressType).val(val);
                }

            }
            else if (addressType == "locality") {
                addressType = '#-city';
                $(addressType).val(val);
            }
            else if (addressType == "administrative_area_level_1") {

                state_code = val;
                console.log(state_code);
            }
            else if (addressType == "country") {
                addressType = '#-country-code';
                $('#-country-code option:contains(' + val + ')').prop({selected: true});


                jQuery(document).ready(function () {
                    UpdateStatesList();
                });


                console.log(state_code);
                $('#-state-id option:contains(' + state_code + ')').prop({selected: true});

            }
            else if (addressType == "postal_code") {
                addressType = '#-zipcode';
                $(addressType).val(val);
            }
        }
    }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}





