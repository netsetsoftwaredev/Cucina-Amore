define([
    "jquery",
    "jquery/ui"
], function ($) {

    $.widget('mage.amLocator', {
        options: {},
        url: null,
        useGeo: null,
        imageLocations: null,
        filterAttributeUrl: null,
        
        _create: function () {
            this.url = this.options.ajaxCallUrl;
            this.filterAttributeUrl = this.options.filterAttributeUrl;
            this.useGeo = this.options.useGeo;
            this.imageLocations = this.options.imageLocations;
            this.Amastyload();
            var self = this;
            $('#locateNearBy').click(function(){
                self.navigateMe()
            });
            $('#sortByFilter').click(function(){
                self.sortByFilter()
            });

            $('#filterAttribute').click(function(){
                self.filterByAttribute()
            });
            $("[name='leftLocation']").click(function(){
                var id =  $(this).attr('data-amid');
                self.gotoPoint(id, this);
            });
			$("[name='leftLocation']").hover(function(){
				var id =  $(this).attr('data-amid');
                self.gotoPoint(id, this);
            });

            $( ".today_schedule" ).click(function(event) {
                $(this).next( ".all_schedule" ).toggle( "slow", function() {
                    // Animation complete.
                });
                $(this).find( ".locator_arrow" ).toggleClass("arrow_active");
                event.stopPropagation();
            });
        },

        goHome: function(){
            window.location.href = window.location.pathname;
        },

        navigateMe: function(){

            if ( (navigator.geolocation) && (this.useGeo==1) ) {
                var self = this;
                navigator.geolocation.getCurrentPosition( function(position) {
                    self.makeAjaxCall(position);
                }, this.navigateFail );
            }else{
                this.makeAjaxCall();
            }
        },

        navigateFail: function(error){

        },

        getQueryVariable: function(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
        },

        makeAjaxCall: function(position) {
            var self = this;
            if ( (position != "") && (typeof position!=="undefined")){

                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
				//var cat_ids = document.getElementById("cat_ids").value;

                $.ajax({
                    url     : this.url,
                    type    : 'POST',
                    data: {"lat": lat, "lng": lng},
                    showLoader: true
                }).done($.proxy(function(response) {
                    response = JSON.parse(response);
                    $("#amlocator_left").replaceWith(response.block);
                    self.options.jsonLocations = response;
                    self.Amastyload(response);
					alert('self load');
                    $("[name='leftLocation']").click(function(){
                        var id =  $(this).attr('data-amid');
                        self.gotoPoint(id, this);
                    });
					
					$("[name='leftLocation']").hover(function(){
						var id =  $(this).attr('data-amid');
						self.gotoPoint(id, this);
					});
					
					
                }));
            }else{
                $.ajax({
                    url     : this.url,
                    type    : 'POST',
                    showLoader: true,
                    data: {"sort":"distance", "lat": lat, "lng": lng},
                }).done($.proxy(function(response) {
                    response = JSON.parse(response);
                    $("#amlocator_left").replaceWith(response.block);
                    self.options.jsonLocations = response;
                    self.Amastyload(response);
                    $("[name='leftLocation']").click(function(){
                        var id =  $(this).attr('data-amid');
                        self.gotoPoint(id, this);
                    });
					
					$("[name='leftLocation']").hover(function(){
						var id =  $(this).attr('data-amid');
						self.gotoPoint(id, this);
					});
					
                }));
            }

        },

        Amastyload: function() {
            this.initializeMap();
            this.processLocation(this.options.jsonLocations);

            var markerCluster = new MarkerClusterer(this.map, this.marker, {imagePath: this.imageLocations+'/m'});

            this.geocoder = new google.maps.Geocoder();

            var address = document.getElementById('amlocator-search');
            var autocomplete = new google.maps.places.Autocomplete(address);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById("am_lat").value = place.geometry.location.lat();
                document.getElementById("am_lng").value = place.geometry.location.lng();
            });
        },

        sortByFilter: function(){

            var radius = document.getElementById("amlocator-radius").value;
            //var radius = e.options[e.selectedIndex].value;
            var lat = document.getElementById("am_lat").value;
            var lng = document.getElementById("am_lng").value;
			var cat_ids = document.getElementById("cat_ids").value;
            if (!lat || !lng){
                alert('Please fill Current Location field');
                return false;
            }
            var self = this;

            $.ajax({
                url     : this.url,
                type    : 'POST',
                data: {"lat": lat, "lng": lng, "radius": radius, cat_ids:cat_ids},
                showLoader: true
            }).done($.proxy(function(response) {
                response = JSON.parse(response);
                $("#amlocator_left").replaceWith(response.block);
                self.options.jsonLocations = response;
                self.Amastyload(response);
                $("[name='leftLocation']").click(function(){
                    var id =  $(this).attr('data-amid');
                    self.gotoPoint(id, this);
                });
				$("[name='leftLocation']").hover(function(){
					var id =  $(this).attr('data-amid');
					self.gotoPoint(id, this);
				});
				
                $( ".today_schedule" ).click(function(event) {
                    $(this).next( ".all_schedule" ).toggle( "slow", function() {
                        // Animation complete.
                    });
                    $(this).find( ".locator_arrow" ).toggleClass("arrow_active");
                    event.stopPropagation();
                });
				
            }));

        },

        filterByAttribute: function(){

            var form = $("#attribute-form").serialize();

            var self = this;

            $.ajax({
                url     : this.filterAttributeUrl,
                type    : 'POST',
                data: {"attributes": form},
                showLoader: true
            }).done($.proxy(function(response) {
                response = JSON.parse(response);
                $("#amlocator_left").replaceWith(response.block);
                self.options.jsonLocations = response;
                self.Amastyload(response);
                $("[name='leftLocation']").click(function(){
                    var id =  $(this).attr('data-amid');
                    self.gotoPoint(id, this);
                });
				$("[name='leftLocation']").hover(function(){
					var id =  $(this).attr('data-amid');
					self.gotoPoint(id, this);
				});
                $( ".today_schedule" ).click(function(event) {
                    $(this).next( ".all_schedule" ).toggle( "slow", function() {
                        // Animation complete.
                    });
                    $(this).find( ".locator_arrow" ).toggleClass("arrow_active");
                    event.stopPropagation();
                });
            }));

        },

        initializeMap: function() {
            this.infowindow = [];
            this.marker = [];
            var myOptions = {
                zoom: 9,
				// How you would like to style the map. 
				// This is where you would paste any style found on Snazzy Maps.
				styles: [{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#c79c60"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#c79c60"},{"saturation":-52},{"lightness":-10},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#c79c60"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#c79c60"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#c79c60"},{"saturation":-52},{"lightness":-10},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#c79c60"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#c79c60"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}],
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            this.map = new google.maps.Map(document.getElementById("amlocator-map-canvas"), myOptions);
			
        },

        processLocation: function(locations) {
            var template = baloonTemplate.baloon; // document.getElementById("amlocator_window_template").innerHTML;
            var curtemplate = "";
                //alert('testing'); 
            if (typeof locations.totalRecords=="undefined" || locations.totalRecords==0){
                this.map.setCenter(new google.maps.LatLng( document.getElementById("am_lat").value, document.getElementById("am_lng").value ));
                return false;
            }
			var latt = document.getElementById("am_lat").value;
			var lngt = document.getElementById("am_lng").value;

            for (var i = 0; i < locations.totalRecords; i++) {

                curtemplate = template;
                curtemplate = curtemplate.replace("{{name}}",locations.items[i].name);
                //curtemplate = curtemplate.replace("{{distance}}",locations.items[i].distance);
				curtemplate = curtemplate.replace("{{city}}",locations.items[i].city);
                curtemplate = curtemplate.replace("{{zip}}",locations.items[i].zip);
                curtemplate = curtemplate.replace("{{address}}",locations.items[i].address);
                curtemplate = curtemplate.replace("{{id}}",locations.items[i].id);
                curtemplate = curtemplate.replace("{{lat}}",latt);
                curtemplate = curtemplate.replace("{{lng}}",lngt);

                curtemplate = this.replaceIfStatement(curtemplate, locations.items[i].state,'state');
                curtemplate = this.replaceIfStatement(curtemplate, locations.items[i].email,'email');
                curtemplate = this.replaceIfStatement(curtemplate, locations.items[i].phone,'phone');
                curtemplate = this.replaceIfStatement(curtemplate, locations.items[i].website,'website');
                curtemplate = this.replaceIfStatement(curtemplate, locations.items[i].website,'websitelink');

                curtemplate = this.showAttributeInfo(curtemplate, locations.items[i], locations.currentStoreId);
                if  ( typeof locations.items[i].description != 'undefined' && locations.items[i].description!=null ) {
                    curtemplate = curtemplate.replace("{{description}}",locations.items[i].description);
                } else {
                    curtemplate = curtemplate.replace("{{description}}","");
                }
				var dist = parseFloat(Math.round(locations.items[i].distance * 100) / 100).toFixed(2);
				
				if  ( dist != 'NaN') {
                    curtemplate = curtemplate.replace("{{distance}}",dist+" Miles");
                } else {
                    curtemplate = curtemplate.replace("{{distance}}","");
                }
				
				if  ( typeof lngt != 'undefined' && lngt != null ) {
                    curtemplate = curtemplate.replace("{{lng}}",lngt);
                } else {
                    curtemplate = curtemplate.replace("{{lng}}","");
                }
				
				if  ( typeof latt != 'undefined' && latt !=null ) {
                    curtemplate = curtemplate.replace("{{lat}}",latt);
                } else {
                    curtemplate = curtemplate.replace("{{lat}}","");
                }

                if (locations.items[i].phone != "") {
                    curtemplate = curtemplate.replace("{{phone}}",locations.items[i].phone);
                }

                if (locations.items[i].email != "") {
                    curtemplate = curtemplate.replace("{{email}}",locations.items[i].email);
                }

                if (locations.items[i].url != "") {
                    curtemplate = curtemplate.replace("{{url}}",locations.items[i].url);
                }

                if (locations.items[i].store_img != "") {
                    curtemplate = curtemplate.replace("{{photo}}",locations.items[i].store_img);
                } else {
                    curtemplate = curtemplate.replace(/<img[^>]*>/g,"");
                }
				console.log('marker_image:'+locations.items[i].marker_img);
                if (locations.items[i].marker_img != "") {
                    markerImage = amMediaUrl + locations.items[i].marker_img;
                } else {
                    markerImage = "";
                }
                this.createMarker(locations.items[i].lat, locations.items[i].lng,  curtemplate, markerImage);
            }
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < this.marker.length; i++) {
                bounds.extend(this.marker[i].getPosition());
            }

            this.map.fitBounds(bounds);
            if (locations.totalRecords == 1) {
                google.maps.event.addListenerOnce(this.map, 'bounds_changed', function() {
                    this.setZoom(12);
                })
            }
        },

        showAttributeInfo: function (curtemplate, item, currentStoreId) {
            var attributeTemplate = baloonTemplate.attributeTemplate;
            if (item.attributes) {
                for (var j = 0; j < item.attributes.length; j++) {
                    var label = item.attributes[j].frontend_label;
                    var labels = item.attributes[j].labels;
                    if (labels[currentStoreId]) {
                        label = labels[currentStoreId];
                    }

                    var value = item.attributes[j].value;
                    if (item.attributes[j].boolean_title) {
                        value = item.attributes[j].boolean_title;
                    }
                    if (item.attributes[j].option_title) {
                        var optionTitles = item.attributes[j].option_title;
                        value = '<br>';
                        for (var k = 0; k < optionTitles.length; k++) {
                            value += '- ';
                            if (optionTitles[k][currentStoreId]) {
                                value += optionTitles[k][currentStoreId];
                            } else {
                                value += optionTitles[k][0];
                            }
                            value += '<br>';
                        }
                    }
                    attributeTemplate = attributeTemplate.replace("{{title}}",label);
                    curtemplate += attributeTemplate.replace("{{value}}",value);

                    attributeTemplate = baloonTemplate.attributeTemplate;
                }
            }
            return curtemplate;
        },

        gotoPoint: function(myPoint,element){
            this.closeAllInfoWindows();
            if (typeof element!=="undefined"){
                element.className = element.className + " active";
            }else{
                var spans = document.getElementById('amlocator_left').getElementsByTagName('span');
                if(spans.length > 0) {
                    spans[0].className = spans[0].className + "active";
                }
            }
            this.map.setCenter(new google.maps.LatLng( this.marker[myPoint-1].position.lat(), this.marker[myPoint-1].position.lng()));
            this.map.setZoom(20);
            this.marker[myPoint-1]['infowindow'].open(this.map, this.marker[myPoint-1]);
        },

        replaceIfStatement: function(text,value,template){
            var patt = new RegExp("\{\{if"+template+"\}\}([\\s\\S]*)\{\{\/\if"+template+"}\}","g");
            var cuteText = patt.exec(text);
            if (cuteText!=null ){
                if (value=="" || value==null){
                    text = text.replace(cuteText[0], '');
                }else{
                    var finalText = cuteText[1].replace('{{'+template+'}}', value);
                    text = text.replace(cuteText[0], finalText);
                }

                return text;
            }
            return text;
        },

        createMarker: function(lat, lon, html, marker) {
            var image = marker.split('/').pop();
            if (marker && image != 'null') {
				console.log(marker)
                var marker = {
                    url: marker,
                    size: new google.maps.Size(48, 48),
                    scaledSize: new google.maps.Size(48, 48)
                };
                var newmarker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lon),
                    map: this.map,
                    icon: marker
                });
            } else {
                var newmarker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lon),
                    map: this.map
                });
            }

            newmarker['infowindow'] = new google.maps.InfoWindow({
                content: html
            });
            var self = this;
            google.maps.event.addListener(newmarker, 'click', function() {
                self.closeAllInfoWindows();
                this['infowindow'].open(self.map, this);
                self.map.setZoom(20);
            });

            this.marker.push(newmarker);
        },

        closeAllInfoWindows: function () {

            var spans = document.getElementById('amlocator_left').getElementsByTagName('span');

            for(var i = 0, l = spans.length; i < l; i++){

                spans[i].className = spans[i].className.replace(/\active\b/,'');
            }

            if (typeof this.marker !=="undefined"){
                for (var i=0;i<this.marker.length;i++) {
                    this.marker[i]['infowindow'].close();
                }
            }

        },

    });

    return $.mage.amLocator;
});
