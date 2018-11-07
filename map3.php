<!DOCTYPE html>
<html>
  <head>
  <title>Baggage Tracking System</title>
	<script>
		function getData()
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("text1").value = this.responseText;
				}
			};
		//	console.log(this.responseText);
			xmlhttp.open("GET", "Sql.php", true);
			xmlhttp.send();
			var myVar = setTimeout(getData,1000);
		//	alert('hello');
		}
		getData();
	</script>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
  crossorigin=""/>

    <link rel="stylesheet" href="style.css">
  </head>
  <div id="div1">
	<input type="text" id = "text1">
	Distance : <input type="text" id = "text2">
  </div>
  <body>
    <button onclick="getLocation()">Track Baggage</button>
     <div id="mapid"></div>
     <div id="map"></div>
     <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
      integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
      crossorigin=""></script>
	<script>
	var string = document.getElementById("text1").value;
		var array;
		var lat;
		var lon;
		var mymap;
		var marker;
		
		var marker1;
		var lat1;
		var lon1;
		var lat2;
		var lon2;
		var dist;
		
		var pos;
		var markerArray = [];
		
	function getLocation() 
	{
		if (navigator.geolocation) 
		{
			navigator.geolocation.getCurrentPosition(showPosition);
		//	showPositiongps();
		}
		

	}
	function showPosition(position) {
		 
		pos = position;
		
		if(mymap == undefined)
		{
			mymap = L.map('mapid').setView([ position.coords.latitude,position.coords.longitude], 18);
		    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
			  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			  maxZoom: 18,
			  id: 'mapbox.streets',
			  accessToken: 'pk.eyJ1IjoibXVraWxhbm4iLCJhIjoiY2pseTR2cWluMWl0ajNrcDFwNXRtMHJxYyJ9.RkN6Cf6Z9ZUQcp8G6bc-lw'
		    }).addTo(mymap);
			 marker = L.marker([position.coords.latitude,position.coords.longitude]).addTo(mymap).bindPopup("My Location");
		}	
		console.log('1 => '+pos);
		showPositiongps();
		
	function showPositiongps()
	{
				console.log('2 => '+pos);
		 string = document.getElementById("text1").value;
		 array = string.split(",");
		 lat = array[0];
		 lon = array[1];
		 for(var i=0;i<markerArray.length;i++) {
			 mymap.removeLayer(markerArray[i]);
		 }
		 marker1 = L.marker([lat,lon]).addTo(mymap).bindPopup("Baggage");
		markerArray.push(marker1);
		
		console.log(lat);
		console.log(lon);

		 lat1=pos.coords.latitude;
		 lon1=pos.coords.longitude;
		 lat2=lat;
	     lon2=lon;
		 
		function distance(lat1, lon1, lat2, lon2) {
			var radlat1 = Math.PI * lat1/180
			var radlat2 = Math.PI * lat2/180
			var theta = lon1-lon2
			var radtheta = Math.PI * theta/180
			 dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
			if (dist > 1) {
				dist = 1;
			}
			dist = Math.acos(dist)
			dist = dist * 180/Math.PI
			dist = dist * 60 * 1.1515
			dist *= 1.609344
		  return dist;
		}
		document.getElementById("text2").value = distance(lat1,lon1,lat2,lon2);
				setTimeout(showPositiongps,100);
		}
	}

	</script>


  </body>
</html>
