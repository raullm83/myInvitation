/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');

        console.log('Received Event: ' + id);
    },
    openNativeAppWindow: function(data) {
    window.open(data, '_system');
}
};

// popup examples
$( document ).on( "pagecreate", function() {
    // The window width and height are decreased by 30 to take the tolerance of 15 pixels at each side into account
    function scale( width, height, padding, border ) {
        var scrWidth = $( window ).width() - 30,
            scrHeight = $( window ).height() - 30,
            ifrPadding = 2 * padding,
            ifrBorder = 2 * border,
            ifrWidth = width + ifrPadding + ifrBorder,
            ifrHeight = height + ifrPadding + ifrBorder,
            h, w;
        if ( ifrWidth < scrWidth && ifrHeight < scrHeight ) {
            w = ifrWidth;
            h = ifrHeight;
        } else if ( ( ifrWidth / scrWidth ) > ( ifrHeight / scrHeight ) ) {
            w = scrWidth;
            h = ( scrWidth / ifrWidth ) * ifrHeight;
        } else {
            h = scrHeight;
            w = ( scrHeight / ifrHeight ) * ifrWidth;
        }
        return {
            'width': w - ( ifrPadding + ifrBorder ),
            'height': h - ( ifrPadding + ifrBorder )
        };
    };
    $( ".ui-popup iframe" )
        .attr( "width", 0 )
        .attr( "height", "auto" );

	$( "div[id^='popupMap'] iframe").each(function (index){
		var idPopUp = "popupMap" + (1 + index);
		var idPopUpFrame = idPopUp + " iframe";
		$( "#" + idPopUpFrame ).contents().find( "#map_canvas" )
        	.css( { "width" : 0, "height" : 0 } );
	    $( "#" + idPopUp ).on({
	        popupbeforeposition: function() {
	            var size = scale( 480, 320, 0, 1 ),
	                w = size.width,
	                h = size.height;
	            $( "#" + idPopUpFrame )
	                .attr( "width", w )
	                .attr( "height", h );
	            $( "#" + idPopUpFrame ).contents().find( "#map_canvas" )
	                .css( { "width": w, "height" : h } );
	        },
	        popupafterclose: function() {
	            $( "#" + idPopUpFrame )
	                .attr( "width", 0 )
	                .attr( "height", 0 );
	            $( "#" + idPopUpFrame ).contents().find( "#map_canvas" )
	                .css( { "width": 0, "height" : 0 } );
	        }
	    });
	});
});

