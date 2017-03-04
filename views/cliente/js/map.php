<?php 
session_start(); 

?>
//map.js

//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 
var myLatLng = {lat: <?php echo $_SESSION['datos_dir']['map_latitude']; ?>, lng: <?php echo $_SESSION['datos_dir']['map_longitude']; ?>};
//Function called to initialize / create the map.
//This is called when the page has loaded.
function initMap() {

    //The center location of our map.
    var centerOfMap = new google.maps.LatLng(<?php echo $_SESSION['datos_dir']['map_latitude']; ?>, <?php echo $_SESSION['datos_dir']['map_longitude']; ?>);

    //Map options.
    var options = {
      center: centerOfMap, //Set center.
      zoom: 14 //The zoom value.
    };
   
    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);
     
    marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable: true, //make it draggable
                icon: 'http://saleosale.com.py/public/images/marker.png'
            });
    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable: true, //make it draggable
                icon: 'http://saleosale.com.py/public/images/marker.png'
            });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });
}
        
//This function will get the marker's current location and then add the lat/long
//values to our textfields so that we can save the location.
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('lat').value = currentLocation.lat(); //latitude
    document.getElementById('lng').value = currentLocation.lng(); //longitude
}
        
        
//Load the map when the page has finished loading.
google.maps.event.addDomListener(window, 'load', initMap);