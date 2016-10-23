/**
 * Created by k on 24.09.16.
 */

$(function() {
    display_sub_region();
});

function display_sub_region() {

    if ($('select[name$="[country_id]"]').val() == 49 && $('select[name$="[region_id]"]').val() == 5145349) {
        $("#sub_region").show();
    } else {
        $("#sub_region").hide();
        $('select[name$="[sub_region_id]"]').select2('val', '');
    }

}

function loadRegions(country_id, region_id) {

    $('select[name$="[region_id]"]').html('').select2().prop("disabled", true);

    return $.ajax({
        type: 'post',
        url: '/geo/regions',
        data: {'Model[country_id]': country_id},
        success: function(data) {
            $('select[name$="[region_id]"]').html(data).select2('val', region_id).prop("disabled", false);
            display_sub_region();
        }
    });
}

function loadCountries(country_id, region_id) {
    $.ajax({
        type: 'post',
        url: '/geo/countries',
        success: function(data) {
            $('select[name$="[country_id]"]').html(data).select2('val', country_id);
            loadRegions(country_id, region_id);
        }
    });
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(processGeodata, showError);
    } else {
        $('#console').html("Geolocation is not supported");
    }
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            $('#console').html("User denied the Geolocation");
            break;
        case error.POSITION_UNAVAILABLE:
            $('#console').html("Location information is unavailable");
            break;
        case error.TIMEOUT:
            $('#console').html("The request to get user location timed out");
            break;
        case error.UNKNOWN_ERROR:
            $('#console').html("An unknown error occurred");
            break;
    }
}

function processGeodata(position) {

    var lat = position.coords.latitude;
    var long = position.coords.longitude;

    var resSubregion = '';
    var resRegion = '';
    var resCountry = '';

    $.ajax({
            url: '//maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + long + '&language=en'
        })
        .done(function(data) {

            $.each(data.results[0].address_components, function(index, value) {

                if (value['types'].indexOf('country') != -1) {
                    resCountry = value.long_name;
                }

                if (value['types'].indexOf('administrative_area_level_1') != -1) {
                    resRegion = value.long_name;
                }

                if (value['types'].indexOf('administrative_area_level_2') != -1) {
                    resSubregion = value.long_name;
                }

            });

            var id = setRegion('country_id', resCountry);
            $.when(loadRegions(id, '')).done(function() {
                setRegion('region_id', resRegion);
                display_sub_region();
                setRegion('sub_region_id', resSubregion);
            });
        });
}

function setRegion(item_name, region_name) {

    var id = $('select[name$="[' + item_name + ']"]').find('option:contains("' + region_name + '")').val();
    $('select[name$="[' + item_name + ']"]').select2('val', id);
    return id;

}
