<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Map</title>
	<script type="text/javascript" src="js/maps.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <style>
        html {
            height: 100%;
            overflow: hidden;
        }
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #map_canvas {
            height: 100%;
        }
    </style>
</head>
<body onload="initialize()">
    <div id="map_canvas"></div>
</body>
</html>